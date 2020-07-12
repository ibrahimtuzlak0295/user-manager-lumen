<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('auth:api', ['except' => ['login', 'create']]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string|unique:users,username',
            'first_name' => 'sometimes|nullable|string',
            'last_name' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'zip' => 'sometimes|nullable|integer',
            'city' => 'sometimes|nullable|string',
            'password' =>'required|confirmed|string|min:3',
            'password_confirmation' => 'required|string|min:3'
        ]);
        $user = User::create($request->all());
        return response($user, 201);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'username' => 'sometimes|same:users,username,' . auth()->user()->username,
            'first_name' => 'sometimes|nullable|string',
            'last_name' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'zip' => 'sometimes|nullable|integer',
            'city' => 'sometimes|nullable|string',
        ]);

        $request->user()->update($request->all());

        return response(null, 204);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password_old' => 'required|string',
            'password_new' => 'required|string|min:3|confirmed',
            'password_new_confirmation' => 'required|string|min:3'
        ]);

        if(app('hash')->check($request->input('password_old'), $request->user()->password)) {
            $request->user()->update([
                'password' => $request->input('password_new')
            ]);
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Incorrect old password.'], 401);
        }
        return response()->json(null, 400);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(Request $request)
    {
        return Auth::logout();
    }

    public function me()
    {
        return auth()->user();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
