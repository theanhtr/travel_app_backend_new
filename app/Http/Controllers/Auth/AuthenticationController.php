<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Authentication;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\LoginAuthenticationRequest;
use App\Http\Requests\LogoutAuthenticationRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use HttpResponse;
    public function login(LoginAuthenticationRequest $request)
    {
        $login = $request->only("email", "password");
        
        if(!Auth::attempt($login)) {
            return $this->failure("Invalid login credential", "", 400);
        }

        /**
         * @var User $user
         */

        $user = Auth::user();
        $token = $user -> createToken($user->email);
        $role_name = Role::find($user -> role_id)->name;

        return $this->success("Login success", 
            [
                "email" => $user->email,
                "token" => $token -> accessToken,
                "token_expires_at" => $token -> token -> expires_at, 
                "role_name" => $role_name
            ]
        , 200);
    }
    public function logout(LogoutAuthenticationRequest $request)
    {
        $user = Auth::user();

        /**
         * @var User $user
         */

        if($request -> allDevice) {
            $user -> tokens -> each(function($token) {
                $token -> delete();
            });
        }

        $userToken = $user->token();
        $userToken -> delete();

        return $this->success("logged out success", "", 200);
    }

    public function updatePassword(UpdatePasswordRequest $request) {
        $password = $request -> password;
        $newPassword = $request -> new_password;

        /**
         * @var User $user
         */

        $user = Auth::user();

        if (!Hash::check($password, $user->password)) {
            return $this->failure("Password not true", "", 400);
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return $this->success("Password updated", "", 200);
    }
}
