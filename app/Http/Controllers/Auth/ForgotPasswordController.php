<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\Authentication;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\CheckTokenResetPasswordRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    use HttpResponse;
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request -> email;

        if(User::where('email', $email)->doesntExist()) {
            return $this->failure('No user found with this email', '', 400);
        }

        $dataExists = DB::table('password_reset_tokens')->where('email', $email)->first();
        
        if($dataExists) {
            //van con thoi gian
            if ($dataExists -> next_email_at >= now()) {
                return $this->failure('Please use the previous email');
            } else {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
            }
        }
        
        $tokenExist = true;
        $token = 000000;

        while($tokenExist) {
            $max = pow(10, 6) - 1; 
            $random_number = rand(0, $max);
            $token = str_pad($random_number, 6, '0', STR_PAD_LEFT);

            $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first() ? true : false;
        }

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
            'next_email_at' => now() -> addSeconds(10), 
            'token_expire_at' => now() -> addMinutes(15)
        ]);

       MailController::sendEmail('mail.password_reset', ['token' => $token], $email, 'Forgot password [' . $token . ']');

       return $this->success('Send email reset password reset. Check your mail', '', 200);
    }

    public function checkTokenResetPassword(CheckTokenResetPasswordRequest $request) {
        $token = $request -> token;
        $email = $request -> email;
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        //validate token exists
        if(!($tokenExist)) {
            return $this->failure('Token not found');
        }

        if(!($tokenExist -> email == $email)) {
            return $this->failure("Email not true");
        }

        if(!($tokenExist -> token_expire_at >= now()))  {
            //het han
            DB::table('password_reset_tokens')->where('token', $token)-> delete();
            
            return $this->failure("Token has expired");
        }

        return $this->success('Token ok');
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $token = $request -> token;
        $email = $request -> email;
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        //validate token exists
        if(!($tokenExist)) {
            return $this->failure('Token not found');
        }

        if(!($tokenExist -> email == $email)) {
            return $this->failure("Email not true");
        }

        if(!($tokenExist -> token_expire_at >= now()))  {
            //het han
            DB::table('password_reset_tokens')->where('token', $token)-> delete();
            
            return $this->failure("Token has expired");
        }

        $user = User::where('email', $email) -> first();

        if(!$user) {
            return $this->failure("User does not exists");
        }

        $user->password = Hash::make($request -> password);
        $user->save();

        DB::table('password_reset_tokens')->where('token', $token)-> delete();

        return $this->success('Password has been updated');
    }
}
