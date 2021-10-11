<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rentRegex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        $quantityRegx = "/^[1-9]+[0-9]*$/";
        $nonAvailableDates = request()->non_availabile_dates;
        $nonAvailableDatesArray = explode(',', $nonAvailableDates);
        $validate = [
            'name' => 'required',
            'category' => 'required|exists:categories,id',
            'description' => 'required',
            'thumbnail_image' => 'required|mimes:jpg,jpeg,png|max:2000',
            'gallery_image.*' => 'mimes:jpg,jpeg,png|max:2000',
            'location.*' => 'required',
            'rent' => ['required', 'regex: ' . $rentRegex],
            'security' => ['required', 'regex: ' . $rentRegex],
            'quantity' => ['required', 'regex: ' . $quantityRegx],
            'price' => ['required', 'regex: ' . $rentRegex],
        ];
        
        $today = date(session()->get('date'));
        foreach($nonAvailableDatesArray as $singleNonAvailableDate) {
            if ($singleNonAvailableDate < $today) {
                $validate['non_availabile_dates'] = "after_or_equal: {$today}";
                break;
            }
        }

        return $validate;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' =>  __('product.validations.productNameRequired'),
            'category.required' =>  __('product.validations.productCategory'),
            'category.exists' =>  __('product.validations.selectedProductCategory'),
            'description.required' =>  __('product.validations.productDescription'),
            'location.*.required' =>  __('product.validations.locationRequired'),
            'rent.required' =>  __('product.validations.rentRequired'),
            'rent.regex' =>  __('product.validations.rentRegex'),
            'security.required' =>  __('product.validations.securityRequired'),
            'security.regex' =>  __('product.validations.securityRegex'),
            'price.required' =>  __('product.validations.priceRequired'),
            'price.regex' =>  __('product.validations.priceRegex'),
            'quantity.required' =>  __('product.validations.quantityRequired'),
            'quantity.regex' =>  __('product.validations.quantityRegex'),
            'thumbnail_image.required' =>  __('product.validations.thumbnailRequired'),
            'thumbnail_image.mimes' =>  __('product.validations.thumbnailExtenstion'),
            'thumbnail_image.max' =>  __('product.validations.thumbnailSize'),
            'gallery_image.*.mimes' =>  __('product.validations.galleryExtenstion'),
            'gallery_image.*.max' =>  __('product.validations.gallerySize'),
            'non_availabile_dates.after_or_equal' =>  __('product.validations.nonAvailabileDatesAfterOrEqual'),
        ];
    }
}