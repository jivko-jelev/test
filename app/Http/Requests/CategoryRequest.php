<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|min:2',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->category && !is_null($this->category->parent->parent_id ?? null))
                $validator->errors()
                          ->add('parent_id', __('За главна категория, може да се избират единствено категории, които нямат главна категория!'));
        });
    }
}
