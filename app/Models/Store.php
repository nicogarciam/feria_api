<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Store",
 *      required={"name"},
 *      @SWG\Property(
 *          property="id",
 *          type="integer",
 *          format="int64"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="latitud",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="longitud",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="city_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="owner_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="facebook",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="instagram",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="state",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="logo",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          type="string"
 *      )
 * )
 */
class Store extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'stores';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email',
        'address',
        'latitud',
        'longitud',
        'city_id',
        'owner_id',
        'facebook',
        'instagram',
        'phone',
        'state',
        'logo',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'address' => 'string',
        'latitud' => 'float',
        'longitud' => 'float',
        'city_id' => 'integer',
        'facebook' => 'string',
        'instagram' => 'string',
        'phone' => 'string',
        'state' => 'string',
        'logo' => 'string',
        'description' => 'string',
        'owner_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'string|max:255',
        'address' => 'string|max:255',
        'city_id' => 'integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_store', 'store_id', 'user_id')
                    ->withPivot('role', 'active')
                    ->withTimestamps();
    }

    public function cashAccounts()
    {
        return $this->hasMany(CashAccount::class);
    }

    public function defaultCashAccount()
    {
        return $this->hasOne(CashAccount::class)->where('is_default', true);
    }
}
