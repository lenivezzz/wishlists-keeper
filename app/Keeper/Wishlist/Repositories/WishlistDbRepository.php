<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Repositories;

use App\Keeper\Product\Product;
use App\Keeper\Wishlist\Wishlist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WishlistDbRepository implements WishlistRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function findAllForUser(int $userId, string $order = 'desc', int $pageSize = 10) : LengthAwarePaginator
    {
        return Wishlist::where('user_id', $userId)
            ->orderBy('created_at', $order)
            ->paginate($pageSize);
    }

    /**
     * @inheritDoc
     */
    public function findForUser(int $id, int $userId): Wishlist
    {
        return Wishlist::where('user_id', $userId)->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function createForUser(string $title, int $userId): Wishlist
    {
        return Wishlist::create([
            'title' => $title,
            'user_id' => $userId,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function updateForUser(string $title, int $id, int $userId): int
    {
        return Wishlist::where('id', $id)
            ->where('user_id', $userId)
            ->update([
                'title' => $title
            ]);
    }

    /**
     * @inheritDoc
     */
    public function deleteForUser(int $id, int $userId) : void
    {
        Wishlist::where('id', $id)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public function findDefaultForUser(int $userId): Wishlist
    {
        return Wishlist::where('user_id', $userId)
            ->where('is_default', 1)
            ->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function createDefaultForUser(int $userId): Wishlist
    {
        return Wishlist::with('products')->create([
            'title' => 'Default',
            'user_id' => $userId,
            'is_default' => 1,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function findNotDefaultForUser(int $userId): Collection
    {
        return Wishlist::query()->with('products')->where('user_id', $userId)
            ->where('is_default', 0)
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function addProductToWishlist(Product $product, Wishlist $wishlist): Model
    {
        return $wishlist->products()->save($product);
    }
}
