<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Discount",
 *      required={"store_id", "date_from", "date_to", "description", "discount"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="Discount id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="store_id",
 *          description="Store id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date_from",
 *          description="Discount start date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="date_to",
 *          description="Discount end date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="Discount description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="limit_discount",
 *          description="Limit discount",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="Category id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="product_id",
 *          description="Product id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="discount",
 *          description="Discount amount",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="active",
 *          description="Active flag",
 *          type="boolean"
 *      )
 * )
 */
class Discount extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'discounts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'store_id',
        'date_from',
        'date_to',
        'description',
        'limit_discount',
        'category_id',
        'product_id',
        'discount',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'date_from' => 'date',
        'date_to' => 'date',
        'description' => 'string',
        'limit_discount' => 'float',
        'category_id' => 'integer',
        'discount' => 'float',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'store_id' => 'required|integer',
        'date_from' => 'required',
        'date_to' => 'required',
        'description' => 'required|string|max:255',
        'discount' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
}
