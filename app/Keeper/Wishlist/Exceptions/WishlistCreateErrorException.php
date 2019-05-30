<?php
declare(strict_types=1);

namespace App\Keeper\Wishlist\Exceptions;

use Exception;
use Throwable;

class WishlistCreateErrorException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Failed to create wishlist', 0, $previous);
    }
}
