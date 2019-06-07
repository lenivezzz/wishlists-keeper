<?php

namespace Tests\Browser;

use App\Keeper\User\Repositories\UserDbRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VerifyEmailTest extends DuskTestCase
{
    use WithFaker;
    use DatabaseMigrations;

    public function testShouldVerifyEmail(): void
    {
        $this->browse(function (Browser $browser) {
            $user = (new UserDbRepository())->create($this->faker->email, $this->faker->password);
            $browser->loginAs($user);
            $browser->visit('/wishlists')
                ->assertSee('Verify Your Email Address');
        });
    }
}
