<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function __construct(
        public UserService $userService
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
        $results = $this->userService->findUserBySearch($request->all());

        return response()->json($results);
    }
}