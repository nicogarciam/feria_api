<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="PaymentType",
 *      required={"name"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="Payment type id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="Payment type name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="Payment type description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="active",
 *          description="Payment type active flag",
 *          type="string"
 *      )
 * )
 */
class PaymentType extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payment_types';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'description',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'active' => 'string'
    ];

    public static $rules = [
        'name' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];
}
