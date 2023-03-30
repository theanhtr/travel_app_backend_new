<?php

namespace App\Http\Controllers;

use App\Helper\CheckRoleAdmin;
use App\Models\User;
// use App\Http\Requests\StoreUserRequest;
// use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\AdminRegisterNewUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('checkAdmin', User::class);

        return response()->json(User::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createNewUser(AdminRegisterNewUserRequest $request)
    {
        $this->authorize('checkAdmin', User::class);

        $password = Str::random(10);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => $request->role_id,
        ]);

        MailController::sendEmail('mail.email_admin_create_confirm', 
            ['user_id' => $user->id, 'email' => $user->email, 'password' => $password], 
            $user->email, 'Email Confirm');

        return response()->json([
            'message' => 'Create done, need confirm email'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function showOneUser(Request $request)
    {
        $this->authorize('checkAdmin', User::class);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors->first()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'error' => "User not found"
            ], 400);
        }

        return response()->json($user, 200);
    }

    public function deleteUser(Request $request) {
        $this->authorize('checkAdmin', User::class);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors->first()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'error' => "User not found"
            ], 400);
        }

        if(CheckRoleAdmin::checkRoleAdmin($user)) {
            return response()->json([
                'error' => "User is admin, can't delete"
            ], 400);
        }

        MailController::sendEmail('mail.delete_account', 
            ['email' => $user->email], 
            $user->email, 'Delete Account');

        User::destroy($user->id);

        return response()->json([
            'message' => "Delete complete"
        ], 200);
    }

    public function changeRole(Request $request) {
        $this->authorize('checkAdmin', User::class);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'role_id' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'error' => $errors->first()
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'error' => "User not found"
            ], 400);
        }

        $user->role_id = $request -> role_id;
        $user->save();

        return response()->json([
            'message' => "Change role completed"
        ], 200);
    }
}
