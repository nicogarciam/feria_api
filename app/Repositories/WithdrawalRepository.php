<?php

namespace App\Repositories;

use App\Models\Withdrawal;
use App\Repositories\BaseRepository;

class WithdrawalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date',
        'amount',
        'concept',
        'description',
        'store_id',
        'user'
    ];

    protected $fieldLikeable = [
        'date',
        'amount',
        'concept',
        'description',
        'store_id',
        'user'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Withdrawal::class;
    }


}
