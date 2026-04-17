<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Provider extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'providers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $with = ['city'];

    public $fillable = [
        'name',
        'cuil',
        'contact_name',
        'email',
        'address',
        'token',
        'password',
        'city_id',
        'phone',
        'fee',
        'alias',
        'bank'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'cuil' => 'string',
        'email' => 'string',
        'address' => 'string',
        'token' => 'string',
        'password' => 'string',
        'city_id' => 'integer',
        'phone' => 'string',
        'fee' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function settlements()
    {
        return $this->hasMany('App\Models\Settlement');
    }

}
