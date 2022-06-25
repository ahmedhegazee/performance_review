<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreUserRequest, UpdateUserRequest, UsersFilterRequest};
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;
use \App\Notifications\UserCreatedNotification;

class UserController extends Controller
{
    /**
     * Display a list of users.
     * @param App\Http\Requests\UsersFilterRequest $request
     * @return App\Http\Resources\UserResource
     */
    public function index(UsersFilterRequest $request)
    {
        return UserResource::collection(User::filter($request)->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $password = Str::random(10);
        $uuid = Str::uuid();
        $additionalData = ['password' => bcrypt($password), 'uuid' => $uuid];
        $user = User::create(array_merge($request->all(), $additionalData));
        $user->notify(new UserCreatedNotification($password));
        return new UserResource($user);
    }

    /**
     * Display user.
     *
     * @param  User $user
     * @return App\Http\Resources\UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateUserRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
