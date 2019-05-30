<?php
declare(strict_types=1);

namespace App\Keeper\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Keeper\Category\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $service;

    /**
     * @param CategoryRepositoryInterface $categoryService
     */
    public function __construct(CategoryRepositoryInterface $categoryService)
    {
        $this->service = $categoryService;
    }

    public function index()
    {
        return view('category.index', [
            'categories' => $this->service->list(),
        ]);
    }
}
