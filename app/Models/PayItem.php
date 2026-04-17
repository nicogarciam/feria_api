<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="PayItem",
 *      required={"date"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="PayItem id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="concept",
 *          description="Concept",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="date",
 *          description="Date",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="paid",
 *          description="Paid flag",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="Amount",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="ref_id",
 *          description="Reference id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="payment_id",
 *          description="Payment id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class PayItem extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'pay_items';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'concept',
        'date',
        'paid',
        'amount',
        'ref_id',
        'payment_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'concept' => 'string',
        'paid' => 'boolean',
        'amount' => 'double',
        'ref_id' => 'integer',
        'pay_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function pay()
    {
        return $this->belongsTo('App\Models\Pay');
    }
}
