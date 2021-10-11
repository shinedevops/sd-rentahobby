<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailRequest extends FormRequest
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
            'name' => 'required',
            'phone_number' => 'required|min:10|max:12',
            'profile_pic' => 'mimes:jpg,jpeg,png|max:2000'
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
            'name.required' =>  __('user.validations.oldPasswordRequired'),
            'phone_number.required' =>  __('user.validations.phoneRequired'),
            'phone_number.min' =>  __('user.validations.PhoneMin'),
            'phone_number.max' =>  __('user.validations.phoneMax'),
            'profile_pic.mimes' =>  __('user.validations.uploadProfilePicExtenstion'),
            'profile_pic.max' =>  __('user.validations.uploadProfilePicSize'),
        ];
    }
}
