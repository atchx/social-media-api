<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data)
    {
        return $this->userRepo->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login(array $data)
    {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = User::where('email', $data['email'])->first();
            $user->tokens()->delete();
            return Auth::user()->createToken('LaravelSanctumAuth')->plainTextToken;
        }

        return null;
    }

    public function updateProfile(User $user, array $data)
    {
        return $this->userRepo->update($user, $data);
    }

    public function search(array $data)
    {
        return $this->userRepo->searchByName($data['query']);
    }

    public function getFollowers(User $user)
    {
        return $this->userRepo->getFollowers($user);
    }

    public function getFollowing(User $user)
    {
        return $this->userRepo->getFollowing($user);
    }

    public function follow(User $user, User $userToFollow)
    {
        if ($user->id === $userToFollow->id) {
            throw new \Exception("Users cannot follow themselves.");
        }
        if ($this->userRepo->isFollowing($user, $userToFollow)) {
            throw new \Exception("You are already following this user.");
        }

        $this->userRepo->follow($user, $userToFollow);
    }

    public function unfollow(User $user, User $userToUnfollow)
    {
        if ($user->id === $userToUnfollow->id) {
            throw new \Exception("Users cannot unfollow themselves.");
        }
        if (!$this->userRepo->isFollowing($user, $userToUnfollow)) {
            throw new \Exception("You are not following this user.");
        }

        $this->userRepo->unfollow($user, $userToUnfollow);
    }
}