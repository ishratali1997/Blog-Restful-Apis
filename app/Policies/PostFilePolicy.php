<?php

namespace App\Policies;

use App\Models\PostFile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostFilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, PostFile $postFile): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, PostFile $postFile): bool
    {
    }

    public function delete(User $user, PostFile $postFile): bool
    {
    }

    public function restore(User $user, PostFile $postFile): bool
    {
    }

    public function forceDelete(User $user, PostFile $postFile): bool
    {
    }
}
