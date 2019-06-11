<?php
declare(strict_types=1);

namespace Tests\Browser\Components;

use App\Keeper\User\Repositories\UserDbRepository;
use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
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

    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    protected function createVerifiedUserWithDefaultList(string $email, string $password) : User
    {
        $user = $this->createVerifiedUser($email, $password);
        resolve(WishlistRepositoryInterface::class)->createDefaultForUser($user->id);
        return $user;
    }
}
