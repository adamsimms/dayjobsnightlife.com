<?php

namespace Roots\Sage\Titles;

/**
 * Page titles
 */
function title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    }

    return __('Latest Posts', 'dayjobsnightlife');
  }

  if (is_archive()) {
    return get_the_archive_title();
  }

  if (is_search()) {
    return sprintf(__('Search Results for %s', 'dayjobsnightlife'), get_search_query());
  }

  if (is_404()) {
    return __('Not Found', 'dayjobsnightlife');
  }

  return get_the_title();
}
