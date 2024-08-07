<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(
        public User $user
    ) {
        
    }
    
    public function getUserById(int $id)
    {
        return $this->user->find($id);
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

    public function updateUser($user, $request)
    {
        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'biography' => $request['biography'],
            'gender' => $request['gender'],
            'date_of_birth' => $request['birth_date'],
            'phone_number' => $request['phone'],
            'zip_code' => $request['zip_code'],
            'number' => $request['number'],
            'street' => $request['street'],
            'neighborhood' => $request['neighborhood'],
            'city' => $request['city'],
            'state' => $request['state'],
        ]);

        return $user;
    }

    public function findUserBySearch($request)
    {
        return $this->user
            ->where('name', 'like', '%' . $request['search'] . '%')
            ->where('id', '!=', auth()->id())
            ->select(
                'id',
                'name',
                'email',
            )->get();
    }
}
