<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
use Illuminate\Auth\Events\Verified;

class AddUserDefaultWishlist
{

    /**
     * @var WishlistRepositoryInterface
     */
    private $repository;

    /**
     * @param WishlistRepositoryInterface $repository
     */
    public function __construct(WishlistRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param Verified $event
     * @return void
     */
    public function handle(Verified $event): void
    {
        $this->repository->createDefaultForUser($event->user->id);
    }
}
