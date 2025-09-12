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
        'provider_id'
    ];

    protected $fieldLikeable = [
        'code',
        'description',
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


}
