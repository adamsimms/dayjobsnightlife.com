<?php

namespace App;

class HomeSections
{
    public static function all(): array
    {
        if (function_exists('get_field')) {
            $configured = get_field('homepage_sections', 'option');

            if (is_array($configured) && ! empty($configured)) {
                return $configured;
            }
        }

        return self::defaults();
    }

    public static function defaults(): array
    {
        return [
            'recent_banner' => [
                'title' => 'Recent',
                'posts_per_page' => 5,
            ],
            'feature_1' => [
                'meta_key' => 'feature-index',
                'meta_value' => 'feature-1',
                'sidebar' => [
                    'title' => 'Trend',
                    'categories' => [7, 12, 15],
                    'posts_per_page' => 3,
                    'link' => self::categoryLink([7, 12, 15]),
                ],
            ],
            'trending_banner' => [
                'title' => 'Trending',
                'posts_per_page' => 5,
                'orderby' => 'comment_count',
            ],
            'feature_2' => [
                'meta_key' => 'feature-index',
                'meta_value' => 'feature-2',
                'sidebar' => [
                    'title' => 'Travel',
                    'categories' => [13],
                    'posts_per_page' => 3,
                    'link' => self::categoryLink([13]),
                ],
            ],
            'feature_3' => [
                'meta_key' => 'feature-index',
                'meta_value' => 'feature-3',
                'sidebar' => [
                    'title' => 'Details',
                    'categories' => [3, 5, 14],
                    'posts_per_page' => 3,
                    'link' => self::categoryLink([3, 5, 14]),
                ],
            ],
        ];
    }

    public static function queryPosts(array $args): \WP_Query
    {
        return new \WP_Query($args);
    }

    public static function sidebarQueryArgs(array $sidebar): array
    {
        return [
            'cat' => implode(',', $sidebar['categories']),
            'posts_per_page' => (int) $sidebar['posts_per_page'],
        ];
    }

    protected static function categoryLink(array $categoryIds): string
    {
        $first = get_category($categoryIds[0] ?? 0);

        return $first && ! is_wp_error($first)
            ? get_category_link($first->term_id)
            : home_url('/');
    }
}
