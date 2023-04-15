<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'content' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'boolean'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file', 'max:2048', 'exclude']
        ];
    }
}
