<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(
        public PostService $postService
    ) {
        
    }
    
    public function index()
    {

        return Inertia::render('Home');
    }
}