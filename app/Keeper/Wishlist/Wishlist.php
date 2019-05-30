<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist;

use App\Keeper\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\Types\Boolean;

class Wishlist extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'is_default',
    ];

    protected $attributes = [
        'is_default' => 0,
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlist_product');
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function isContainsProduct(Product $product) : bool
    {
        return $this->products->contains($product);
    }
}
