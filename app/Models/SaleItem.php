<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SaleItem extends Model
{
    use HasFactory;

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public $table = 'sale_items';

//    public $with = 'product';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'sale_id',
        'product_id',
        'price',
        'settled',
        'settlement_id',
        'status',
        'quantity'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sale_id' => 'integer',
        'product_id' => 'integer',
        'settled' => 'boolean',
        'settlement_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function settlement()
    {
        return $this->belongsTo('App\Models\Settlement');
    }

    public function settlementDetail()
    {
        return $this->hasOne('App\Models\SettlementDetail');
    }

}
