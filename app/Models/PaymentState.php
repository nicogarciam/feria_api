<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PaymentState extends Model
{

    use HasFactory;

    public $table = 'payment_states';


    protected $dates = ['deleted_at'];

    const CONFIRMED = 1;
    const PENDING_CONFIRM = 2;
    const CANCELED = 3;
    const REFUNDED = 4;
    const PENDING_PAYMENT = 5;
    const PENDING_APPROVAL = 6;
    const PENDING_REFUND = 7;


    public $fillable = [
        'name',
        'description',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:50',
    ];


}
