<?php

namespace Tests\Feature;

use App\Keeper\Category\Repositories\CategoryDbRepository;
use App\Keeper\Product\Repositories\ProductDbRepository;
use App\Keeper\Wishlist\Repositories\WishlistDbRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\CreateAndVerifyUser;
use Tests\Browser\Pages\ProductsPage;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class ProductsTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;
    use CreateAndVerifyUser;

    private $user;

    /**
     * @throws Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $this->user = $this->createVerifiedUserWithDefaultList($this->faker->email, $this->faker->password);
            $browser->loginAs($this->user);
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws Throwable
     */
    public function testPagination(): void
    {
        $this->browse(function (Browser $browser) {
            $category = (new CategoryDbRepository())->create(
                $this->faker->unique()->word,
                $this->faker->unique()->word
            );

            (new ProductDbRepository())->create(
                $this->faker->unique()->word,
                $this->faker->unique()->word,
                $category->id
            );

            $browser->visit(new ProductsPage())->assertMissing('@pagination');

            $i = 12;
            do {
                (new ProductDbRepository())->create(
                    $this->faker->unique()->word,
                    $this->faker->unique()->word,
                    $category->id
                );
            } while ($i--);

            $browser->refresh()->assertVisible('@pagination');
        });
    }

    /**
     * @throws Throwable
     */
    public function testCardContent(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ProductsPage())->assertSee('No items here.');

            $categoryTitle = $this->faker->unique()->word;
            $category = (new CategoryDbRepository())->create(
                $categoryTitle,
                $this->faker->unique()->word
            );

            $productTitle = $this->faker->unique()->word;
            (new ProductDbRepository())->create(
                $productTitle,
                $this->faker->unique()->word,
                $category->id
            );

            $browser->refresh()
                ->assertSee($productTitle)
                ->assertSee($categoryTitle);
        });
    }

    /**
     * @throws Throwable
     */
    public function testNoDefaultWishlist(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->createVerifiedUser($this->faker->email, $this->faker->password))
                ->visit((new ProductsPage())->url())->assertPathIs('/wishlists/createdefault');
        });
    }

    /**
     * @throws Throwable
     */
    public function testAddProductToWishlist(): void
    {
        $defaultWishlist = (new WishlistDbRepository())->findDefaultForUser((int) $this->user->id);

        $category = (new CategoryDbRepository())->create(
            $this->faker->unique()->word,
            $this->faker->unique()->word
        );
        $product = (new ProductDbRepository())->create(
            $this->faker->unique()->word,
            $this->faker->unique()->word,
            $category->id
        );
        $this->browse(function (Browser $browser, Browser $second) use ($product, $defaultWishlist) {
            $second->loginAs($this->user)
                ->visit(new ProductsPage());

            $browser->visit(new ProductsPage())
                ->press('.addproducttowishlist')
                ->assertVisible('.addproducttowishlist[disabled]')
                ->assertVisible('#ajax-loader')
                ->waitUntilMissing('#ajax-loader');

            $this->assertTrue($defaultWishlist->products->contains($product));

            $second->press('.addproducttowishlist')
                ->waitUntilMissing('#ajax-loader')
                ->assertVisible('#addproduct-failure');
        });
    }
}
