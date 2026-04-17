<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settlement extends Model
{
    use HasFactory;

    public $table = 'settlements';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['start_date', 'end_date', 'generated_at', 'paid_at', 'cancelled_at'];

    // status 'pending', 'paid', 'cancelled'

    public $fillable = [
        'store_id',
        'provider_id',
        'start_date',
        'end_date',
        'total_sales',
        'amount_to_pay',
        'status',
        'generated_at',
        'generated_by',
        'paid_at',
        'paid_by',
        'cancelled_at',
        'cancelled_by',
        'user'
    ];

    protected $casts = [
        'id' => 'integer',
        'provider_id' => 'integer',
        'total_sales' => 'decimal:2',
        'amount_to_pay' => 'decimal:2',
        'generated_by' => 'integer',
        'paid_by' => 'integer',
        'cancelled_by' => 'integer'
    ];

    /**
     * Validation rules
     */
    public static $rules = [
        'provider_id' => 'required|integer|exists:providers,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ];

    /**
     * Relationships
     */

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function provider()
    {
        return $this->belongsTo('App\Models\Provider');
    }

    public function settle_details()
    {
        return $this->hasMany('App\Models\SettlementDetail');
    }

    public function generatedBy()
    {
        return $this->belongsTo('App\Models\User', 'generated_by');
    }

    public function paidBy()
    {
        return $this->belongsTo('App\Models\User', 'paid_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo('App\Models\User', 'cancelled_by');
    }

    /**
     * Scopes
     */
    public function scopeByProvider($query, $providerId)
    {
        return $query->where('provider_id', $providerId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('generated_at', [$startDate, $endDate]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
