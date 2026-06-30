<?php

namespace App;

add_filter('excerpt_more', function () {
    return sprintf(
        ' &hellip; <a href="%s">%s</a>',
        esc_url(get_permalink()),
        esc_html__('More &#8594;', 'dayjobsnightlife'),
    );
});

add_filter('body_class', function (array $classes) {
    if ((is_single() || is_page()) && ! is_front_page()) {
        $slug = basename(get_permalink());

        if ($slug && ! in_array($slug, $classes, true)) {
            $classes[] = $slug;
        }
    }

    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
});
