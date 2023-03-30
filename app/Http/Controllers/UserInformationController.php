<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use App\Http\Requests\StoreUserInformationRequest;
use App\Http\Requests\UpdateUserInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', UserInformation::class);

        return response()->json(UserInformation::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserInformationRequest $request)
    {
        $this->authorize('create', UserInformation::class);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'error' => 'Information of user isnt exists'
            ], 400);
        }

        if(UserInformation::where('user_id', $user->id)->first()) {
            return response()->json([
                'error' => 'Information of user is exists'
            ], 400);
        }

        $user->information()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number ?? null,
            'date_of_birth' => $request->date_of_birth ?? null,
            'email_contact' => $request->email_contact ?? null
        ]);

        return response()->json([
            'message' => 'Information of user is stored'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserInformation $userInformation)
    {
        $this->authorize('view', $userInformation);

        return response()->json($userInformation, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserInformationRequest $request, UserInformation $userInformation)
    {
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

        return response()->json([
            'message' => 'Information of user is updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInformation $userInformation)
    {
        $this->authorize('delete', $userInformation);

        UserInformation::destroy($userInformation->id);

        return response()->json([
            'message' => "Delete complete"
        ], 200);
    }

    public function showMe()
    {
        $user = Auth::user();
        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return response()->json([
                'error' => 'Information of user isnt exists'
            ], 400);
        }

        $this->authorize('view', $userInformation);

        return response()->json($userInformation, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMe(UpdateUserInformationRequest $request)
    {
        $user = Auth::user();
        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return response()->json([
                'error' => 'Information of user isnt exists'
            ], 400);
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

        return response()->json([
            'message' => 'Information of user is updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMe()
    {
        $user = Auth::user();
        $userInformation = UserInformation::where('user_id', $user->id)->first();

        if(!$userInformation) {
            return response()->json([
                'error' => 'Information of user isnt exists'
            ], 400);
        }
        
        $this->authorize('delete', $userInformation);

        UserInformation::destroy($userInformation->id);

        return response()->json([
            'message' => "Delete complete"
        ], 200);
    }
}
