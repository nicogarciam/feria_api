<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Payment",
 *      required={"pay_date", "sale_id", "amount", "user_id"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="Payment id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="pay_date",
 *          description="Payment date",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="sale_id",
 *          description="Sale id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="note",
 *          description="Note",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="Amount",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="discount",
 *          description="Discount amount",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="total",
 *          description="Total amount",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="coupon_code",
 *          description="Coupon code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="payment_type_id",
 *          description="Payment type id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="payment_state_id",
 *          description="Payment state id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="User id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="pay_method",
 *          description="Pay method",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="pay_ref",
 *          description="Payment reference",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="store_id",
 *          description="Store id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="bank_account_id",
 *          description="Bank account id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Payment extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'pay_date',
        'sale_id',
        'note',
        'amount',
        'discount',
        'total',
        'coupon_code',
        'payment_type_id',
        'payment_state_id',
        'user_id',
        'pay_method',
        'pay_ref',
        'store_id',
        'bank_account_id',
        'user',
        'concept'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'customer_id' => 'integer',
        'pay_method' => 'integer',
        'pay_method_dsc' => 'string',
        'pay_ref' => 'string',
        'amount' => 'double',
        'total' => 'double',
        'pay_date' => 'datetime',
        'discount' => 'double',
        'discount_cod' => 'integer',
        'ref_detail' => 'string',
        'type' => 'string',
        'user' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'pay_date' => 'required',
        'sale_id' => 'required|integer',
        'amount' => 'required|numeric',
        'user_id' => 'required|integer'
    ];


    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }
    public function sale()
    {
        return $this->belongsTo('App\Models\Sale');
    }

    public function bankAccount()
    {
        return $this->belongsTo('App\Models\BankAccount');
    }
}
