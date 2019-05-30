<?php
declare(strict_types=1);

namespace App\Keeper\Product\Repositories;

use App\Keeper\Product\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductDbRepository implements ProductRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function findByTitle(string $title = '', int $pageSize = 12): LengthAwarePaginator
    {
        $query = Product::query()->with('category')->orderBy('title');
        $title && $query->where('title', 'like', $title . '%');
        return $query->paginate($pageSize);
    }

    /**
     * @inheritDoc
     */
    public function create(string $title, string $alias, int $categoryId): Product
    {
        return Product::create([
            'title' => $title,
            'alias' => $alias,
            'category_id' => $categoryId,
        ]);
    }

    /**
     * @param int $id
     * @return Product
     */
    public function findById(int $id): Product
    {
        return Product::findOrFail($id);
    }
}
