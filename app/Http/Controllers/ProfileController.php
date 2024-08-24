<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileUpdateRequest;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\Request;
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
        $authUser = auth()->user();
        $user = $this->userService->getUserByName($userName);

        return Inertia::render('Profile', [
            'authUser' => $authUser,
            'user' => $user,
        ]);
    }

    public function update(UserProfileUpdateRequest $request)
    {
        $user = $this->userService->getUserById($request['user_id']);

        $this->userService->updateUser($user, $request->all());

        return response()->json([
            'message' => 'Perfil atualizado com sucesso!',
            'user' => $user,
        ]);
    }

    public function getCountFollowersUser(Request $request)
    {
        $userCountFollowers = $this->userService->getCountFollowersIdUser($request->user_id);

        return response()->json([
            'userCountFollowers' => $userCountFollowers,
        ]);
    }
}