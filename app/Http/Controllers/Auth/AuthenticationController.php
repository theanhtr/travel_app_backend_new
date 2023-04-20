<?php

namespace App\Http\Controllers\Auth;

use App\Helper\GetRoleIdHelper;
use App\Http\Controllers\Controller;
use App\Models\Authentication;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\LoginAuthenticationRequest;
use App\Http\Requests\LoginAccessTokenRequest;
use App\Http\Requests\LogoutAuthenticationRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    use HttpResponse;
    public function login(LoginAuthenticationRequest $request) {
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
                "role_name" => $role_name,
                "role_id" => $user -> role_id
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

        $user -> tokens -> each(function($token) {
            $token -> delete();
        });

        return $this->success("Password updated", "", 200);
    }

    public function loginGoogle(LoginAccessTokenRequest $request) {
        try {
            $client = new Client();
            $access_token = $request -> access_token;
            $checkToken = $client->get("https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=$access_token");
            $responseGoogle = json_decode($checkToken->getBody()->getContents(), true);
            
            return $this->checkUserByEmail($responseGoogle);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function loginFacebook(LoginAccessTokenRequest $request) {
        try {
            $client = new Client();
            $access_token = $request -> access_token;
            $checkToken = $client->get("https://graph.facebook.com/v3.1/me?fields=id,name,email&access_token=$access_token");
            $responseFacebook = json_decode($checkToken->getBody()->getContents(), true);

            return $this->checkUserByEmail($responseFacebook);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function checkUserByEmail($profile)
    {
        $user = User::where('email', $profile['email'])->first();
        if (!$user) {
            $user = User::create([
                'email' => $profile['email'],
                'password' => Hash::make(Str::random(8)),
                'role_id' => GetRoleIdHelper::getCustomerRoleId(),
                'email_verified_at' => now(),
            ]);

            $array_name = explode(" ", $profile['name']);

            $first_name = $array_name[0];
            $last_name = "";

            for($i = 1; $i < count($array_name); $i++) {
                $last_name .= $array_name[$i];
                $last_name .= " ";
            }

            $user->information()->create([
                'first_name' => $first_name,
                'last_name' => $last_name,
            ]);

            $user -> avatar_id = 1;
            $user -> save();
        }
        
        $token = $user -> createToken($user->email);
        $role_name = Role::find($user -> role_id)->name;

        return $this->success('Login ok', [
            "email" => $user->email,
            "token" => $token -> accessToken,
            "token_expires_at" => $token -> token -> expires_at, 
            "role_name" => $role_name,
            "role_id" => $user -> role_id
        ]);
    }
}
