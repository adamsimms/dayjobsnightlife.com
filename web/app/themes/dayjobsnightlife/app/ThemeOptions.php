<?php

namespace App;

class ThemeOptions
{
    public static function get(string $key, $default = '')
    {
        $value = get_theme_mod($key, $default);

        return is_string($value) ? trim($value) : $value;
    }

    public static function socialLinks(): array
    {
        return [
            'facebook' => self::get('social_facebook'),
            'twitter' => self::get('social_twitter'),
            'instagram' => self::get('social_instagram'),
        ];
    }

    public static function contact(): array
    {
        return [
            'phone' => self::get('contact_phone', '514.835.2920'),
            'email' => self::get('contact_email', 'hello@dayjobsnightlife.com'),
        ];
    }

    public static function mailchimpShortcode(): string
    {
        return self::get('mailchimp_shortcode', '[mailchimp-widget]');
    }

    public static function typekitId(): string
    {
        return self::get('typekit_id', 'zua1yrw');
    }

    public static function tagline(?int $postId = null): string
    {
        if (function_exists('get_field')) {
            $tagline = get_field('tag-line', $postId);

            if (! empty($tagline)) {
                return (string) $tagline;
            }
        }

        return '';
    }
}
