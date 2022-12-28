<?php

namespace App\Http\Requests;

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
        $id = $this->route('category', 0);

        return [
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:categories,slug,$id",
            'parent_id' => 'required|int|exists:categories,id',
            'image' => [
                'nullable',
                'image',
                'max:100',
                //'dimensions:min_width=300,min_height=300,max_width=1200,max_height=1200',
                Rule::dimensions()->minHeight(300)->maxHeight(1200)->minWidth(300)->maxWidth(1200),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute required!!',
            'unique' => 'Already used!',
        ];
    }
}
