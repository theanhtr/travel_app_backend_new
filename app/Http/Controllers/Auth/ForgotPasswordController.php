<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\Authentication;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request -> email;

        if(User::where('email', $email)->doesntExist()) {
            return response()->json([
                'message' => 'User email does not exist',
            ], 400);
        }

        $dataExists = DB::table('password_reset_tokens')->where('email', $email)->first();
        
        if($dataExists) {
            //van con thoi gian
            if ($dataExists -> created_at >= now()) {
                return response()->json([
                    'message' => 'Please use the previous email',
                ], 400);
            } else {
                DB::table('password_reset_tokens')->where('email', $email)->delete();
            }
        }
        
        $token = Str::random(100);

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()->addminutes(15) 
        ]);

       MailController::sendEmail('mail.password_reset', ['token' => $token], $email, 'Forgot password');

        return response()->json([
            'message' => 'Check your mail',
        ], 200);
    }

    public function viewResetPassword($token) {
        return view('password_reset', ['token' => $token]);
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required' 
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();

            return view('password_reset_fail', ['error' => $errors->first()]);
        }

        $token = $request -> token;
        $email = $request -> email;
        $dataExists = DB::table('password_reset_tokens')->where('token', $token)->first();

        //validate token exists
        if(!($dataExists)) {
            return view('password_reset_fail', ['error' => "Token not found !!!"]);
        }

        if(!($dataExists -> email == $email)) {
            return view('password_reset_fail', ['error' => "Email not true !!!"]);
        }

        if(!($dataExists -> created_at >= now()))  {
            DB::table('password_reset_tokens')->where('token', $token)-> delete();
            
            return view('password_reset_fail', ['error' => "Token has expired !!!"]);
        }

        $user = User::where('email', $email) -> first();

        if(!$user) {
            return view('password_reset_fail', ['error' => "User does not exists !!!"]);
        }

        $user->password = Hash::make($request -> password);
        $user->save();

        DB::table('password_reset_tokens')->where('token', $token)-> delete();

        return view('password_reset_success');
    }
}
