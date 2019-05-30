<?php
declare(strict_types=1);

namespace Tests\Browser;

use App\Keeper\User\Repositories\UserDbRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Browser\Pages\CreateWishlistPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class CreateWishlistTest extends DuskTestCase
{
    use WithFaker;
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testExample() : void
    {
        $user = (new UserDbRepository())->create($this->faker->email, $this->faker->password);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new CreateWishlistPage())
                ->press('@create')
                ->assertSee('The title field is required.')
                ->type('@title', str_repeat('a', 65))
                ->press('@create')
                ->assertSee('The title may not be greater than 64 characters.')
                ->type('@title', 'One more list')
                ->press('@create')
                ->assertPathIs('/wishlists');
        });
    }


}
