<?php

namespace App\Http\Requests\User;


use App\Http\Requests\BaseRequest;

/**
 * @property string $mobile
 * @property integer code
 */
class VerifyCodeRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => (env('COUNTRY') == 'UAE')?'required':'required|regex:[^09[0-9]{9}]',
            //'code' => 'nullable|digits:5',
            //'password' => 'nullable|min:6'
        ];
    }
}
