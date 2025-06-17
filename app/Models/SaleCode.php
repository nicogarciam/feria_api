<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleCode extends Model
{
    use HasFactory;

    public $table = 'sales_codes';


    public $fillable = [
        'h_id',
        'year',
        'sec',
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'h_id' => 'integer',
        'year' => 'integer',
        'sec' => 'integer',
        'code' => 'string',
    ];

}
