<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Provider;
use App\Repositories\BaseRepository;

class ProviderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'cuil',
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
        return Provider::class;
    }


    protected $fieldLikeable = [
        'name',
        'email',
        'cuil'
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
