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
        'concept',
        'amount',
        'type',
        'state',
        'user'
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
        'user' => 'string'
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

    public function calculateBalance($balance_acum){

        return $this->balance = $balance_acum + ( $this->types[$this->type] * $this->amount);
    }


}
