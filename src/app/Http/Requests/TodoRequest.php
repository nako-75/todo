<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'content' => ['required','string','max:20'],
            'category_id' => ['required','exists:categories,id'],
            'deadline_day' => ['required','integer','between:1,31'],
            'priority' => ['required','string'],
        ];
    }

    public function messages():array {
        return [
            'content.required' => 'Todoを入力してください',
            'content.string' => 'Todoを文字列で入力してください',
            'content.max' => 'Todoを20文字以下で入力してください',
            'category_id.required' => 'カテゴリを選択してください',
            'deadline_day.required' => '期限を選択してください',
            'priority.required' => '優先度を選択してください',
        ];
    }
}
