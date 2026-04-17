<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductState;
use App\Models\Provider;
use App\Models\Settlement;
use App\Repositories\BaseRepository;

class ProviderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'cuil',
        'contact_name',
        'email',
        'phone',
        'address',
        'token',
        'password',
        'city_id'
    ];


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
        return Provider::class;
    }


    protected $fieldLikeable = [
        'name',
        'email',
        'cuil'
    ];


    public function allLike($search , $skip = null, $limit = null, $where = null)
    {
        $query = $this->model->newQuery();
        $this->search = $search;

        $query->with('city');

        if ($search) {
            $fields = $this->getFieldsLikeable();
            foreach($fields as $field) {
                $query->orWhere($field, 'like',  "%$search%");
            }
        }

        if ($where) {
            foreach($where as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query->get();
    }



     /**
     * Get provider statistics for a specific store
     *
     * @param int $providerId
     * @param int $storeId
     * @return array
     */
    public function getProviderStoreStats($providerId, $storeId)
    {
        return [
            'totalSales' => $this->calculateTotalSales($providerId, $storeId),
            'totalPaid' => $this->calculateTotalPaid($providerId, $storeId),
            'pendingBalance' => $this->calculatePendingBalance($providerId, $storeId),
            'activeProducts' => $this->countActiveProducts($providerId, $storeId),
            'totalProducts' => $this->countTotalProducts($providerId, $storeId)
        ];
    }

    /**
     * Calculate total sales (all confirmed sales)
     *
     * @param int $providerId
     * @param int $storeId
     * @return float
     */
    private function calculateTotalSales($providerId, $storeId)
    {
        return (float) Settlement::where('provider_id', $providerId)
            ->where('store_id', $storeId)
            ->whereIn('status', ['pending', 'paid'])
            ->sum('total_sales');
    }

    /**
     * Calculate total amount already paid
     *
     * @param int $providerId
     * @param int $storeId
     * @return float
     */
    private function calculateTotalPaid($providerId, $storeId)
    {
        return (float) Settlement::where('provider_id', $providerId)
            ->where('store_id', $storeId)
            ->where('status', 'paid')
            ->sum('amount_to_pay');
    }

    /**
     * Calculate pending balance (not yet paid)
     *
     * @param int $providerId
     * @param int $storeId
     * @return float
     */
    private function calculatePendingBalance($providerId, $storeId)
    {
        $pending = Settlement::where('provider_id', $providerId)
            ->where('store_id', $storeId)
            ->where('status', 'pending')
            ->sum('amount_to_pay');

        return (float) $pending;
    }

    /**
     * Count active/available products
     *
     * @param int $providerId
     * @param int $storeId
     * @return int
     */
    private function countActiveProducts($providerId, $storeId)
    {
        return (int) Product::where('provider_id', $providerId)
            ->where('store_id', $storeId)
            ->where('state_id', ProductState::AVAILABLE)
            ->count();
    }

    /**
     * Count total products (excluding deleted)
     *
     * @param int $providerId
     * @param int $storeId
     * @return int
     */
    private function countTotalProducts($providerId, $storeId)
    {
        return (int) Product::where('provider_id', $providerId)
            ->where('store_id', $storeId)
            ->count();
    }

    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }
}
