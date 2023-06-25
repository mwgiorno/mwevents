<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $user = User::new(
            $request->username,
            $request->firstname,
            $request->lastname,
            $request->password,
            $request->birthdate,
        );

        $token = $user->createToken('auth_token');

        return response()
            ->json([
                'error' => null,
                'result' => [
                    'token' => $token->plainTextToken
                ]
            ]);
    }
}
