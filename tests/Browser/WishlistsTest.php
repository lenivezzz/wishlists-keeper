<?php
declare(strict_types=1);

namespace Tests\Browser;

use App\Keeper\Wishlist\Repositories\WishlistDbRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Browser\Components\CreateAndVerifyUser;
use Tests\Browser\Pages\WishlistsPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class WishlistsTest extends DuskTestCase
{
    use WithFaker;
    use DatabaseMigrations;
    use CreateAndVerifyUser;

    private $user;

    /**
     * @throws Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createVerifiedUserWithDefaultList($this->faker->email, $this->faker->password);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user);
        });
    }

    /***
     * @return void
     * @throws Throwable
     */
    public function testPagination() : void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new WishlistsPage())
                ->assertMissing('@pagination');

            (new WishlistDbRepository())->createForUser($this->faker->word, $this->user->id);
            $browser->refresh()
                ->assertMissing('@pagination');

            $i = 10;
            do {
                (new WishlistDbRepository())->createForUser($this->faker->word, $this->user->id);
            } while ($i --);
            $browser->refresh()
                ->assertVisible('@pagination');
        });
    }

    /**
     * @throws Throwable
     */
    public function testItemOptions() : void
    {
        $defaultWishlist = (new WishlistDbRepository())->createDefaultForUser((int) $this->user->id);
        $customWishlist = (new WishlistDbRepository())->createForUser($this->faker->name, (int) $this->user->id);

        $this->browse(function (Browser $browser) use ($defaultWishlist, $customWishlist) {
            $browser->visit(new WishlistsPage())
                ->assertVisible('#form-options' . $customWishlist->id)
                ->assertMissing('#form-options' . $defaultWishlist->id);
        });
    }
}
