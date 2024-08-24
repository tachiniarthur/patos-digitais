<?php

namespace App\Http\Controllers;

use App\Services\FollowService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function __construct(
        public UserService $userService,
        public FollowService $followService
    ) {
        
    }

    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Search', [
            'user' => $user,
        ]);
    }

    public function search(Request $request)
    {
        $results = $this->followService->findUserBySearch($request->all());

        return response()->json($results);
    }

    public function follow(Request $request)
    {
        $follow = $this->followService->manipulationFollower($request->all());

        return response()->json(['type' => $follow]);
    }
}