<?php

namespace Roots\Sage\Home;

/**
 * Homepage section configuration.
 *
 * Category IDs and feature meta values are centralized here so the
 * homepage layout can be updated without duplicating query logic.
 */
function sections() {
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
      ],
    ],
    'trending_banner' => [
      'title' => 'Trending',
      'posts_per_page' => 5,
    ],
    'feature_2' => [
      'meta_key' => 'feature-index',
      'meta_value' => 'feature-2',
      'sidebar' => [
        'title' => 'Travel',
        'categories' => [13],
        'posts_per_page' => 3,
      ],
    ],
    'feature_3' => [
      'meta_key' => 'feature-index',
      'meta_value' => 'feature-3',
      'sidebar' => [
        'title' => 'Details',
        'categories' => [3, 5, 14],
        'posts_per_page' => 3,
      ],
    ],
  ];
}

/**
 * Run a standard post query and render a template part for each result.
 */
function render_posts($args, $template = 'templates/content') {
  $query = new \WP_Query($args);

  if (!$query->have_posts()) {
    echo '<p>' . esc_html__('Sorry, no posts matched your criteria.', 'dayjobsnightlife') . '</p>';
    wp_reset_postdata();
    return;
  }

  while ($query->have_posts()) {
    $query->the_post();
    $format = get_post_type() !== 'post' ? get_post_type() : get_post_format();
    get_template_part($template, $format);
  }

  wp_reset_postdata();
}

/**
 * Build query args for a sidebar category block.
 */
function sidebar_query_args(array $sidebar) {
  return [
    'cat' => implode(',', $sidebar['categories']),
    'posts_per_page' => $sidebar['posts_per_page'],
  ];
}
