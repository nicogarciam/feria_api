<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Account",

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
    public static $rules = [
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

}
