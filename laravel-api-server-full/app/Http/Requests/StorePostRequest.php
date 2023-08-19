<?php

namespace App\Http\Requests;

use App\Rules\IntegerArray;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'body' => 'required',
            'user_ids' => [
                'array',
                'required',
                new IntegerArray()
            ]
        ];
    }

    public function messages()
    {
        return [
            "body.required" => "Please enter a value for body",
            "title.string" => "The title must be a string",
        ];
    }
}
