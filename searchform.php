<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <label class="screen-reader-text" for="s"><?php echo esc_html_x('Search for:', 'label', 'dayjobsnightlife'); ?></label>
  <input type="search" value="<?php echo esc_attr(get_search_query()); ?>" name="s" id="s" />
  <button type="submit"><?php echo esc_html_x('Search', 'submit button', 'dayjobsnightlife'); ?></button>
</form>
