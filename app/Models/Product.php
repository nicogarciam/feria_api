<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;


class Product extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'products';

    public $with = ['category','state','provider'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'code',
        'title',
        'brand',
        'description',
        'store_id',
        'provider_id',
        'category_id',
        'state_id',
        'color',
        'size',
        'price',
        'cost',
        'fee'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'store_id' => 'required|integer',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\ProductState');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function provider()
    {
        return $this->belongsTo('App\Models\Provider');
    }

    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

}
