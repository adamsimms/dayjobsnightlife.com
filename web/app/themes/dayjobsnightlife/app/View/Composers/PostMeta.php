<?php

namespace App\View\Composers;

use App\ThemeOptions;
use Roots\Acorn\View\Composer;

class PostMeta extends Composer
{
    protected static $views = [
        'partials.content',
        'partials.content-*',
        'partials.home.*',
    ];

    public function with(): array
    {
        return [
            'tagline' => ThemeOptions::tagline(get_the_ID()),
        ];
    }
}
