<?php

namespace App\Repositories;

use App\Models\PaymentState;
use App\Models\ProductState;
use App\Repositories\BaseRepository;


class ProductStateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return ProductState::class;
    }
}
