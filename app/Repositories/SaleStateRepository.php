<?php

namespace App\Repositories;

use App\Models\SaleState;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class SaleStateRepository
 * @package App\Repositories
 * @version July 27, 2022, 6:01 pm UTC
*/

class SaleStateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'color'
    ];

    protected $fieldLikeable = [
        'name',
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
        return SaleState::class;
    }

    public function findSaleHistoric($saleId)
    {
        return DB::table('sale_statuses')
            ->join('sale_states', 'sale_statuses.state_id', '=', 'sale_states.id')
            ->select('sale_statuses.*', 'sale_states.name as name')
            ->where('sale_id', $saleId)
            ->orderBy('date_from', 'desc')
            ->get();
    }
}
