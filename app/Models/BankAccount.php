<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BankAccount extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'bank_accounts';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'store_id',
        'bank',
        'cbu',
        'cvu',
        'alias'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'bank' => 'string',
        'cbu' => 'string',
        'cvu' => 'string',
        'alias' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'store_id' => 'required|integer',
        'bank' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];


}
