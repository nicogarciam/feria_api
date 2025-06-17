<?php

namespace App\Repositories;

use App\Models\BankAccount;
use App\Repositories\BaseRepository;

/**
 * Class BankAccountRepository
 * @package App\Repositories
 * @version December 28, 2022, 4:51 pm -03
*/

class BankAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'hotel_id',
        'bank',
        'cbu',
        'cvu',
        'alias'
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
        return BankAccount::class;
    }
}
