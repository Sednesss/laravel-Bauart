<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\API\ErrorResource;
use App\Http\Resources\API\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return ErrorResource|UserResource
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['email'] = $user->email;
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['message'] = 'User authenticate successfully.';

            return new UserResource($success);
        }

        $error['error'] = ['Invalid authorization data.'];
        $error['message'] = 'Authenticate Error.';

        return new ErrorResource($error);
    }
}
