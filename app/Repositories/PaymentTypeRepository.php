<?php

namespace App\Repositories;

use App\Models\PaymentType;
use App\Repositories\BaseRepository;

/**
 * Class PaymentTypeRepository
 * @package App\Repositories
 * @version July 27, 2022, 7:06 pm UTC
*/

class PaymentTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'active'
    ];

    protected $fieldLikeable = [
        'firstName',
        'lastName',
        'email',
        'dni'
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
        return PaymentType::class;
    }
}
