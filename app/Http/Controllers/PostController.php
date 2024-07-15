<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Posts;
use Inertia\Inertia;

class PostController extends Controller
{
    public function store(PostStoreRequest $request)
    {
        $request->validated();

        $post = Posts::create([
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('home');
    }
}