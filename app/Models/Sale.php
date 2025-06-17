<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @SWG\Definition(
 *      definition="Sale",

 */
class Sale extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public $table = 'sales';
    public $days = [];
    public $with = ['sale_state', 'customer'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'store_id',
        'customer_id',
        'sale_state_id',
        'date_sale',
        'date_pay',
        'note',
        'total_price',
        'coupon_code',
        'days_to_confirm',
        'days_to_cancel',
        'user'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'customer_id' => 'integer',
        'sale_state_id' => 'integer',
        'date_sale' => 'date',
        'date_pay' => 'date',
        'note' => 'string',
        'days_to_confirm' => 'integer',
        'days_to_cancel' => 'integer',
        'total_price' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'store_id' => 'required|integer',
        'date_sale' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function sale_state()
    {
        return $this->belongsTo('App\Models\SaleState');
    }

    public function products(){

        return $this->belongsToMany(Product::class, 'sale_items')->as('sale_item')
            ->withPivot('product_id', 'price');
    }


}
