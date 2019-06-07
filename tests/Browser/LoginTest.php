<?php
declare(strict_types=1);

namespace Tests\Browser;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\Browser\Components\CreateAndVerifyUser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;
    use CreateAndVerifyUser;

    /**
     * @throws Throwable
     */
    public function testAuth()
    {
        $this->browse(function (Browser $browser) {
            $email = $this->faker->email;
            $pwd = $this->faker->unique()->password;
            $incorrectPwd = $this->faker->unique()->password;
            $this->createVerifiedUser($email, $pwd);
            $browser->visit(new LoginPage())
                ->press('@login')
                ->type('@email', $email)
                ->type('@password', $incorrectPwd)
                ->press('@login')
                ->assertSee('These credentials do not match our records.')
                ->type('@password', $pwd)
                ->press('@login')
                ->assertPathIs('/wishlists')
            ;
        });
    }
}
