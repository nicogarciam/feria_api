<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'withdrawals';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'date',
        'amount',
        'concept',
        'description',
        'store_id',
        'user',
        'user_payee_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'amount' => 'float',
        'concept' => 'string',
        'description' => 'string',
        'store_id' => 'integer',
        'user' => 'string',
        'user_payee_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'required|date',
        'amount' => 'required|numeric|min:0.01',
        'concept' => 'required|string|max:255',
        'description' => 'nullable|string',
        'store_id' => 'required|integer',
        'user_payee_id' => 'required|integer'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
