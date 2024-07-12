<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(
        public User $user
    ) {
        
    }

    public function createUser($request)
    {
        return $this->user->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
    }
}
