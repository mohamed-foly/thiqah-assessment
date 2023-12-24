<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserRepository extends User implements UserRepositoryInterface
{

    public function login(string $username, string $password): User
    {
        $user = $this->where('username', $username)->first();
        if (!$user) {
            throw new HttpException('User not exist');
        }
        if (!Hash::check($password, $user->password)) {
            throw new HttpException('Mismatch user password');
        }
        $user->token = $user->createToken(time())->plainTextToken;
        return $user;
    }

    public function register(string $name, string $username, string $password): User
    {
        $user = $this->create([
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'is_active' => true,
        ]);

        $user->token = $user->createToken(time())->plainTextToken;
        return $user;
    }
}
