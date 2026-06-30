<?php

namespace App;

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('dayjobsnightlife_options', [
        'title' => __('Theme Options', 'dayjobsnightlife'),
        'priority' => 30,
    ]);

    $fields = [
        'social_facebook' => __('Facebook URL', 'dayjobsnightlife'),
        'social_twitter' => __('Twitter / X URL', 'dayjobsnightlife'),
        'social_instagram' => __('Instagram URL', 'dayjobsnightlife'),
        'contact_phone' => __('Contact Phone', 'dayjobsnightlife'),
        'typekit_id' => __('Adobe Fonts Kit ID', 'dayjobsnightlife'),
    ];

    foreach ($fields as $id => $label) {
        $wp_customize->add_setting($id, [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'refresh',
        ]);

        $wp_customize->add_control($id, [
            'label' => $label,
            'section' => 'dayjobsnightlife_options',
            'type' => 'text',
        ]);
    }

    $wp_customize->add_setting('contact_email', [
        'default' => 'hello@dayjobsnightlife.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('contact_email', [
        'label' => __('Contact Email', 'dayjobsnightlife'),
        'section' => 'dayjobsnightlife_options',
        'type' => 'text',
    ]);

    $wp_customize->add_setting('mailchimp_shortcode', [
        'default' => '[mailchimp-widget]',
        'sanitize_callback' => function ($value) {
            return preg_replace('/[^a-zA-Z0-9_\[\]\-="\' ]/', '', wp_unslash($value));
        },
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('mailchimp_shortcode', [
        'label' => __('Mailchimp Shortcode', 'dayjobsnightlife'),
        'section' => 'dayjobsnightlife_options',
        'type' => 'text',
    ]);
});

add_filter('acf/settings/save_json', function () {
    return get_template_directory() . '/resources/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_template_directory() . '/resources/acf-json';

    return $paths;
});

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Homepage Settings', 'dayjobsnightlife'),
        'menu_title' => __('Homepage', 'dayjobsnightlife'),
        'menu_slug' => 'homepage-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
    ]);
}

add_action('after_setup_theme', function () {
    if (function_exists('add_theme_support')) {
        collect([
            'soil-clean-up',
            'soil-nav-walker',
            'soil-nice-search',
            'soil-jquery-cdn',
            'soil-relative-urls',
        ])->each(function ($feature) {
            add_theme_support($feature);
        });
    }
}, 5);
