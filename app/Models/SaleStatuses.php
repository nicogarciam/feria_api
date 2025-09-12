<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleStatuses extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'sale_statuses';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'event',
        'note',
        'date_from',
        'date_to',
        'sale_id',
        'state_id',
        'state',
        'user_email'
    ];



    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'event' => 'string',
        'note' => 'string',
        'state' => 'string',
        'date_from' => 'date',
        'date_to' => 'date',
        'sale_id' => 'integer',
        'state_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


    public function state()
    {
        return $this->belongsTo('App\Models\SaleState');
    }

}
