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
        $userId = auth()->user()->id;
    
        return $this->post
            ->with(['user:id,name,email'])
            ->withCount('comments', 'likes', 'dislikes')
            ->orderBy('posts.id', 'desc')
            ->cursorPaginate(5, ['*'], 'cursor', ($cursor == 0 ? null : $cursor))
            ->tap(function ($posts) use ($userId) {
                $posts->each(function ($post) use ($userId) {
                    $post->user_liked = $post->likes()->where('user_id', $userId)->exists();
                    $post->user_disliked = $post->dislikes()->where('user_id', $userId)->exists();
                });
            });
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

    public function manipulationReaction($request): void
    {
        $reactions = $this->post->find($request['post_id'])->reaction()->get();

        if ($reactions->isEmpty()) {
            $this->post->find($request['post_id'])->reaction()->create([
                'user_id' => auth()->user()->id,
                'type' => $request['reaction'],
            ]);
        } else {
            foreach ($reactions as $reaction) {
                if ($reaction->user_id == auth()->user()->id && $reaction->type == $request['reaction']) {
                    $reaction->delete();
                } else {
                    $this->post->find($request['post_id'])->reaction()->updateOrCreate([
                        'user_id' => auth()->user()->id,
                        'type' => $request['reaction'],
                    ]);
                }
            }
        }
    }
}
