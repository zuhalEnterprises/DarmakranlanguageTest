<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
            'show_place' => 'in:page_home,page_expert,page_blog',
            'image' => 'nullable|max:5120',
            'image_tablet' => 'nullable|max:5120',
            'image_mobile' => 'nullable|max:5120',
            'title' => 'bail|required',
        ];
    }
}
