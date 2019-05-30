<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Http\Middleware;

use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnsureNoDefaultWishlistCreated
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
        try {
            $this->wishlistRepository->findDefaultForUser($request->user()->id);
        } catch (ModelNotFoundException $e) {
            return $next($request);
        }

        return redirect('/wishlists')->with('error', 'Failed to create one more Default wishlist');
    }
}
