<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return UserResource::collection(
            $this->userRepository->all()
        );
    }

    public function show($user)
    {
        return response()->json(['data' => UserResource::make(
            $this->userRepository->findOrFail($user)
        )]);
    }

    public function store(StoreRequest $request)
    {
        $user = $this->userRepository->create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => $request->is_active,
        ]);
        return response()->json(['data' => $user]);
    }

    public function update(UpdateRequest $request, $user)
    {
        $this->userRepository->where('id', $user)->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => $request->is_active,
        ]);
        return $this->show($user);
    }

    public function delete($user)
    {
        $this->userRepository->where('id', $user)->delete();
        return response()->json();
    }
}
