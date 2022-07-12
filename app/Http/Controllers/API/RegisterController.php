<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\API\ErrorResource;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return ErrorResource|UserResource
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        if (Auth::validate($validated)) {
            $error['error'] = ['The user with this email is already registered'];
            $error['message'] = 'Registration error.';
            return new ErrorResource($error);
        }

        $input = $validated;
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['email'] = $user->email;
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['message'] = 'User register successfully.';

        return new UserResource($success);
    }
}
