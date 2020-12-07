<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'content'     => 'required|min:5',
            'answer'      => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'content'     => 'Въпрос',
            'category_id' => 'Категория',
            'answer'      => 'Отговор',
        ];
    }
}
