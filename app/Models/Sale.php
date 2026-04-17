<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @SWG\Definition(
 *      definition="Sale",
 *      required={"store_id", "sale_state_id", "date_sale", "total_price"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="Sale id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="store_id",
 *          description="Store id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="customer_id",
 *          description="Customer id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="sale_state_id",
 *          description="Sale state id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="date_sale",
 *          description="Sale date",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="date_pay",
 *          description="Payment date",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="note",
 *          description="Sale note",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="total_price",
 *          description="Total price",
 *          type="number",
 *          format="double"
 *      ),
 *      @SWG\Property(
 *          property="coupon_code",
 *          description="Coupon code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="days_to_confirm",
 *          description="Days to confirm",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="days_to_cancel",
 *          description="Days to cancel",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user",
 *          description="User name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="Sale code",
 *          type="string"
 *      )
 * )
 */
class Sale extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public $table = 'sales';
    public $days = [];
    public $with = ['sale_state', 'customer'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'store_id',
        'customer_id',
        'sale_state_id',
        'date_sale',
        'date_pay',
        'note',
        'total_price',
        'coupon_code',
        'days_to_confirm',
        'days_to_cancel',
        'user',
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'customer_id' => 'integer',
        'sale_state_id' => 'integer',
        'date_sale' => 'date',
        'date_pay' => 'date',
        'note' => 'string',
        'days_to_confirm' => 'integer',
        'days_to_cancel' => 'integer',
        'total_price' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'store_id' => 'required|integer',
        'date_sale' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    protected $fieldSearchable = [
        'code'
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {

            // Campos propios de Sale
            foreach ($this->fieldSearchable as $field) {
                $q->orWhere($field, 'like', "%{$search}%");
            }

            // Customer
            $q->orWhereHas('customer', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

            // Product (via SaleItem)
            $q->orWhereHas('sale_items.product', function ($q2) use ($search) {
                $q2->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });

            // Provider (via Product)
            $q->orWhereHas('sale_items.product.provider', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        });
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function sale_state()
    {
        return $this->belongsTo('App\Models\SaleState');
    }

    public function sale_items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_items')->as('sale_item')
            ->withPivot('product_id', 'price', 'status', 'quantity');
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function total_paid()
    {
        return $this->payments()->sum('amount');
    }
}
