<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function createPost(array $data)
    {
        $post = $this->postRepo->create(Auth::user(), $data);

        if (isset($data['images'])) {
            $this->postRepo->attachImages($post, $data['images']);
        }

        return $post;
    }

    public function updatePost(Post $post, array $data)
    {
        $post = $this->postRepo->update($post, $data);

        if (isset($data['images'])) {
            $this->postRepo->updateImages($post, $data['images']);
        }

        return $post;
    }

    public function likePost(Post $post)
    {
        $this->postRepo->like($post, Auth::user());
    }

    public function unlikePost(Post $post)
    {
        $this->postRepo->unlike($post, Auth::user());
    }

    public function addComment(Post $post, array $data)
    {
        return $this->postRepo->addComment($post, Auth::user(), $data);
    }

    public function deleteComment(Post $post, $commentId)
    {
        $this->postRepo->deleteComment($post, $commentId);
    }

    public function getAllPosts()
    {
        return $this->postRepo->getAllPosts();
    }

    public function getMyPosts(User $user)
    {
        return $this->postRepo->getPostsByUser($user);
    }

    public function getPostsByUser($userId)
    {
        $user = User::findOrFail($userId);
        return $this->postRepo->getPostsByUser($user);
    }

    public function getFollowingPosts(User $user)
    {
        return $this->postRepo->getFollowingPosts($user);
    }
}
