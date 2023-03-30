<?php

namespace App\Policies;

use App\Helper\CheckRoleAdmin;
use App\Models\User;

class UserPolicy
{
    public function checkAdmin(User $user): bool
    {
        return CheckRoleAdmin::checkRoleAdmin($user) ? true : false;
    }
}
