<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\SaleCode;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

/**
 * Class SaleRepository
 * @package App\Repositories
 * @version July 27, 2022, 12:26 pm UTC
*/

class SaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'store_id',
        'customer_id',
        'sale_state_id',
        'date_sale',
        'date_pay',
        'note',
        'total_price',
        'coupon_code',
        'days_to_confirm',
        'days_to_cancel',
        'user'
    ];

    protected $fieldLikeable = [
        'note',
        'user',
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
        return Sale::class;
    }

    public function allSalesQuery($search, $date_from, $date_to, $storeId)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }


        if (!is_null($storeId)) {
            $query->where('store_id', $storeId);
        }

        if (!is_null($date_from)) {
            $query->where('date_sale', '>', $date_from);
        }

        if (!is_null($date_to)) {
            $query->where('date_sale', '<', $date_to);
        }

        return $query->get();
    }

    public function allSalesQueryLike($search, $date_from, $date_to, $storeId)
    {
        $query = $this->model->newQuery()
            ->search($search);

        if (!is_null($storeId)) {
            $query->where('store_id', $storeId);
        }

        if (!is_null($date_from)) {
            $query->where('date_sale', '>', $date_from);
        }

        if (!is_null($date_to)) {
            $query->where('date_sale', '<', $date_to);
        }

        return $query->get();
    }

    public function allSalesQueryLikeWithSort($search, $date_from, $date_to, $storeId, $orders = null)
    {
        $query = $this->model->newQuery()
            ->search($search);

        if (!is_null($storeId)) {
            $query->where('store_id', $storeId);
        }

        if (!is_null($date_from)) {
            $query->where('date_sale', '>', $date_from);
        }

        if (!is_null($date_to)) {
            $query->where('date_sale', '<', $date_to);
        }

        // Handle sorting
        if ($orders) {
            foreach ($orders as $order) {
                $parts = explode(',', $order);
                if (count($parts) === 2) {
                    $query->orderBy($parts[0], $parts[1]);
                }
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }

    public function generateCode($sale) {

        $saleCode = new SaleCode();
        $saleCode->h_id =  $sale['store_id'];

        $saleCode->year =  date_format(new \DateTime($sale['date_sale']), 'y');

        $saleCode->sec = DB::table('sales_codes')
            ->where('h_id', '=', $saleCode->h_id)
            ->where('year', '=', $saleCode->year)
            ->max('sec');

        $saleCode->select('select MAX from users where id = :id', ['id' => 1]);

        $saleCode->sec = $saleCode->sec + 1;

        $saleCode->code = sprintf("%02s",$saleCode->year)
            . sprintf("%03s",$saleCode->h_id)
            . sprintf("%03s",$saleCode->sec);


        $saleCode->save();

        $sale['code'] = $saleCode->code;
        return $saleCode->code;
    }

}
