<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(
        private User $user
    ) {
        
    }
    
    public function getUserById(int $id)
    {
        return $this->user->find($id);
    }

    public function getUserByName(string $name)
    {
        $user = $this->user
            ->where('username', $name)
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'users.biography',
                'users.gender',
                'users.date_of_birth',
                'users.phone_number',
                'users.zip_code',
                'users.number',
                'users.street',
                'users.neighborhood',
                'users.city',
                'users.state',
            )
            ->withCount([
                'posts as posts_count' => function ($query) {
                    $query->whereNull('posts.deleted_at');
                },
                'followers as followers_count' => function ($query) {
                    $query->whereNull('followers.deleted_at');
                },
                'followings as followings_count' => function ($query) {
                    $query->whereNull('followers.deleted_at');
                }
            ])
            ->with(['followers' => function ($query) {
                $query->whereNull('followers.deleted_at');
            }])
            ->first();

        if ($user) {
            $activeFollowers = $user->followers->filter(function ($follower) {
                return is_null($follower->deleted_at);
            });

            $user->is_following = $activeFollowers->contains(auth()->id());
        }

        return $user;
    }

    public function createUser($request)
    {
        return $this->user->create([
            'username' => $request['username'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
    }

    public function updateUser($user, $request)
    {
        $user->update([
            'username' => $request['username'],
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
}
