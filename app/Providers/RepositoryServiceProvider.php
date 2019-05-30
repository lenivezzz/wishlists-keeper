<?php
declare(strict_types=1);

namespace App\Providers;

use App\Keeper\Category\Repositories\CategoryDbRepository;
use App\Keeper\Category\Repositories\CategoryRepositoryInterface;
use App\Keeper\Product\Repositories\ProductDbRepository;
use App\Keeper\Product\Repositories\ProductRepositoryInterface;
use App\Keeper\User\Repositories\UserDbRepository;
use App\Keeper\User\Repositories\UserRepositoryInterface;
use App\Keeper\Wishlist\Repositories\WishlistDbRepository;
use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryDbRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserDbRepository::class
        );

        $this->app->bind(
            WishlistRepositoryInterface::class,
            WishlistDbRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductDbRepository::class
        );
    }
}
