<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;


class RootPolicy
{
    use HandlesAuthorization;

    public function all(User $user)
    {
        return $user->role == 'root';
    }
}
