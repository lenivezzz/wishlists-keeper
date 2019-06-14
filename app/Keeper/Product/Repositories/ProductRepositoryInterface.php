<?php
declare(strict_types=1);

namespace App\Keeper\Product\Repositories;

use App\Keeper\Product\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    /**
     * @param string $title
     * @param int $pageSize
     * @return LengthAwarePaginator
     */
    public function findByTitle(string $title = '', int $pageSize = 12) : LengthAwarePaginator;

    /**
     * @param int $id
     * @return Product
     */
    public function findById(int $id) : Product;

    /**
     * @param string $title
     * @param string $alias
     * @param int $categoryId
     * @return Product
     */
    public function create(string $title, string $alias, int $categoryId) : Product;
}
