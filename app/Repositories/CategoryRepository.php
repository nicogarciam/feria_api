<?php

namespace App\Repositories;

use App\Models\Accommodation;
use App\Models\Category;
use App\Repositories\BaseRepository;
use function PHPUnit\Framework\isEmpty;

/**
 * Class AccommodationTypeRepository
 * @package App\Repositories
 * @version July 27, 2022, 4:31 pm UTC
*/

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'color'
    ];

    protected $fieldLikeable = [
        'name',
        'description',
    ];


    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }
}
