<?php

namespace App\View\Composers;

use App\HomeSections;
use Roots\Acorn\View\Composer;

class Home extends Composer
{
    protected static $views = [
        'home',
        'partials.home.*',
    ];

    public function with(): array
    {
        return [
            'sections' => HomeSections::all(),
        ];
    }
}
