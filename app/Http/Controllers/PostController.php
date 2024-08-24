<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCommentStoreRequest;
use App\Http\Requests\PostReactionStoreRequest;
use App\Http\Requests\PostStoreRequest;
use App\Services\PostService;
use App\Services\UserService;

class PostController extends Controller
{
    public function __construct(
        public PostService $postService,
        public UserService $userService,
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

        return response()->json([
            'posts'         => $posts,
            'nextPageUrl'   => route('post.getPosts', $cursor),
            'hasMorePages'  => $query->hasMorePages(),
        ]);
    }

    public function getPostsByUser(string $userName, $cursor = null)
    {	
        $user = $this->userService->getUserByName($userName);

        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado!',
            ], 404);
        }

        $query = $this->postService->getPostsByUser($user->id, $cursor);
        $posts = $query->items();

        $cursor = 0;
        if ($query->hasMorePages()) {
            $cursor = explode('?cursor=', $query->nextPageUrl())[1];
        }

        return response()->json([
            'posts'         => $posts,
            'nextPageUrl'   => route('post.getPostsByUser', [$userName, $cursor]),
            'hasMorePages'  => $query->hasMorePages(),
        ]);
    }
    
    public function store(PostStoreRequest $request)
    {
        $this->postService->createPost($request->validated());

        return redirect()->route('home');
    }

    public function getComments(int $postId)
    {
        $comments = $this->postService->getComments($postId);

        return response()->json([
            'comments' => $comments,
        ]);
    }

    public function comment(PostCommentStoreRequest $request): void
    {
        $this->postService->createComment($request->validated());
    }

    public function reaction(PostReactionStoreRequest $request): void
    {
        $this->postService->manipulationReaction($request->all());
    }
}