<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movement extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'movements';

    protected $dates = ['deleted_at'];

    protected $appends = ['balance'];
    public $balance;

    private $types = [
        'DEBIT' =>  -1,
        'CREDIT' => 1
    ];


    public $fillable = [
        'date',
        'sale_id',
        'customer_id',
        'account_id',
        'provider_id',
        'store_id',
        'pay_id',
        'withdrawal_id',
        'settlement_id',
        'concept',
        'amount',
        'type',
        'state',
        'user',
        'user_id',
        'cash_account_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'concept' => 'string',
        'amount' => 'float',
        'type' => 'string',
        'state' => 'string',
        'user' => 'string',
        'withdrawal_id' => 'integer',
        'settlement_id' => 'integer',
        'description' => 'string',
        'cash_account_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'required',
        'concept' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'type' => 'required|string|max:255',
    ];

    public function getBalanceAttribute()
    {
        return $this->balance;
    }

    public function calculateBalance($balance_acum) {
        return $this->balance = $balance_acum + ( $this->types[$this->type] * $this->amount);
    }

    public function getMovement(){

        return ( $this->types[$this->type] * $this->amount);
    }


    public function matchesCriteria($criteria)
    {
        //"store_id": 3,
        // "cash_account_id": 1

        foreach ($criteria as $key => $value) {
            if ($this->getAttribute($key) != $value) {
                return false;
            }
        }
        return true;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function cashAccount()
    {
        return $this->belongsTo(CashAccount::class);
    }


}
