<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class PostService
{
    public function __construct(
        private Post $post,
        private User $user,
    ) {
        
    }

    public function getPosts($cursor = null)
    {
        $userId = auth()->id();

        $followingUserIds = $this->user->find($userId)->followings->pluck('id')->toArray();
        $followingUserIds[] = $userId;

        return $this->post
            ->whereIn('user_id', $followingUserIds)
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


    public function getPostsByUser($userId, $cursor = null)
    {
        return $this->post
            ->where('user_id', $userId)
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
            'user_id' => auth()->id(),
        ]);
    }

    public function getComments($postId)
    {
        return $this->post->find($postId)->comments()->with(['user:id,name,email'])->get();
    }

    public function createComment($request): void
    {
        $this->post->find($request['post_id'])->comments()->create([
            'user_id' => auth()->id(),
            'type' => 'comment',
            'comment' => $request['comment'],
        ]);
    }

    public function manipulationReaction($request): void
    {
        $postId = $request['post_id'];
        $newReactionType = $request['reaction'];
        $userId = auth()->id();

        $existingReaction = $this->post->find($postId)
            ->reaction()
            ->where('user_id', $userId)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type == $newReactionType) {
                $existingReaction->delete();
            } else {
                $existingReaction->type = $newReactionType;
                $existingReaction->save();
            }
        } else {
            $this->post->find($postId)->reaction()->create([
                'user_id' => $userId,
                'type' => $newReactionType,
            ]);
        }
    }

}
