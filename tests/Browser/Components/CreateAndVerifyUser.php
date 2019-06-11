<?php
declare(strict_types=1);

namespace Tests\Browser\Components;

use App\Keeper\User\Repositories\UserDbRepository;
use App\User;

trait CreateAndVerifyUser
{
    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    protected function createVerifiedUser(string $email, string $password) : User
    {
        $user = (new UserDbRepository())->create($email, $password);
        $user->markEmailAsVerified();

        return $user;
    }
}
