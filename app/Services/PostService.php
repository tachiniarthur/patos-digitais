<?php

namespace App\Services;

use App\Models\Posts;

class PostService
{
    public function __construct(
        public Posts $post
    ) {
        
    }

    public function getPosts($cursor = null)
    {
        return $this->post
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('posts.id', 'desc')
            ->cursorPaginate(4, ['*'], 'cursor', ($cursor == 0 ? null : $cursor));
    }

    public function createPost($request)
    {
        return $this->post->create([
            'content' => $request['content'],
            'user_id' => auth()->user()->id,
        ]);
    }
}
