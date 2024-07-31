<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(
        public User $user
    ) {
        
    }

    public function getUserByName(string $name)
    {
        return $this->user
            ->where('name', $name)
            ->select(
                'id',
                'name',
                'email',
                'biography',
                'gender',
                'date_of_birth',
                'phone_number',
                'zip_code',
                'number',
                'street',
                'neighborhood',
                'city',
                'state',
            )->first();
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
