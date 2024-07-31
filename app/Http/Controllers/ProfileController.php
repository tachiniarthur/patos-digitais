<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Services\PostService;
use App\Services\UserService;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __construct(
        public UserService $userService,
        public PostService $postService,
    ) {
        
    }
    
    public function index(string $userName)
    {
        $user = $this->userService->getUserByName($userName);

        return Inertia::render('Profile', [
            'user' => $user,
        ]);
    }

    public function update(UserProfileUpdateRequest $request)
    {
        dd($request->all());
        // $user = $this->userService->getUserByName($userName);

        // $this->userService->updateUser($user, request()->all());

        // return redirect()->route('profile', $userName);
    }
}