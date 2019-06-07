<?php

namespace Tests\Browser;

use App\Keeper\Wishlist\Repositories\WishlistDbRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Browser\Components\CreateAndVerifyUser;
use Tests\Browser\Pages\CreateDefaultWishlistPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateDefaultWishlistTest extends DuskTestCase
{
    use WithFaker;
    use DatabaseMigrations;
    use CreateAndVerifyUser;

    public function testExample()
    {
        $user = $this->createVerifiedUser($this->faker->email, $this->faker->password);
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new CreateDefaultWishlistPage())
                ->assertVisible('@button')
                ->click('@button')
                ->assertPathIs('/wishlists')
                ->assertSee('Default wishlist created successfully!');

            (new WishlistDbRepository())->findDefaultForUser((int) $user->id);
            $browser->visit((new CreateDefaultWishlistPage())->url())
                ->assertPathIs('/wishlists')
                ->assertSee('Failed to create one more Default wishlist');
        });
    }
}
