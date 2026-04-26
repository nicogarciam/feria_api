<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashAccount extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'cash_accounts';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'store_id',
        'balance',
        'is_default'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'store_id' => 'integer',
        'balance' => 'float',
        'is_default' => 'boolean'
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'store_id' => 'required|integer',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
