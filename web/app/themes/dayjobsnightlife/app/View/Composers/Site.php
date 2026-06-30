<?php

namespace App\View\Composers;

use App\ThemeOptions;
use Roots\Acorn\View\Composer;

class Site extends Composer
{
    protected static $views = [
        'sections.header',
        'sections.footer',
        'partials.head',
    ];

    public function with(): array
    {
        return [
            'socialLinks' => ThemeOptions::socialLinks(),
            'contact' => ThemeOptions::contact(),
            'mailchimpShortcode' => ThemeOptions::mailchimpShortcode(),
            'typekitId' => ThemeOptions::typekitId(),
        ];
    }
}
