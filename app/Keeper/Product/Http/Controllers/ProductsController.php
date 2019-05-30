<?php
declare(strict_types=1);

namespace App\Keeper\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Keeper\Product\Http\Requests\ProductListRequest;
use App\Keeper\Product\Repositories\ProductRepositoryInterface;
use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var WishlistRepositoryInterface
     */
    private $wishlistRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param WishlistRepositoryInterface $wishlistRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        WishlistRepositoryInterface $wishlistRepository
    ) {
        $this->productRepository = $productRepository;
        $this->wishlistRepository = $wishlistRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductListRequest $request
     * @return Factory|View
     */
    public function index(ProductListRequest $request)
    {
        return view('products.index', [
            'products' => $this->productRepository->findByTitle(
                (string) $request->get('title')
            ),
            'wishlists' => $this->wishlistRepository->findNotDefaultForUser((int) $request->user()->id),
            'defaultWishlist' => $this->wishlistRepository->findDefaultForUser((int) $request->user()->id),
        ]);
    }
}
