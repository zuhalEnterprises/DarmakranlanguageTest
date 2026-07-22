<?php

namespace App\Http\Requests\User;


use App\Http\Requests\BaseRequest;

/**
 * @property string $mobile
 *
 */
class VerifyMobileRequest extends BaseRequest
{
    public function rules()
    {
        return [

            'mobile' => (env('COUNTRY') == 'UAE')?'required':'required|regex:[^09[0-9]{9}]',

        ];
    }
}
