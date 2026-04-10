<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettlementDetail extends Model
{
    use HasFactory;

    public $table = 'settlement_details';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'settlement_id',
        'sale_item_id',
        'sale_amount',
        'product_fee',
        'calculated_amount'
    ];

    protected $casts = [
        'id' => 'integer',
        'settlement_id' => 'integer',
        'sale_item_id' => 'integer',
        'sale_amount' => 'decimal:2',
        'product_fee' => 'decimal:2',
        'calculated_amount' => 'decimal:2'
    ];

    /**
     * Relationships
     */
    public function settlement()
    {
        return $this->belongsTo('App\Models\Settlement');
    }

    public function sale_item()
    {
        return $this->belongsTo('App\Models\SaleItem', 'sale_item_id');
    }
}
