<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Repositories;

use App\Keeper\Product\Product;
use App\Keeper\Wishlist\Wishlist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface WishlistRepositoryInterface
{
    /**
     * @param int $userId
     * @param string $order
     * @param int $pageSize
     * @return LengthAwarePaginator
     */
    public function findAllForUser(int $userId, string $order = 'desc', int $pageSize = 10) : LengthAwarePaginator;

    /**
     * @param int $id
     * @param int $userId
     * @return Wishlist
     */
    public function findForUser(int $id, int $userId) : Wishlist;

    /**
     * @param string $title
     * @param int $userId
     * @return Wishlist
     */
    public function createForUser(string $title, int $userId) : Wishlist;

    /**
     * @param string $title
     * @param int $id
     * @param int $userId
     * @return int
     */
    public function updateForUser(string $title, int $id, int $userId) : int;

    /**
     * @param int $id
     * @param int $userId
     */
    public function deleteForUser(int $id, int $userId) : void;

    /**
     * @param int $userId
     * @return Wishlist
     */
    public function findDefaultForUser(int $userId) : Wishlist;

    /**
     * @param int $userId
     * @return Wishlist
     */
    public function createDefaultForUser(int $userId) : Wishlist;

    /**
     * @param int $userId
     * @return Collection
     */
    public function findNotDefaultForUser(int $userId) : Collection;

    /**
     * @param Product $product
     * @param Wishlist $wishlist
     * @return Model
     */
    public function addProductToWishlist(Product $product, Wishlist $wishlist) : Model;
}
