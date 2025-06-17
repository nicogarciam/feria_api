<?php
namespace App\Services;

use App\Models\Movement;
use App\Models\Provider;
use App\Repositories\MovementRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MovementsService
{

    protected $movementRepository;

    public function __constructor(MovementRepository $repo)
    {
        $this->movementRepository = $repo;
    }
    public function generateSaleDebit($sale)
    {
        $movement = new Movement();
        $movement->sale_id = $sale->id;
        $movement->store_id = $sale->store_id;
        $movement->customer_id = $sale->customer_id;
        $movement->date = $sale->date_sale;
        $movement->concept = 'sale-' . $sale->code;
        $movement->amount = $sale->total_price;
        $movement->type = 'DEBIT';
        $movement->user = $sale->user;
        $movement->state = 'CREATED';
        $movement->save();
    }


    public function generatePayCredit($pay)
    {
        $movement = new Movement();
        $movement->pay_id = $pay->id;
        $movement->store_id = $pay->store_id;
        $movement->customer_id = $pay->payer_id;
        $movement->account_id = $pay->bank_account_id;

        $movement->date = $pay->pay_date;
        $movement->concept = $pay->concept;
        $movement->amount = $pay->amount;
        $movement->type = 'CREDIT';
        $movement->user = $pay->user;
        $movement->state = 'CREATED';
        $movement->save();
    }


    public function generateProviderCredit($product, $sale )
    {
        $movement = new Movement();
        $movement->sale_id = $sale->id;
        $movement->store_id = $product['store_id'];
        $movement->provider_id = $product['provider_id'];
        $movement->date = $sale->date_sale;
        $fee = $product['fee'] ?? Provider::where('id',$product['provider_id'])->first()->fee;
        $movement->concept = 'SALE - cod: ' . $product['code'] . ' ' . $fee .
            ' % de $' . number_format($product['price'],2) ;
        $movement->amount = $product['price'] * (1 - $fee);
        $movement->type = 'CREDIT';
        $movement->user = $sale->user;
        $movement->state = 'CREATED';
        $movement->save();
    }


    public function generateProviderDebit( )
    {
//        $movement = new Movement();
//        $movement->store_id = $product['store_id'];
//        $movement->provider_id = $product['provider_id'];
//        $movement->date = $sale->date_sale;
//        $movement->concept = ' - product: ' . $product['code'] . ' - product: ' . $product['description'] .
//            ' $ ' . $product['price'] ;
//        $movement->amount = $product['price'] * (1 - $product['fee']);
//        $movement->type = 'CREDIT';
//        $movement->user = $sale->user;
//        $movement->state = 'CREATED';
//        $movement->save();
    }

    public function generateChargeDebit($charge)
    {
        $movement = new Movement();
        $movement->store_id = $charge->store_id;

        $movement->date = $charge->date;
        $movement->concept = $charge->description;
        $movement->amount = $charge->amount;
        $movement->type = 'DEBIT';
        $movement->user = $charge->user;
        $movement->state = 'CREATED';
        $movement->save();
    }




}
