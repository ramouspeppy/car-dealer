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
        'name'                => 'required|max:255',
        'hero_name'           => 'required|max:255',
        'slug'                => 'required|max:255|unique:products,slug',
        'tagline'             => 'nullable|max:255',
        'disc'                => 'nullable|integer|min:0|max:100',
        'priority'            => 'nullable|integer',
        'source'              => 'nullable|max:255',
        'video_url'           => 'nullable|max:255',
        'product_category_id' => 'required|exists:product_categories,id',
        'desc'                => 'nullable',
        'detail'              => 'required',
        'status'              => 'required',
        'header_image'        => 'required|image|max:2048',
        'image'               => 'required|image|max:2048',
        'brochure'            => 'nullable|file',
    ];
    }

    public function attributes()
    {
        return [
            'desc' => 'description'
        ];
    }
}
