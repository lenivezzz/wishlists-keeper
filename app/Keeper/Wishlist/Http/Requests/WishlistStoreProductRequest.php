<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WishlistStoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'productId:required|int',
            'wishlistId:required|int',
            'productId' => [
                Rule::unique('wishlist_product', 'product_id')
                    ->where('wishlist_id', $this->post('wishlistId'))
            ],
        ];
    }
}
