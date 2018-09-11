<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => ['me', 'update', 'destroy']]);
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Create an user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $user = User::create(request()->input());

        return response()->json($user);
    }

    /**
     * Get an user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Get current user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(request()->user());
    }

    /**
     * Update an user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user)
    {
        $user->update(request()->input());
        return response()->json($user);
    }

    /**
     * Delete an user
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        return ($user->delete()) ? response(null, 200) : response(null, 500);
    }
}
