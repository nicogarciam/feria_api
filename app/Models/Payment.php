<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Payment",
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
        'user_id',
        'pay_method',
        'pay_ref',
        'amount',
        'payment_state_id',
        'discount',
        'coupon_code',
        'sale_id',
        'user',
        'store_id',
        'bank_account_id'
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
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
    public function bankAccount()
    {
        return $this->belongsTo('App\Models\BankAccount');
    }

}
