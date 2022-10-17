<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:categories,name,NULL,id,deleted_at,NULL'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required'
        ];
    }
}
