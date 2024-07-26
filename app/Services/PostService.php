<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function __construct(
        public Post $post
    ) {
        
    }

    public function getPosts($cursor = null)
    {
        return $this->post
            ->with(['user:id,name,email'])
            ->orderBy('posts.id', 'desc')
            ->cursorPaginate(5, ['*'], 'cursor', ($cursor == 0 ? null : $cursor));
    }

    public function createPost($request)
    {
        return $this->post->create([
            'content' => $request['content'],
            'user_id' => auth()->user()->id,
        ]);
    }

    public function getComments($postId)
    {
        return $this->post->find($postId)->comments()->with(['user:id,name,email'])->get();
    }

    public function createComment($request): void
    {
        $this->post->find($request['post_id'])->comments()->create([
            'user_id' => auth()->user()->id,
            'type' => 'comment',
            'comment' => $request['comment'],
        ]);
    }
}
