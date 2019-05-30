<?php
declare(strict_types=1);

namespace App\Keeper\Category\Repositories;

use App\Keeper\Category\Category;

interface CategoryRepositoryInterface
{
    /**
     * @param string $title
     * @param string $alias
     * @return Category
     */
    public function create(string $title, string $alias) : Category;
}
