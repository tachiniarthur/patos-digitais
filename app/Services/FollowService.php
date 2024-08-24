<?php

namespace App\Services;

use App\Models\Follower;
use App\Models\User;

class FollowService
{
    public function __construct(
        private User $user,
        private Follower $follow
    ) {
        
    }

    public function findUserBySearch($request)
    {
        $currentUserId = auth()->id();

        $users = $this->user
            ->where('username', 'like', '%' . $request['search'] . '%')
            ->where('id', '!=', $currentUserId)
            ->select('id', 'name', 'username', 'email')
            ->limit(5)
            ->get();

        $users->each(function ($user) use ($currentUserId) {
            $user->is_followed = $user->followers()
                ->where('user_id', $currentUserId)
                ->whereNull('followers.deleted_at')
                ->exists();
        });

        return $users;
    }


    public function manipulationFollower($request)
    {
        $type = '';
        $userId = auth()->id();

        $follower = $this->follow->where('user_id', $userId)
            ->where('follower_id', $request['follower_id'])
            ->first();

        if ($follower) {
            $follower->delete();
            $type = 'unfollow';
        } else {
            $this->follow->create([
                'user_id' => $userId,
                'follower_id' => $request['follower_id'],
            ]);
            $type = 'follow';
        }

        return $type;
    }
}