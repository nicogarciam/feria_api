<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\BaseRepository;

/**
 * Class PaymentRepository
 * @package App\Repositories
 * @version July 27, 2022, 7:06 pm UTC
*/

class PaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pay_date',
        'user_id',
        'pay_method',
        'pay_ref',
        'amount',
        'payment_state_id',
        'discount',
        'coupon_code',
        'sale_id',
        'user',
        'store_id',
        'bank_account_id'
    ];

    protected $fieldLikeable = [
        'pay_date',
        'amount'
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
        return Payment::class;
    }


    public function allLike($search, $where = null, $customer_id = null, $orders = null)
    {
        return $this->allLikeQuery(
            $search, $where, $customer_id, $orders
        )->get();
    }


    public function allLikeQuery($search , $where = null, $customer_id = null, $orders = null)
    {
        $query = $this->model->newQuery();
        $this->search = $search;

        if ($search) {
            $fields = $this->getFieldsLikeable();
            foreach($fields as $field) {
                $query->orWhere($field, 'like',  "%$search%");
            }
        }

        if ($customer_id) {
            $query->leftJoin('sales', 'sales.id', '=', 'payments.sale_id');;
            $query->where('sales.customer_id', $customer_id);
        }

        if ($where) {
            foreach($where as $key => $value) {
                if ($key == 'date_from') {
                    $query->where('pay_date', '>=', $value);
                } elseif ($key == 'date_to') {
                    $query->where('pay_date', '<=', $value);
                } else{
                    $query->where($key, $value);
                }
            }
        }

        if ($orders) {
            foreach ($orders as $order) {
                $parts = explode(',', $order);
                if (count($parts) === 2) {
                    $query->orderBy($parts[0], $parts[1]);
                }
            }
        } else {
            $query->orderBy('pay_date');
        }
        return $query;
    }
    public function pageLike($search, $where = null, $customer_id = null, $page = null, $size = null, $sort = null)
    {
        $query = $this->model->newQuery();
        $this->search = $search;

        if ($search) {
            $fields = $this->getFieldsLikeable();
            foreach($fields as $field) {
                $query->orWhere($field, 'like',  "%$search%");
            }
        }

        if ($customer_id) {
            $query->leftJoin('sales', 'sales.id', '=', 'payments.sale_id');;
            $query->where('sales.customer_id', $customer_id);
        }

        if ($where) {
            foreach($where as $key => $value) {
                $query->where($key, $value);
            }
        }


        if ($sort) {
            foreach ($sort as $order) {
                $parts = explode(',', $order);
                if (count($parts) === 2) {
                    $query->orderBy($parts[0], $parts[1]);
                }
            }
        } else {
            $query->orderBy('pay_date');
        }

        $result = $query->paginate($page['size'], ['*'], 'page', $page['page']);

        return $result;
    }



    public function forSaleFull($saleId)
    {

        $query = $this->model->newQuery();
        $withs = ['customer'];

        if (count($withs)) {
            foreach($withs as $value) {
                $query->with($value);
            }
        }

        $query->where('sale_id', $saleId);

        return $query->get();
    }
}
