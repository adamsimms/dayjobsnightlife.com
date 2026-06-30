<?php

namespace Roots\Sage\Customizer;

use Roots\Sage\Assets;

/**
 * Sanitize shortcode-style theme option values.
 */
function sanitize_shortcode($value) {
  return preg_replace('/[^a-zA-Z0-9_\[\]\-="\' ]/', '', wp_unslash($value));
}

/**
 * Register Customizer settings for site-specific theme options.
 */
function customize_register($wp_customize) {
  $wp_customize->get_setting('blogname')->transport = 'postMessage';

  $wp_customize->add_section('dayjobsnightlife_options', [
    'title' => __('Theme Options', 'dayjobsnightlife'),
    'priority' => 30,
  ]);

  $text_fields = [
    'social_facebook' => __('Facebook URL', 'dayjobsnightlife'),
    'social_twitter' => __('Twitter / X URL', 'dayjobsnightlife'),
    'social_instagram' => __('Instagram URL', 'dayjobsnightlife'),
    'contact_phone' => __('Contact Phone', 'dayjobsnightlife'),
    'typekit_id' => __('Adobe Fonts Kit ID', 'dayjobsnightlife'),
  ];

  foreach ($text_fields as $id => $label) {
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
    'sanitize_callback' => __NAMESPACE__ . '\\sanitize_shortcode',
    'transport' => 'refresh',
  ]);

  $wp_customize->add_control('mailchimp_shortcode', [
    'label' => __('Mailchimp Shortcode', 'dayjobsnightlife'),
    'section' => 'dayjobsnightlife_options',
    'type' => 'text',
  ]);
}
add_action('customize_register', __NAMESPACE__ . '\\customize_register');

/**
 * Customizer JS
 */
function customize_preview_js() {
  wp_enqueue_script(
    'dayjobsnightlife/customizer',
    Assets\asset_path('scripts/customizer.js'),
    ['customize-preview'],
    null,
    true
  );
}
add_action('customize_preview_init', __NAMESPACE__ . '\\customize_preview_js');
