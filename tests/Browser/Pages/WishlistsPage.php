<?php
declare(strict_types=1);

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class WishlistsPage extends Page
{
    /**
     * @return string
     *
     */
    public function url() : string
    {
        return '/wishlists';
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
            '@pagination' => '#wishlist-pagination',
        ];
    }
}
