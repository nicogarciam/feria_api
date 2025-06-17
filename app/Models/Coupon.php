<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Coupon",
 *      required={"hotel_id", "code", "description", "limit_discount", "accommodation_type_id", "discount", "date_to", "state"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="hotel_id",
 *          description="hotel_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="limit_discount",
 *          description="limit_discount",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="accommodation_type_id",
 *          description="accommodation_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="discount",
 *          description="discount",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="date_to",
 *          description="date_to",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="state",
 *          description="state",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="deleted_at",
 *          description="deleted_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Coupon extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'coupons';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'hotel_id',
        'code',
        'description',
        'limit_discount',
        'accommodation_type_id',
        'discount',
        'date_to',
        'state'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hotel_id' => 'integer',
        'code' => 'string',
        'description' => 'string',
        'limit_discount' => 'float',
        'accommodation_type_id' => 'integer',
        'discount' => 'float',
        'date_to' => 'date',
        'state' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'hotel_id' => 'required|integer',
        'code' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'limit_discount' => 'required|numeric',
        'accommodation_type_id' => 'required|integer',
        'discount' => 'required|numeric',
        'date_to' => 'required',
        'state' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
