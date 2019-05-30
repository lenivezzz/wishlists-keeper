<?php
declare(strict_types=1);

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class LoginPage extends Page
{
    /**
     * @return string
     */
    public function url() : string
    {
        return '/login';
    }

    /**
     * @param Browser $browser
     */
    public function assert(Browser $browser) : void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * @return array
     */
    public function elements() : array
    {
        return [
            '@email' => 'input[name=email]',
            '@password' => 'input[name=password]',
            '@login' => 'button[name=login]',
        ];
    }
}
