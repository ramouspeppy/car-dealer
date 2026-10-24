<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends ProductStoreRequest
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
        $rules = parent::rules();
        $rules['slug'] = 'required|unique:products,slug,' . $this->route('product');
        $rules['image'] = 'nullable|mimes:jpeg,png,jpg,gif|max:2048';
        $rules['header_image'] = 'nullable|mimes:jpeg,png,jpg,gif|max:2048';
        return $rules;
    }
}
