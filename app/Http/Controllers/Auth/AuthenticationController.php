<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Authentication;
use App\Http\Requests\LoginAuthenticationRequest;
use App\Http\Requests\LogoutAuthenticationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(LoginAuthenticationRequest $request)
    {
        $login = $request->only('email', 'password');
        
        if(!Auth::attempt($login)) {
            return response()->json(['message' => 'Invalid login credential !!!'], 404);
        }

        /**
         * @var User $user
         */

        $user = Auth::user();
        $token = $user -> createToken($user->email);

        return response()->json([
            'id' => $user->id,
            'email' => $user->email,
            'token' => $token -> accessToken,
            'token_expires_at' => $token -> token -> expires_at
        ], 200);
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

            return response()->json([
                'message' => 'logged out from all device'
            ], 200);
        }

        $userToken = $user->token();
        $userToken -> delete();

        return response()->json([
            'message' => 'loggout success'
        ], 200);
    }
}
