<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:20',
            'text' => 'nullable|string|max:200',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Название обязательно для заполнения.',
            'title.min' => 'Название должно содержать не менее 3 символов.',
            'title.max' => 'Название не должно превышать 20 символов.',
            'text.max' => 'Описание не должно превышать 200 символов.',
            'tags.array' => 'Теги должны быть в виде массива.',
            'tags.*.integer' => 'Каждый тег должен быть числом.',
            'tags.*.exists' => 'Один или несколько выбранных тегов недействительны.',
        ];
    }
}
