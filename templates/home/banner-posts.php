<?php
$args = wp_parse_args($args, [
  'title' => '',
  'posts_per_page' => 5,
]);
?>

<div class="row d-none d-md-block">
  <div class="col-10 offset-1">
    <div class="banner-posts">
      <h3><em><?php echo esc_html($args['title']); ?></em></h3>
      <ul>
        <?php
        $query = new WP_Query([
          'posts_per_page' => (int) $args['posts_per_page'],
        ]);

        if ($query->have_posts()) :
          while ($query->have_posts()) :
            $query->the_post();
            ?>
            <li>
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('small'); ?>
                <span><?php the_title(); ?></span>
              </a>
            </li>
            <?php
          endwhile;
          wp_reset_postdata();
        else :
          ?>
          <li><?php esc_html_e('Sorry, no posts matched your criteria.', 'dayjobsnightlife'); ?></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>
