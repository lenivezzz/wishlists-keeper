<?php
declare(strict_types=1);

namespace App\Keeper\Category\Repositories;

use App\Keeper\Category\Category;

class CategoryDbRepository implements CategoryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(string $title, string $alias): Category
    {
        return Category::create([
            'title' => $title,
            'alias' => $alias,
        ]);
    }
}
