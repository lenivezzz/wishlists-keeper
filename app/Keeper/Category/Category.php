<?php
declare(strict_types=1);

namespace App\Keeper\Category;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'alias',
    ];
}
