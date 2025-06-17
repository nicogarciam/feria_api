<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class AccountRepository
 * @package App\Repositories
 * @version October 19, 2020, 12:37 am UTC
*/

class AccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'firstName',
        'lastName',
        'activated',
        'email',
        'langKey',
        'city_id',
        'gender',
        'imageUrl',
        'user_id'
    ];

    protected $fieldLikeable = [
        'firstName',
        'lastName',
        'email',
        'dni'
    ];


    public function allLike($search , $skip = null, $limit = null, $where = null)
    {
        $query = $this->model->newQuery();
        $this->search = $search;

        $query->whereHas('user', function ( $query) {
            $query->where('name', 'like', "%$this->search%");
        });
        $query->with('user');
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


    public function findFullByUserId($userId){
        $query = $this->model->newQuery();
        $query->with('user');
        $query->with('city');
//        $query->with('entity');
        $query->where("user_id", $userId);

        return $query->get()->first();
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

    public function getFieldsLikeable()
    {
        return $this->fieldLikeable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Account::class;
    }

    public function create($input)
    {
        $model = $this->model->newInstance($input);
        $model->save();
        $model->account_cod = Hash::make($model->id);
        $model->save();

        return $model;
    }


}
