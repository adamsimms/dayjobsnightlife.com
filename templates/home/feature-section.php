<?php
use Roots\Sage\Extras;
use Roots\Sage\Home;

$args = wp_parse_args($args, [
  'meta_key' => '',
  'meta_value' => '',
  'sidebar' => [],
]);
?>

<div class="row">
  <div class="col-10 offset-1 col-sm-7 offset-sm-1">
    <?php
    Home\render_posts([
      'meta_key' => $args['meta_key'],
      'meta_value' => $args['meta_value'],
      'posts_per_page' => 1,
    ]);
    ?>
  </div>

  <?php if (!empty($args['sidebar'])) : ?>
    <div class="col-sm-3 d-none d-md-block">
      <div class="sidebar-posts">
        <h4>
          <a href="#">
            <em><?php echo esc_html($args['sidebar']['title']); ?></em>
            <span class="btn-arrow">&#8594;</span>
          </a>
        </h4>
        <?php
        $sidebar_query = new WP_Query(Home\sidebar_query_args($args['sidebar']));

        while ($sidebar_query->have_posts()) :
          $sidebar_query->the_post();
          $tagline = Extras\tagline();
          ?>
          <ul>
            <li>
              <a href="<?php the_permalink(); ?>" rel="bookmark">
                <div class="thumbnail"><?php the_post_thumbnail('small'); ?></div>
                <h6><?php the_title(); ?></h6>
                <?php if ($tagline) : ?>
                  <p><em><?php echo esc_html($tagline); ?></em></p>
                <?php endif; ?>
              </a>
            </li>
          </ul>
          <?php
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  <?php endif; ?>
</div>
