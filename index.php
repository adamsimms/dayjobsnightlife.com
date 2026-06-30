<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php esc_html_e('Sorry, no results were found.', 'dayjobsnightlife'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', get_post_type() !== 'post' ? get_post_type() : get_post_format()); ?>
<?php endwhile; ?>
