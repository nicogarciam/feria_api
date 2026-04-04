<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="PaymentItem",
 *      required={"payment_id","amount"},
 *      @SWG\Property(
 *          property="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @SWG\Property(
 *          property="payment_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="concept",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          type="number",
 *          format="double"
 *      )
 * )
 */
class PaymentItem extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payment_items';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'payment_id',
        'concept',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'payment_id' => 'required|integer',
        'amount' => 'required|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
}
