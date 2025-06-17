<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class GuestRepository
 * @package App\Repositories
 * @version July 27, 2022, 7:05 pm UTC
*/

class GuestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'dni',
        'birthday',
        'email',
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
        'email',
        'dni'
    ];


    public function allLike($search , $skip = null, $limit = null, $where = null)
    {
        $query = $this->model->newQuery();
        $this->search = $search;

//        $query->whereHas('user', function ( $query) {
//            $query->where('name', 'like', "%$this->search%");
//        });
//        $query->with('user');
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

    public function findForBooking($idBooking)
    {

        return DB::table('guests')
            ->join('booking_guests', 'guests.id', '=', 'booking_guests.guest_id')
            ->select('guests.*')
            ->where('booking_guests.booking_id', $idBooking)
            ->get();
    }
}
