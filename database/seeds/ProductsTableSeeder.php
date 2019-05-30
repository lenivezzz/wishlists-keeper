<?php
declare(strict_types=1);

use App\Keeper\Category\Category;
use App\Keeper\Product\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $category = factory(Category::class)->create();
        factory(Product::class, random_int(10, 20))->create(['category_id' => $category->id]);
    }
}
