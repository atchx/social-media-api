<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class PostRepository
{
    public function create(User $user, array $data)
    {
        return $user->posts()->create($data);
    }

    public function attachImages(Post $post, array $images)
    {
        foreach ($images as $image) {
            $post->images()->create(['url' => $image]);
        }
    }

    public function findById($id)
    {
        return Post::findOrFail($id);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function updateImages(Post $post, array $images)
    {
        $post->images()->delete();
        $this->attachImages($post, $images);
    }

    public function like(Post $post, User $user)
    {
        $existingLike = Like::where('user_id', $user->id)->where('post_id', $post->id)->exists();
        if ($existingLike) {
            return;
        }

        $post->likes()->create(['user_id' => $user->id]);
    }

    public function unlike(Post $post, User $user)
    {
        $post->likes()->where('user_id', $user->id)->delete();
    }

    public function addComment(Post $post, User $user, array $data)
    {
        return $post->comments()->create([
            'user_id' => $user->id,
            'content' => $data['content']
        ]);
    }

    public function deleteComment(Post $post, $commentId)
    {
        $post->comments()->where('id', $commentId)->delete();
    }

    public function getAllPosts()
    {
        return Post::all();
    }

    public function getPostsByUser(User $user)
    {
        return $user->posts;
    }

    public function getFollowingPosts(User $user)
    {
        $followingIds = $user->following()->pluck('users.id');
        return Post::whereIn('user_id', $followingIds)->get();
    }
}
