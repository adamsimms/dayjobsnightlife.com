<?php

namespace App;

use function Roots\bundle;

add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();
}, 100);

add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();
}, 100);

add_action('after_setup_theme', function () {
    remove_theme_support('block-templates');
    remove_theme_support('core-block-patterns');

    load_theme_textdomain('dayjobsnightlife', get_template_directory() . '/resources/lang');

    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'dayjobsnightlife'),
    ]);

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('small', 120, 120, true);
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
    add_theme_support('responsive-embeds');
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'dayjobsnightlife'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'dayjobsnightlife'),
        'id' => 'sidebar-footer',
    ] + $config);
});

function display_sidebar(): bool
{
    static $display;

    if (! isset($display)) {
        $display = ! in_array(true, [
            is_404(),
            is_front_page(),
            is_home(),
            is_page_template('template-custom.blade.php'),
        ], true);
    }

    return (bool) apply_filters('dayjobsnightlife/display_sidebar', $display);
}
