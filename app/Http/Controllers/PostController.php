<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCommentStoreRequest;
use App\Http\Requests\PostStoreRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        public PostService $postService
    ) {
        
    }
    
    public function getPosts($cursor = null)
    {
        $query = $this->postService->getPosts($cursor);
        $posts = $query->items();

        $cursor = 0;
        if ($query->hasMorePages()) {
            $cursor = explode('?cursor=', $query->nextPageUrl())[1];
        }

        return (object) [
            'posts'         => $posts,
            'nextPageUrl'   => route('post.getPosts', $cursor),
            'hasMorePages'  => $query->hasMorePages(),
        ];
    }
    
    public function store(PostStoreRequest $request)
    {
        $this->postService->createPost($request->validated());

        return redirect()->route('home');
    }

    public function getComments(int $postId)
    {
        $comments = $this->postService->getComments($postId);

        return (object) [
            'comments' => $comments,
        ];
    }

    public function comment(PostCommentStoreRequest $request): void
    {
        $this->postService->createComment($request->validated());
    }
}