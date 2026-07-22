<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsRequest extends FormRequest
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
            'type' => 'nullable|between:1,2',
            'device' => 'nullable|in:desktop,tablet,mobile',
            'show_place' => 'nullable|between:1,4',
            'image' => 'nullable|max:5120',
            'title' => 'bail|required',
        ];
    }
}
