<button data-wishlist-id="{{ $wishlist->id }}"
        data-product-id="{{ $product->id }}"
        class="{{ $cssClass }} addproducttowishlist"
        @if ($wishlist->isContainsProduct($product))
            disabled
        @endif
>
    <i class="check-icon fas fa-tasks {{ !$wishlist->isContainsProduct($product) ? 'd-none' : '' }}"></i>
    {{ $slot }}
</button>
