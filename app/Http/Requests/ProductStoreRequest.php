<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name'          => 'required|max:255',
            'hero_name'     => 'required|max:255',
            'slug'          => 'required|max:255|unique:products,slug',
            'tagline'       => 'required',
            'desc'          => 'required',
            'detail'        => 'required',
            'status'        => 'required',
            'priority'      => 'required',
            'header_image'  => 'image|file|max:2048',
            'product_image' => 'image|file|max:2048'
        ];
    }

    public function attributes()
    {
        return [
            'desc' => 'description'
        ];
    }
}
