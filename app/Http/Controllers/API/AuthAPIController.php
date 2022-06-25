<?php

namespace App\Http\Controllers\API;

use App\Exceptions\WrongLoginCredentials;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\ReviewRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAPIController extends Controller
{
    /**
     * Allow user to login.
     *  @param App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $loginToken = $user->createToken('loginToken')->plainTextToken;
            return (new UserResource($user))->additional([
                'data' => ['token' => $loginToken],
            ]);
        }
        throw new WrongLoginCredentials();
    }
    /**
     * Allow user to logout.
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        Auth::guard('web')->logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ], 201);
    }

    public function userData()
    {
        $reviewed = User::find(2);
        $reviewer = User::find(3);
        $reviewer->reviewRequests()->attach(
            $reviewed->id,
            [
                'created_by' => auth()->user()->id
            ]
        );
        dd($reviewer->reviewRequests);
        return new UserResource(Auth::user());
    }
}