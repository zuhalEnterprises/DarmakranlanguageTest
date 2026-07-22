<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'gender' => 'nullable|in:male,female',
            'name' => 'required',
            'mobile' => 'required',
            'estate_type' => 'required',
            'request_type' => 'required',
            'residence_type' => 'required',
            'purchase_reason' => 'required',
            'purchase_priority' => 'required',
            'financial_liquidity_type' => 'required',
        ];
    }
}
