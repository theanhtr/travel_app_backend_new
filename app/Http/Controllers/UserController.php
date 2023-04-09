<?php

namespace App\Http\Controllers;

use App\Helper\CheckRoleAdmin;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\GetUserByEmailRequest;
// use App\Http\Requests\StoreUserRequest;
// use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\AdminRegisterNewUserRequest;
use App\Http\Requests\ChangeRoleByEmailRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('checkAdmin', User::class);

        return $this->success('Get all user completed', User::all());
    }
    
    public function showOneUser(GetUserByEmailRequest $request)
    {
        $this->authorize('checkAdmin', User::class);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return $this->failure('User of this email not found');
        }

        return $this->success('Get user of this email completed', $user);
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

        return $this->success('Created user done, need confirm email', $user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function deleteUser(GetUserByEmailRequest $request) {
        $this->authorize('checkAdmin', User::class);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return $this->failure('User of this email not found');
        }

        if(CheckRoleAdmin::checkRoleAdmin($user)) {
            return $this->failure("User is admin, can't delete");
        }

        MailController::sendEmail('mail.delete_account', 
            ['email' => $user->email], 
            $user->email, 'Delete Account');

        User::destroy($user->id);

        return $this->success("Delete complete");
    }

    public function getRole() {
        $this->authorize('checkAdmin', User::class);

        $roles = Role::all();

        return $this->success("Get role completed", $roles);
    }

    public function changeRole(ChangeRoleByEmailRequest $request) {
        $this->authorize('checkAdmin', User::class);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return $this->failure('User of this email not found');
        }

        if(CheckRoleAdmin::checkRoleAdmin($user)) {
            return $this->failure("User is admin, can't change role");
        }

        $user->role_id = $request -> role_id;
        $user->save();

        return $this->success("Change role completed");
    }
}
