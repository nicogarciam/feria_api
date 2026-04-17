<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Category",
 *      required={"name"},
 *
 *      @SWG\Property(
 *          property="id",
 *          description="Category id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="Category name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="Category description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="Parent category id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="color",
 *          description="Category color",
 *          type="string"
 *      )
 * )
 */
class Category extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'categories';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'description',
        'category_id',
        'color',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'color' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];
}
