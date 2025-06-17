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
        'amount',
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
        return Payment::class;
    }


    public function allLike($search , $skip = null, $limit = null, $where = null, $customer_id = null, $orders = null)
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
            $query->orderBy('pay_date');
        }

        return $query->get();
    }
}
