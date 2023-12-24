<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepositoryInterface;

class FormController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->login(
            $request->username,
            $request->password,
        );
        return response()->json(['data' => UserResource::make($user)]);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userRepository->register(
            $request->name,
            $request->username,
            $request->password,
        );
        return response()->json(['data' => UserResource::make($user)]);
    }
}
