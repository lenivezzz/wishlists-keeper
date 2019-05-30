<?php
declare(strict_types=1);

namespace App\Keeper\User\Repositories;

use App\User;

interface UserRepositoryInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function create(string $email, string $password) : User;
}
