<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Http\Middleware;

use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

class EnsureWishlistIsNotDefault
{
    /**
     * @var WishlistRepositoryInterface
     */
    private $wishlistRepository;

    /**
     * @param WishlistRepositoryInterface $wishlistRepository
     */
    public function __construct(WishlistRepositoryInterface $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('id') ?: $request->post('id');
        $wishlist = $this->wishlistRepository->findForUser((int) $id, $request->user()->id);
        if ($wishlist->is_default) {
            abort(403, 'Failed to update Default wishlist');
        }

        return $next($request);
    }
}
