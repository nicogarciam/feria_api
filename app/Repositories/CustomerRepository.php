<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\BaseRepository;

/**
 * Class CustomerRepository
 * @package App\Repositories
 * @version February 5, 2023, 4:00 pm -03
*/

class CustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'address',
        'token',
        'password',
        'city_id'
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

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Customer::class;
    }


    protected $fieldLikeable = [
        'name',
        'email'
    ];


    public function allLike($search , $skip = null, $limit = null, $where = null)
    {
        $query = $this->model->newQuery();
        $this->search = $search;

        $query->with('city');

        if ($search) {
            $fields = $this->getFieldsLikeable();
            foreach($fields as $field) {
                $query->orWhere($field, 'like',  "%$search%");
            }
        }

        if ($where) {
            foreach($where as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }
}
