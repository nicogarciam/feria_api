<?php

namespace App\Repositories;

use App\Models\Settlement;
use App\Models\SettlementDetail;
use App\Models\SaleItem;
use App\Models\Provider;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class SettlementRepository
 * @package App\Repositories
 * @version April 8, 2026, 12:00 pm UTC
*/

class SettlementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'provider_id',
        'start_date',
        'end_date',
        'total_sales',
        'amount_to_pay',
        'status',
        'generated_at',
        'generated_by',
        'paid_at',
        'paid_by',
        'cancelled_at',
        'cancelled_by'
    ];

    protected $fieldLikeable = [
        'provider.name',
    ];

    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Settlement::class;
    }

    /**
     * Get settlements with pagination and filtering
     * @param array $search
     * @param int $skip
     * @param int $limit
     * @param array $orderBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allSettlements($search = [], $orders = null)
    {
        $query = $this->allSettlementsQuery($search, $orders);


        return $query->with(['provider', 'details'])->paginate($limit ?? 10);
    }


    public function allSettlementsQuery($search = [], $orders = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    if ($key == 'date_from') {
                        $query->where('pay_date', '>=', $value);
                    } elseif ($key == 'date_to') {
                        $query->where('pay_date', '<=', $value);
                    } else{
                        $query->where($key, $value);
                    }
                }
            }
        }

        // Handle sorting
        if ($orders) {
            foreach ($orders as $order) {
                $parts = explode(',', $order);
                if (count($parts) === 2) {
                    $query->orderBy($parts[0], $parts[1]);
                }
            }
        } else {
            $query->orderBy('generated_at');
        }

        return $query->with(['provider']);
    }

    /**
     * Get settlement preview data
     * @param int $providerId
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getSettlementPreview($providerId, $startDate, $endDate)
    {
        $provider = Provider::findOrFail($providerId);

        $saleItems = $this->getUnsettledSalesForPeriod($providerId, $startDate, $endDate);

        $totalSales = 0;
        $amountToPay = 0;
        $details = [];

        foreach ($saleItems as $item) {
            $sale = $item->sale;
            $product = $item->product;

            $saleAmount = (float)$item->price;
            $providerPercentage = (float)($product->fee ?? 0);
            $calculatedAmount = ($saleAmount * $providerPercentage) / 100;

            $totalSales += $saleAmount;
            $amountToPay += $calculatedAmount;

            $details[] = [
                'order_item_id' => $item->id,
                'order_id' => $sale->id,
                'sale_date' => $sale->created_at?->format('Y-m-d'),
                'sale_amount' => $saleAmount,
                'provider_percentage' => $providerPercentage,
                'calculated_amount' => $calculatedAmount
            ];
        }

        return [
            'provider_id' => $provider->id,
            'provider_name' => $provider->name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_sales' => round($totalSales, 2),
            'amount_to_pay' => round($amountToPay, 2),
            'sales_count' => count($saleItems),
            'details' => $details
        ];
    }

    /**
     * Create a settlement
     * @param int $providerId
     * @param string $startDate
     * @param string $endDate
     * @param int $generatedBy
     * @return Settlement
     */
    public function createSettlement($providerId, $startDate, $endDate, $generatedBy)
    {
        return DB::transaction(function () use ($providerId, $startDate, $endDate, $generatedBy) {
            // Check for overlapping settlements
            $this->checkForOverlappingSettlements($providerId, $startDate, $endDate);

            // Get preview data
            $preview = $this->getSettlementPreview($providerId, $startDate, $endDate);

            if ($preview['sales_count'] === 0) {
                throw new \Exception('No unsettled sales found for the specified period');
            }

            // Create settlement
            $settlement = Settlement::create([
                'provider_id' => $providerId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_sales' => $preview['total_sales'],
                'amount_to_pay' => $preview['amount_to_pay'],
                'status' => 'pending',
                'generated_at' => Carbon::now(),
                'generated_by' => $generatedBy
            ]);

            // Get unsettled sales and create details
            $saleItems = $this->getUnsettledSalesForPeriod($providerId, $startDate, $endDate);

            foreach ($saleItems as $item) {
                $product = $item->product;
                $saleAmount = (float)$item->price;
                $providerPercentage = (float)($product->fee ?? 0);
                $calculatedAmount = ($saleAmount * $providerPercentage) / 100;

                SettlementDetail::create([
                    'settlement_id' => $settlement->id,
                    'sale_item_id' => $item->id,
                    'sale_amount' => $saleAmount,
                    'product_fee' => $providerPercentage,
                    'calculated_amount' => $calculatedAmount
                ]);

                // Mark sale item as settled
                $item->update([
                    'settled' => true,
                    'settlement_id' => $settlement->id
                ]);
            }

            return $settlement->load('provider', 'details');
        });
    }

    /**
     * Cancel a settlement
     * @param int $settlementId
     * @param int $cancelledBy
     * @return Settlement
     */
    public function cancelSettlement($settlementId, $cancelledBy)
    {
        return DB::transaction(function () use ($settlementId, $cancelledBy) {
            $settlement = Settlement::findOrFail($settlementId);

            if ($settlement->status !== 'pending') {
                throw new \Exception('Can only cancel pending settlements');
            }

            // Revert settled status on sale items
            SaleItem::where('settlement_id', $settlement->id)
                ->update(['settled' => false, 'settlement_id' => null]);

            // Update settlement status
            $settlement->update([
                'status' => 'cancelled',
                'cancelled_at' => Carbon::now(),
                'cancelled_by' => $cancelledBy
            ]);

            return $settlement;
        });
    }

    /**
     * Mark settlement as paid
     * @param int $settlementId
     * @param int $paidBy
     * @return Settlement
     */
    public function markSettlementAsPaid($settlementId, $paidBy)
    {
        $settlement = Settlement::findOrFail($settlementId);

        if ($settlement->status !== 'pending') {
            throw new \Exception('Can only mark pending settlements as paid');
        }

        $settlement->update([
            'status' => 'paid',
            'paid_at' => Carbon::now(),
            'paid_by' => $paidBy
        ]);

        return $settlement;
    }

    /**
     * Get providers with pending settlements for a period
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getProvidersPendingSettlement($startDate = null, $endDate = null)
    {
        // Default end_date to today if not provided
        if (!$endDate) {
            $endDate = Carbon::today()->toDateString();
        }

        // Default start_date to last settlement or a default period
        if (!$startDate) {
            $startDate = Carbon::today()->subMonth()->toDateString();
        }

        // Get all unsettled items for the period grouped by provider
        $saleItems = SaleItem::with(['product', 'sale', 'product.provider'])
            ->where('settled', false)
            ->whereHas('sale', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->get();

        $providers = [];

        foreach ($saleItems as $item) {
            if (!$item->product || !$item->product->provider) {
                continue;
            }

            $provider = $item->product->provider;
            $saleAmount = (float)$item->price;
            $productPercentage = (float)($item->product->fee ?? 0);
            $calculatedAmount = ($saleAmount * $productPercentage) / 100;

            if (!isset($providers[$provider->id])) {
                $providers[$provider->id] = [
                    'provider_id' => $provider->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'amount_to_pay' => 0,
                    'items_count' => 0,
                    'total_sales' => 0,
                    'provider_name' => $provider->name,
                    'provider' => $provider,

                ];
            }

            $providers[$provider->id]['total_sales'] += $saleAmount;
            $providers[$provider->id]['amount_to_pay'] += $calculatedAmount;
            $providers[$provider->id]['items_count'] += 1;
            $seattleDetail['sale_item_id'] = $item->id;
            $seattleDetail['sale_amount'] = $item->price;
            $seattleDetail['product_fee'] = $item->product->fee;
            $seattleDetail['calculated_amount'] = $calculatedAmount;
            $seattleDetail['customer'] = $item->sale->customer;
            $seattleDetail['product'] = $item->product;

            unset($seattleDetail['product']['provider']);
            unset($seattleDetail['product']['category']);
            unset($seattleDetail['product']['state']);

            $providers[$provider->id]['settle_details'][] = $seattleDetail;
        }

        // Round amounts
        foreach ($providers as &$provider) {
            $provider['total_sales'] = round($provider['total_sales'], 2);
            $provider['amount_to_pay'] = round($provider['amount_to_pay'], 2);
        }

        return array_values($providers);
    }

    /**
     * Get unsettled sales for a provider in a period
     * @param int $providerId
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUnsettledSalesForPeriod($providerId, $startDate, $endDate)
    {
        return SaleItem::with(['product', 'sale'])
            ->where('settled', false)
            ->whereHas('product', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
            ->whereHas('sale', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->get();
    }

    /**
     * Check for overlapping settlements
     * @param int $providerId
     * @param string $startDate
     * @param string $endDate
     * @return void
     */
    private function checkForOverlappingSettlements($providerId, $startDate, $endDate)
    {
        // Check if any sale in the period is already settled for this provider
        $settledSales = SaleItem::where('settled', true)
            ->whereHas('product', function ($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
            ->whereHas('sale', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->exists();

        if ($settledSales) {
            throw new \Exception('Period overlaps with existing settlements for this provider');
        }
    }
}
