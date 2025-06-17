<?php

namespace App\Models;

use Eloquent as Model;


class Image extends Model
{

    public $table = 'images';


    public $fillable = [
        'title',
        'primary',
        'benefit_id',
        'hotel_id',
        'activity_id',
        'src'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

}
