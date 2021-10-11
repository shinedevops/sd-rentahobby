<?php

namespace App\Http\Requests\customer;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
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
            'userid' => 'required|exists:users,id',
            'productid' => 'required|exists:products,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'userid.required' =>  __('favorite.validations.userRequired'),
            'userid.exists' =>  __('favorite.validations.userExist'),
            'product.required' =>  __('product.validations.productRequired'),
            'product.exists' =>  __('product.validations.productExist'),
        ];
    }
}
