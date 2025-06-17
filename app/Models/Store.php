<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

}
