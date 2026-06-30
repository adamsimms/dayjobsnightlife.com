<?php

use Roots\Sage\Extras;

$sections = Roots\Sage\Home\sections();
?>

<?php if (!have_posts()) : ?>
  <div class="row">
    <div class="col-12">
      <div class="alert alert-warning">
        <?php esc_html_e('Sorry, no results were found.', 'dayjobsnightlife'); ?>
      </div>
      <?php get_search_form(); ?>
    </div>
  </div>
<?php endif; ?>

<?php
get_template_part('templates/home/banner-posts', null, $sections['recent_banner']);
get_template_part('templates/home/divider');
get_template_part('templates/home/nav-primary');
get_template_part('templates/home/divider');
get_template_part('templates/home/feature-section', null, $sections['feature_1']);
get_template_part('templates/home/divider');
get_template_part('templates/home/banner-posts', null, $sections['trending_banner']);
get_template_part('templates/home/divider');
get_template_part('templates/home/feature-section', null, $sections['feature_2']);
?>

<hr />

<?php get_template_part('templates/home/feature-section', null, $sections['feature_3']); ?>
