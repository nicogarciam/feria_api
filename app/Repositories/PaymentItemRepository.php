<?php

namespace App\Repositories;

use App\Models\PaymentItem;
use App\Repositories\BaseRepository;

/**
 * Class PaymentItemRepository
 * @package App\Repositories
 * @version July 27, 2022, 7:06 pm UTC
*/

class PaymentItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payment_id',
        'description',
        'amount'
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
        return PaymentItem::class;
    }
}
