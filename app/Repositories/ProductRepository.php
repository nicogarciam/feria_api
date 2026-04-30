<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 * @package App\Repositories
 * @version July 27, 2022, 12:27 pm UTC
*/

class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'description',
        'store_id',
        'category_id',
        'state_id',
        'provider_id',
        'entry_date',
        'gender'
    ];

    protected $fieldLikeable = [
        'code',
        'description',
        'title'
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

    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }

    public function full($id)
    {

        $query = $this->model->newQuery();
        $withs = ['category','state','provider','images'];

        if (count($withs)) {
            foreach($withs as $value) {
                $query->with($value);
            }
        }

        $query->where('id', $id);

        // $query->select('products.*', 'sale_items.id as item_id', 'sale_items.price as item_price');

        return $query->get();
    }

    public function forSaleFull($saleId)
    {

        $query = $this->model->newQuery();
        $withs = ['category','state','provider'];

        if (count($withs)) {
            foreach($withs as $value) {
                $query->with($value);
            }
        }

        $query->join('sale_items', 'products.id', '=', 'sale_items.product_id');
        $query->where('sale_items.sale_id', $saleId);
        $query->select('products.*', 'sale_items.id as item_id', 'sale_items.price as item_price');

        return $query->get();
    }

    public function borrowedProducts($storeId)
    {
        $query = $this->model->newQuery();
        $withs = ['category', 'state', 'provider', 'images'];

        foreach ($withs as $value) {
            $query->with($value);
        }

        $query->where('products.store_id', $storeId);
        $query->where('products.state_id', 2); // 2 = TRIAL

        $query->join('sale_items', 'products.id', '=', 'sale_items.product_id');
        $query->join('sales', 'sale_items.sale_id', '=', 'sales.id');
        $query->leftJoin('customers', 'sales.customer_id', '=', 'customers.id');

        $query->orderBy('sales.created_at', 'desc');

        $query->select(
            'products.*',
            'sales.id as sale_id',
            'sales.code as sale_code',
            'sales.date_sale as date_sale',
            'customers.name as customer_name',
            'customers.phone as customer_phone'
        );

        return $query->get()->unique('id')->values();
    }

    public function allProductsQuery($search = [], $q, $orders = null)
    {
        $query = $this->model->newQuery();


        if ($q && $q != '') {
            $fields = $this->getFieldsLikeable();
            foreach($fields as $field) {
                $query->orWhere($field, 'like',  "%$q%");
            }
        }

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    if ($value != null && is_array($value)) {
                        $query->whereIn($key, $value);
                    }
                    if ($key == 'date_from') {
                        $query->where('entry_date', '>=', $value);
                    } elseif ($key == 'date_to') {
                        $query->where('entry_date', '<=', $value);
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

        return $query->with(['provider', 'state', 'primary_image']);
    }


}
