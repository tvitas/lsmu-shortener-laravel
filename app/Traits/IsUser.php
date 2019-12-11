<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

Trait IsUser
{
    private $isUser = true;

    public function isUserCheck()
    {
        $role = Auth::user()->role;
        if ($role == 'admin' or $role == 'root') {
            $this->isUser = false;
        }
        return $this->isUser;
    }

    public function getRole()
    {
        return Auth::user()->role;
    }

    public function getUserId()
    {
        return Auth::user()->id;
    }
}
