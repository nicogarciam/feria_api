<?php
namespace App\Services;

use App\Models\CashAccount;
use App\Models\Movement;
use App\Models\Provider;
use App\Models\Store;
use App\Repositories\MovementRepository;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MovementsService
{

    protected $movementRepository;

    public function __construct(MovementRepository $repo)
    {
        $this->movementRepository = $repo;
    }

    static function getDefaultCashAccount($storeId)
    {
        $store = Store::find($storeId);
        if (!$store) return null;

        $account = $store->defaultCashAccount;
        if (!$account) {
            $account = CashAccount::create([
                'name' => 'Caja Principal',
                'store_id' => $storeId,
                'is_default' => true,
                'balance' => 0
            ]);
        }
        return $account;
    }

    static function generateWithdrawalMovement($withdrawal)
    {
        $cashAccount = self::getDefaultCashAccount($withdrawal->store_id);

        $movementStore = Movement::updateOrCreate(
            ['withdrawal_id' => $withdrawal->id, 'store_id' => $withdrawal->store_id],
            [
                'store_id' => $withdrawal->store_id,
                'cash_account_id' => $cashAccount?->id,
                'date' => $withdrawal->date,
                'concept' => $withdrawal->concept,
                'description' => $withdrawal->description,
                'amount' => $withdrawal->amount,
                'type' => 'DEBIT',
                'user' => $withdrawal->user,
                'state' => 'CREATED',
            ]
        );

        $movementUser = Movement::updateOrCreate(
            ['withdrawal_id' => $withdrawal->id, 'user_id' => $withdrawal->user_payee_id],
            [
                'user_id' => $withdrawal->user_payee_id,
                'store_id' => $withdrawal->store_id,
                'date' => $withdrawal->date,
                'concept' => $withdrawal->concept,
                'description' => $withdrawal->description,
                'amount' => $withdrawal->amount,
                'type' => 'CREDIT',
                'user' => $withdrawal->user,
                'state' => 'CREATED',
            ]
        );

        $movements = [$movementStore, $movementUser];
        return $movements;
    }

    static function generateSettlementMovement($settlement, $user)
    {
        $cashAccountId = $settlement->cash_account_id;
        $userId = $settlement->origin_user_id;

        // Si no hay origen definido, usamos la caja por defecto de la tienda
        if (!$cashAccountId && !$userId) {
            $cashAccount = self::getDefaultCashAccount($settlement->store_id);
            $cashAccountId = $cashAccount?->id;
        }

        $movement = Movement::updateOrCreate(
            ['settlement_id' => $settlement->id],
            [
                'store_id' => $settlement->store_id,
                'cash_account_id' => $cashAccountId,
                'user_id' => $userId,
                'date' => $settlement->paid_at ?? $settlement->generated_at,
                'concept' => 'Liquidación a ' . ($settlement->provider?->name ?? 'Proveedor'),
                'amount' => $settlement->amount_to_pay,
                'type' => 'DEBIT',
                'user' => $user->email,
                'state' => 'CREATED',
            ]
        );
        return $movement;
    }

    static function generateSaleDebit($sale)
    {
        $cashAccount = self::getDefaultCashAccount($sale->store_id);

        $movement = Movement::updateOrCreate(
            ['sale_id' => $sale->id, 'type' => 'DEBIT'],
            [
                'store_id' => $sale->store_id,
                'cash_account_id' => $cashAccount?->id,
                'customer_id' => $sale->customer_id,
                'date' => $sale->date_sale,
                'concept' => 'sale-' . $sale->code,
                'amount' => $sale->total_price,
                'type' => 'DEBIT',
                'user' => $sale->user,
                'state' => 'CREATED',
            ]
        );
    }


    static function generatePayCredit($pay)
    {
        $cashAccount = self::getDefaultCashAccount($pay->store_id);

        $movement = Movement::create(
           [
                'store_id' => $pay->store_id,
                'cash_account_id' => $cashAccount?->id,
                'customer_id' => $pay->customer_id,
                'account_id' => $pay->bank_account_id,
                'date' => $pay->pay_date,
                'concept' => $pay->concept,
                'amount' => $pay->amount,
                'type' => 'CREDIT',
                'user' => $pay->user,
                'state' => 'CREATED',
                'pay_id' => $pay->id,
            ]
        );
    }


    static function generateProviderCredit($product, $sale )
    {

        $movement = new Movement();
        $movement->sale_id = $sale->id;
        $movement->store_id = $product['store_id'];
        $movement->provider_id = $product['provider_id'];
        $movement->date = Carbon::today() ;
        $fee = $product['fee'] ?? Provider::where('id',$product['provider_id'])->first()->fee;
        $price = $product['pivot']['price'] ?? $product['price'];
        $movement->concept = 'SALE - cod: ' . $product['code'] . ' ' . $fee .
            ' % de $' . number_format($price,2) ;
        $movement->amount = $price * (1 - $fee);
        $movement->type = 'CREDIT';
        $movement->user = $sale->user;
        $movement->state = 'CREATED';
        $movement->save();
    }


    public function generateProviderDebit( )
    {
    }

    static function generateChargeDebit($charge)
    {
        $cashAccount = self::getDefaultCashAccount($charge->store_id);

        $movement = new Movement();
        $movement->store_id = $charge->store_id;
        $movement->cash_account_id = $cashAccount?->id;

        $movement->date = $charge->date;
        $movement->concept = $charge->description;
        $movement->amount = $charge->amount;
        $movement->type = 'DEBIT';
        $movement->user = $charge->user;
        $movement->state = 'CREATED';
        $movement->save();
    }
}
