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
        $user = $this->userService->getUserById($request['user_id']);

        $this->userService->updateUser($user, $request->all());

        return (object) [
            'message' => 'Perfil atualizado com sucesso!',
            'user' => $user,
        ];
    }
}