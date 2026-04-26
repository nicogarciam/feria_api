<?php

namespace App\Http\Requests\API;

use App\Models\Withdrawal;
use InfyOm\Generator\Request\APIRequest;

class CreateWithdrawalAPIRequest extends APIRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Withdrawal::$rules;
    }
}
