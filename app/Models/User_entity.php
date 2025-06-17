<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_entity extends Model
{
    use SoftDeletes;

    public $table = 'user_entities';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'entity_id',
        'authority',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'authority' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
