<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class Authentication
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function login($_, array $args)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('custom_token');
            return [
                'token' => $token->plainTextToken,
                'user' => auth()->user()
            ];
        }

        throw new CustomException(
            'Unauthenticated!',
            'Invalid credentials!'
        );
    }

    public function register($_, array $args)
    {
        $data = [
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => $args['password'],
        ];
        $user = User::create($data);
        return $user;
    }
}
