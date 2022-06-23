<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Аутентификация успешна...
            $user = Auth::user();
            $success['token'] =  "Bearer " . $user->createToken('MyApp')->accessToken->token;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User authenticate successfully.');
        }
        return $this->sendError('Authenticate Error.', $validator->errors());
    }
}
