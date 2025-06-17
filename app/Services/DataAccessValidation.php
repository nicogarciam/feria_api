<?php
namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class DataAccessValidation
{
    public function validateStore($store_id)
    {
        if (!$store_id) {
            return true;
        }

        $stores = $this->getCheckStores();

        $tmp = [];
        if (isset($stores)) {
            $tmp = Arr::pluck($stores, 'id');
        }

        return in_array($store_id, $tmp);
    }


    public function validateProducts($productIds)
    {
        if (empty($productIds) || sizeof($productIds) < 1 ) {
            return [];
        }

        $stores = $this->getCheckStores();
        $store_id =  session()->get('store_id');

        $tmp = [];
        if (isset($stores)) {
            $tmp = Arr::pluck($stores, 'id');
        }

        $unautorizedProducts = [];
        //dd($tmp);
        $validProductsIds = DB::table('products')
            ->whereIn('store_id', $tmp)
            ->select('id')
            ->get();


        foreach ($productIds as $prodId) {
            $valid = $validProductsIds->contains('id','==',$prodId);
            if (!$valid) {
                $unautorizedProducts[] = $prodId;
            }
        }

        return $unautorizedProducts;
    }

    public function validateSale($saleId)
    {
        if (!$saleId ) {
            return true;
        }

        $stores = $this->getCheckStores();


        if (isset($stores)) {
            $tmp = Arr::pluck($stores, 'id');
        }


        $res = DB::table('sales')
            ->whereIn('store_id', $tmp)
            ->where('id',$saleId)
            ->get();

        return !$res->isEmpty();
    }


    public function getCheckStores() {

        if (session()->exists('stores')) {
            $stores = session()->get('stores');
        } else {
            $stores = Auth::user()->myStores();
            session()->put('stores', $stores);
        }

        return $stores->toArray();
    }
}
