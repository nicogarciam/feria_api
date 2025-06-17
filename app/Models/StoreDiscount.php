<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="StoreDiscount",
 *      required={"booking_id", "description", "discount"},
 */
class StoreDiscount extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'store_discounts';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'sale_id',
        'discount_id',
        'description',
        'discount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sale_id' => 'integer',
        'discount_id' => 'integer',
        'description' => 'string',
        'discount' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'sale_id' => 'required',
        'discount' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
