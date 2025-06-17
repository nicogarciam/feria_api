<?php

namespace App\Repositories;

use App\Models\Movement;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class MovementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date',
        'store_id',
        'customer_id',
        'provider_id',
        'account_id',
        'concept',
        'amount',
        'type',
        'state',
        'user'
    ];

    protected $fieldLikeable = [
        'date',
        'type',
        'state'
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
        return Movement::class;
    }

    public function balance($date_from = null , $date_to = null, $for )
    {
        $query = $this->model->newQuery();

        if ($for) {
            foreach($for as $key => $value) {
                $query->where($key, $value);
            }
        }
        if ($date_from) {
            $query->where('date', '>',$date_from);
        }
        if ($date_to) {
            $query->where('date', '<',$date_to);
        }

        $query->selectRaw("sum( CASE WHEN type = 'DEBIT' THEN -1 * amount WHEN type = 'CREDIT' THEN amount ELSE 0 END) as b");
        $result = $query->first();
        return $result ? $result->b : 0;
    }

    public function allBetween($date_from , $date_to, $where )
    {
        $query = $this->model->newQuery();


        if ($where) {
            foreach($where as $key => $value) {
                $query->where($key, $value);
            }
        }
        if ($date_from) {
            $query->where('date', '>=',$date_from);
        }

        if ($date_to) {
            $query->where('date', '<=', $date_to);
        }

        $query->orderBy('date');

        return $query->get();
    }


    public function allLike($search , $skip = null, $limit = null, $where = null, $orders = null)
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

        if ($orders) {
            foreach ($orders as $order) {
                $query->orderBy($order);
            }
        } else {
            $query->orderBy('date');
        }

        return $query->get();
    }

}
