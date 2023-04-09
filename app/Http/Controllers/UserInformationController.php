<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMyInformationRequest;
use App\Http\Requests\UpdateMyInformationRequest;
use App\Models\User;
use App\Models\UserInformation;
use App\Http\Requests\StoreUserInformationRequest;
use App\Http\Requests\UpdateUserInformationRequest;
use App\Http\Requests\UserInformationRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    use HttpResponse;
    public function getUserById($user_id)
    {
        $this->authorize('checkAdmin', User::class);

        $user = User::find($user_id);

        return $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', UserInformation::class);

        $userInformations = UserInformation::all();
        $userInforamtionsCustom = array();

        foreach($userInformations as $userInformation) {
            $userInformation->email = $this->getUserById($userInformation->user_id) -> email;
            array_push($userInforamtionsCustom, $userInformation);
        }

        return $this->success("Get all user information completed", $userInforamtionsCustom);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserInformationRequest $request)
    {
        $this->authorize('create', UserInformation::class);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return $this->failure('User of this email not found');
        }

        if(UserInformation::where('user_id', $user->id)->first()) {
            return $this->failure('Information of user is exists');
        }

        $user->information()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number ?? null,
            'date_of_birth' => $request->date_of_birth ?? null,
            'email_contact' => $request->email_contact ?? null
        ]);

        return $this->success('Information of user is stored');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserInformationRequest $request)
    {
        $this->authorize('viewAny', UserInformation::class);
        $user = User::where('email', $request->email)->first();
        
        if(!$user) {
            return $this->failure('User of this email not found');
        }

        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return $this->failure("Information of user isn't exists");
        }

        $this->authorize('update', $userInformation);

        if($request->first_name) {
            $userInformation->first_name = $request->first_name;
        }

        if($request->last_name) {
            $userInformation->last_name = $request->last_name;
        }

        if($request->phone_number) {
            $userInformation->phone_number = $request->phone_number;
        }

        if($request->date_of_birth) {
            $userInformation->date_of_birth= $request->date_of_birth;
        }

        if($request->email_contact) {
            $userInformation->email_contact= $request->email_contact;
        }

        $userInformation->save();

        return $this->success('Information of user is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInformationRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if(!$user) {
            return $this->failure('User of this email not found');
        }

        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return $this->failure("Information of user isn't exists");
        }

        $this->authorize('delete', $userInformation);

        UserInformation::destroy($userInformation->id);

        return $this->success("Delete complete");
    }

    public function showMe()
    {
        $user = Auth::user();
        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return $this->failure("Information of user isn't exists");
        }

        $this->authorize('view', $userInformation);

        return $this->success("Get done", $userInformation);
    }

    public function createMe(StoreMyInformationRequest $request)
    {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if($userInformation) {
            return $this->failure('Information of user is exists');
        }

        $user->information()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number ?? null,
            'date_of_birth' => $request->date_of_birth ?? null,
            'email_contact' => $request->email_contact ?? null
        ]);

        return $this->success('Information of user is stored');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMe(UpdateMyInformationRequest $request)
    {
        $user = Auth::user();
        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return $this->failure("Information of user isn't exists");
        }

        $this->authorize('update', $userInformation);

        if($request->first_name) {
            $userInformation->first_name = $request->first_name;
        }

        if($request->last_name) {
            $userInformation->last_name = $request->last_name;
        }

        if($request->phone_number) {
            $userInformation->phone_number = $request->phone_number;
        }

        if($request->date_of_birth) {
            $userInformation->date_of_birth= $request->date_of_birth;
        }

        if($request->email_contact) {
            $userInformation->email_contact= $request->email_contact;
        }

        $userInformation->save();

        return $this->success('Information of user is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMe()
    {
        $user = Auth::user();
        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return $this->failure("Information of user isn't exists");
        }
        
        $this->authorize('delete', $userInformation);

        UserInformation::destroy($userInformation->id);

        return $this->success("User information deleted");
    }
}
