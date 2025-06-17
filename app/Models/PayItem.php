<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="PayItem",
 *      required={"date"},

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
