<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Assets;
use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  if ((is_single() || is_page()) && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes, true)) {
      $classes[] = basename(get_permalink());
    }
  }

  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . esc_url(get_permalink()) . '">' . esc_html__('More &#8594;', 'dayjobsnightlife') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Return a built theme asset URI with cache-busting support.
 */
function asset_uri($filename) {
  return esc_url(Assets\asset_path($filename));
}

/**
 * Return a post tagline from ACF when available.
 */
function tagline($post_id = null) {
  if (function_exists('get_field')) {
    $tagline = get_field('tag-line', $post_id);
    if (!empty($tagline)) {
      return $tagline;
    }
  }

  return '';
}

/**
 * Return a theme mod with an optional default.
 */
function theme_option($key, $default = '') {
  $value = get_theme_mod($key, $default);
  return is_string($value) ? trim($value) : $value;
}

/**
 * Return social profile URLs configured in the Customizer.
 */
function social_links() {
  return [
    'facebook' => theme_option('social_facebook'),
    'twitter' => theme_option('social_twitter'),
    'instagram' => theme_option('social_instagram'),
  ];
}

/**
 * Return contact details configured in the Customizer.
 */
function contact_details() {
  return [
    'phone' => theme_option('contact_phone', '514.835.2920'),
    'email' => theme_option('contact_email', 'hello@dayjobsnightlife.com'),
  ];
}

/**
 * Return the Mailchimp shortcode configured in the Customizer.
 */
function mailchimp_shortcode() {
  return theme_option('mailchimp_shortcode', '[mailchimp-widget]');
}

/**
 * Return the Adobe Fonts (Typekit) kit ID.
 */
function typekit_id() {
  return theme_option('typekit_id', 'zua1yrw');
}

/**
 * Output a social link when a URL is configured.
 */
function render_social_link($network, $icon, $label) {
  $links = social_links();
  $url = $links[$network] ?? '';

  if (empty($url)) {
    return;
  }

  printf(
    '<li><a href="%1$s" target="_blank" rel="noopener noreferrer"><img src="%2$s" alt="%3$s" /></a></li>',
    esc_url($url),
    asset_uri('images/' . $icon),
    esc_attr($label)
  );
}
