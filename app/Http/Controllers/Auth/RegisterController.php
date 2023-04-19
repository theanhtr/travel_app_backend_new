<?php

namespace App\Http\Controllers\Auth;

use App\Helper\GetRoleIdHelper;
use App\Http\Controllers\Controller;
use App\Models\Authentication;
use App\Http\Requests\RegisterNewCustomerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MailController;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use HttpResponse;
    public function register(RegisterNewCustomerRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => GetRoleIdHelper::getCustomerRoleId(),
            'email_verified_at' => now()
        ]);

        $this->sendEmailConfirm($user->email, $user->id);

        return $this->success('register complete', '', 200);
    }

    public function sendEmailConfirm($email, $user_id) {
        MailController::sendEmail('mail.email_confirm', ['user_id' => $user_id, 'email' => $email], $email, 'Email Confirm');
    }
    
    public function reSendEmailConfirm(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return $this->failure(
                    'Invalid input parameter structure',
                    $validator->errors(),
                    500
                );
        }

        $user = User::where('email', $request->email)->first();
        
        if(!$user) {
            return $this->failure("No user found with this email", "", 400);
        }

        if($user -> email_verified_at != null) {
            return $this->failure("This email is verified", "", 400);
        }

        $this->sendEmailConfirm($user->email, $user->id);

        return $this->success('Check email to confirm', '', 200);
    }

    public function confirmedEmail($user_id, $email) {
        $user = User::find($user_id);
        
        if(!$user) {
            return view('email_confirm_fail', ['error' => 'User not found !!!']);
        }

        if($user->email != $email) {
            return view('email_confirm_fail', ['error' => 'Email not true !!!']);
        }

        $user -> email_verified_at = now();
        $user->save();

        return view('email_confirm_success');
    }
}
