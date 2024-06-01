<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validated());
        return response()->json([
            'message' => 'User registered successfully',
            'data' => new UserResource($user)
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->userService->login($request->validated());
        if ($token) {
            return response()->json([
                'message' => 'Login successfully',
                'token' => $token
            ], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->userService->updateProfile(Auth::user(), $request->validated());
        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => new UserResource($user)
        ]);
    }

    public function profile()
    {
        return new UserResource(Auth::user());
    }

    public function search(SearchUserRequest $request)
    {
        $users = $this->userService->search($request->validated());
        return UserResource::collection($users);
    }

    public function getUserProfile($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    public function followers()
    {
        $followers = $this->userService->getFollowers(Auth::user());
        return UserResource::collection($followers);
    }

    public function following()
    {
        $following = $this->userService->getFollowing(Auth::user());
        return UserResource::collection($following);
    }

    public function follow($id)
    {
        $userToFollow = User::findOrFail($id);
        try {
            $this->userService->follow(Auth::user(), $userToFollow);
            return response()->json(['message' => 'User followed'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);
        try {
            $this->userService->unfollow(Auth::user(), $userToUnfollow);
            return response()->json(['message' => 'User unfollowed'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}