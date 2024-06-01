<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function searchByName($name)
    {
        return User::where('name', 'LIKE', "%{$name}%")->get();
    }

    public function getFollowers(User $user)
    {
        return $user->followers;
    }

    public function getFollowing(User $user)
    {
        return $user->following;
    }

    public function isFollowing(User $user, User $userToFollow)
    {
        return $user->following()->where('users.id', $userToFollow->id)->exists();
    }

    public function follow(User $user, User $userToFollow)
    {
        $user->following()->attach($userToFollow->id);
    }

    public function unfollow(User $user, User $userToUnfollow)
    {
        $user->following()->detach($userToUnfollow->id);
    }
}
