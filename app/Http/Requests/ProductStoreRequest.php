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

    protected function prepareForValidation()
    {
        $this->merge([
            'disc'     => $this->cleanNumber($this->disc),
            'priority' => $this->cleanNumber($this->priority),
        ]);
    }

    private function cleanNumber($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // hapus semua karakter selain angka: "1.000.000" => "1000000"
        return preg_replace('/[^0-9]/', '', $value);
    }

    public function rules()
    {
        return [
        'name'                => 'required|max:255',
        'hero_name'           => 'required|max:255',
        'slug'                => 'required|max:255|unique:products,slug',
        'tagline'             => 'nullable|max:255',
        'disc'                => 'nullable|integer',
        'priority'            => 'nullable|integer',
        'source'              => 'nullable|max:255',
        'video_url'           => 'nullable|max:255',
        'product_category_id' => 'required|exists:product_categories,id',
        'desc'                => 'nullable',
        'detail'              => 'required',
        'status'              => 'required',
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
