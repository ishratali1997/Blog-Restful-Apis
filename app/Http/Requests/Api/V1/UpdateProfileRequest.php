<?php

namespace App\Http\Requests\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190', Rule::unique(User::class, 'email')->ignore(auth()->id())],
            'bio' => ['nullable', 'string', 'max:190'],
            'avatar' => ['nullable', 'image', 'exclude'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', 'exclude'],
        ];
    }
}
