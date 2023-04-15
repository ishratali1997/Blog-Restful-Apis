<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateProfileRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {

            if ($user->avatar) {
                Storage::delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('uploads/avatars');
        }

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return $this->successWithData(new UserResource($user->fresh()));
    }
}
