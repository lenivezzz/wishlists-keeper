<?php
declare(strict_types=1);

namespace App\Keeper\User\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserDbRepository implements UserRepositoryInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function create(string $email, string $password): User
    {
        $user = new User([
            'name' => '',
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $user->save();
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}
