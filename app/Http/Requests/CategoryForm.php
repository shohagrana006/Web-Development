<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\validateFormNumber;

class CategoryForm extends FormRequest
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
          'category_name'        => ['required','unique:categories,category_name', new validateFormNumber],
          'category_description' => 'required',
        ];
    }

    public function messages()
    {
        return [
          'category_name.required'        => 'insart your name',
          'category_description.required' => 'insart your description',
        ];
    }
}
