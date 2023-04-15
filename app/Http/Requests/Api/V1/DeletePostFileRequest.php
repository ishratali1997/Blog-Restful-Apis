<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class DeletePostFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'filesIds' => ['nullable', 'array'],
            'filesIds.*' => ['nullable', 'integer']
        ];
    }
}
