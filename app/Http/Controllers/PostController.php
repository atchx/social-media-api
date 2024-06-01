<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store(PostRequest $request)
    {
        $post = $this->postService->createPost($request->validated());
        return response()->json([
            'message' => 'Create Post successfully',
            'data' => new PostResource($post)
        ], 201);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        try {
            $this->authorize('update', $post);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post = $this->postService->updatePost($post, $request->validated());
        return response()->json([
            'message' => 'Update Post successfully',
            'data' => new PostResource($post)
        ], 201);
    }

    public function like($id)
    {
        $post = Post::findOrFail($id);
        $this->postService->likePost($post);
        return response()->json(['message' => 'Post liked'], 200);
    }

    public function unlike($id)
    {
        $post = Post::findOrFail($id);
        $this->postService->unlikePost($post);
        return response()->json(['message' => 'Post unliked'], 200);
    }

    public function comment(AddCommentRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $comment = $this->postService->addComment($post, $request->validated());
        return response()->json(['message' => 'Comment added', 'comment' => $comment], 200);
    }

    public function deleteComment($postId, $commentId)
    {
        $post = Post::findOrFail($postId);
        $this->postService->deleteComment($post, $commentId);
        return response()->json(['message' => 'Comment deleted'], 200);
    }

    public function likedPosts(Request $request)
    {
        $user = Auth::user();
        $likedPosts = $user->likedPosts()->get();
        return PostResource::collection($likedPosts);
    }

    public function index(Request $request)
    {
        $posts = Post::query();

        if ($request->has('user_id')) {
            $posts->where('user_id', $request->user_id);
        }

        if ($request->has('following')) {
            $followingIds = Auth::user()->following()->pluck('id');
            $posts->whereIn('user_id', $followingIds);
        }

        $posts = $posts->get();

        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }

    public function myPosts()
    {
        $posts = $this->postService->getMyPosts(Auth::user());
        return PostResource::collection($posts);
    }

    public function postsByUserId($id)
    {
        $posts = $this->postService->getPostsByUser($id);
        return PostResource::collection($posts);
    }

    public function followingPosts()
    {
        $posts = $this->postService->getFollowingPosts(Auth::user());
        return PostResource::collection($posts);
    }
}
