<?php

namespace App\Http\Requests\API;

use App\Models\Withdrawal;
use InfyOm\Generator\Request\APIRequest;

class UpdateWithdrawalAPIRequest extends APIRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Withdrawal::$rules;
        return $rules;
    }
}
