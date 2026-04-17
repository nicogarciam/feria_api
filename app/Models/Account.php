<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Account",
 *      required={"first_name", "last_name", "email"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="Account id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="first_name",
 *          description="First name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last_name",
 *          description="Last name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="activated",
 *          description="Activated status",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="Email address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="langKey",
 *          description="Language key",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="city_id",
 *          description="City id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="gender",
 *          description="Gender",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="image_url",
 *          description="Image URL",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="dni",
 *          description="Document number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="User id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="Account address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="Phone number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="birthday",
 *          description="Birthday",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="account_cod",
 *          description="Account code",
 *          type="string"
 *      )
 * )
 */
class Account extends Model
{
    use SoftDeletes;

    public $table = 'accounts';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'first_name',
        'last_name',
        'activated',
        'email',
        'langKey',
        'city_id',
        'gender',
        'image_url',
        'dni',
        'user_id',
        'address',
        'phone',
        'birthday',
        'account_cod'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'activated' => 'boolean',
        'email' => 'string',
        'langKey' => 'string',
        'city_id' => 'integer',
        'gender' => 'string',
        'image_url' => 'string',
        'user_id' => 'integer',
        'entity_id' => 'integer',
        'birthday' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
