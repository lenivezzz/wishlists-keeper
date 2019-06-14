<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Keeper\Product\Repositories\ProductRepositoryInterface;
use App\Keeper\Wishlist\Http\Requests\StoreWishlist;
use App\Keeper\Wishlist\Http\Requests\WishlistStoreProductRequest;
use App\Keeper\Wishlist\Repositories\WishlistRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    /**
     * @var WishlistRepositoryInterface
     */
    private $wishlistRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @param WishlistRepositoryInterface $wishlistRepository
     */
    public function __construct(
        WishlistRepositoryInterface $wishlistRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->wishlistRepository = $wishlistRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        return view('wishlist.index', [
            'wishlists' => $this->wishlistRepository->findAllForUser((int) $request->user()->id),
        ]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('wishlist.create');
    }

    /**
     * @param StoreWishlist $request
     * @return RedirectResponse
     */
    public function store(StoreWishlist $request): RedirectResponse
    {
        $request->validated();
        $this->wishlistRepository->createForUser($request->post('title'), (int) $request->user()->id);
        return redirect()->route('wishlists');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $this->wishlistRepository->deleteForUser((int) $request->post('id'), (int) $request->user()->id);
        return redirect()->route('wishlists')->with('success', 'Item deleted successfully!');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Factory|View
     */
    public function edit(int $id, Request $request)
    {
        return view('wishlist.edit', [
            'wishlist' => $this->wishlistRepository->findForUser($id, (int) $request->user()->id),
        ]);
    }

    /**
     * @param StoreWishlist $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StoreWishlist $request, int $id): RedirectResponse
    {
        $request->validated();
        $this->wishlistRepository->updateForUser(
            $request->post('title'),
            $id,
            (int) $request->user()->id
        );

        return redirect()->route('wishlists')->with('success', 'Item updated successfully!');
    }

    /**
     * @return Factory|View
     */
    public function createDefault()
    {
        return view('wishlist.createdefault');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeDefault(Request $request): RedirectResponse
    {
        $this->wishlistRepository->createDefaultForUser((int) $request->user()->id);
        return redirect()->route('wishlists')->with('success', 'Default wishlist created successfully!');
    }

    /**
     * @param WishlistStoreProductRequest $request
     * @return JsonResponse
     */
    public function addProduct(WishlistStoreProductRequest $request): JsonResponse
    {
        $request->validated();
        $this->wishlistRepository->addProductToWishlist(
            $this->productRepository->findById((int) $request->post('productId')),
            $this->wishlistRepository->findForUser(
                (int) $request->post('wishlistId'),
                (int) $request->user()->id
            )
        );

        return response()->json();
    }
}
