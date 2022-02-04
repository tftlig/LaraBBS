<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    // 4.8章 授权访问
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
