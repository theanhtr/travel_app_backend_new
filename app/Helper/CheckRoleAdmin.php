<?php 

namespace App\Helper;

use App\Models\User;
use App\Models\Role;

class CheckRoleAdmin {
    public static function checkRoleAdmin(User $user):bool|null
    {
        if ($user->role_id == GetRoleIdHelper::getAdminRoleId()) {
            return true;
        }
     
        return null;
    }
}