<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __construct(
        public PostService $postService
    ) {
        
    }
    
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Profile', [
            'user' => $user,
        ]);
    }
}