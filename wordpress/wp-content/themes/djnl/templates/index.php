<?php //get_template_part('partials/page-header'); ?>

<?php if (!have_posts()) : ?>
  <div clas="row">
    <div class="col-xs-10 offset-xs-1">
      <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', 'sage'); ?>
      </div>
      <?php get_search_form(); ?>
    </div>
  </div>
<?php endif; ?>

<div class="row">
    <div class="col-xs-10 offset-xs-1 col-sm-7 offset-sm-1">
      <?php $the_query = new WP_Query( $args=array(
					'meta_key'=>'feature-index',
					'meta_value'=> 'feature-1',
					'posts_per_page' => 1
				) ); ?>
      <?php if ( $the_query->have_posts() ) : ?>
      	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <?php get_template_part('partials/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
      	<?php endwhile; ?>
      	<?php wp_reset_postdata(); ?>
      <?php else : ?>
      	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
      <?php endif; ?>
    </div>
    <div class="col-sm-3 hidden-xs-down">
      <div class="sidebar-posts">
        <h4><a href="#"><em>Trend</em> <span class="btn-arrow">&#8594;</span></a></h4>
        <?php
          $catquery = new WP_Query( 'cat=7,12,15&posts_per_page=3' );
          while($catquery->have_posts()) : $catquery->the_post();
        ?>
          <ul>
            <li>
              <a href="<?php the_permalink() ?>" rel="bookmark">
                <div class="thumbnail"><?php the_post_thumbnail( 'thumbnail-news' ); ?></div>
                <h6><?php the_title(); ?></h6>
                <p><em><?php //the_field('tag-line'); ?></em></p>
              </a>
            </li>
          </ul>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

<div class="row hidden-xs-down">
  <div class="col-xs-10 offset-xs-1">
    <div class="banner-posts">
      <h3><em>Trending</em></h3>
      <ul>
          <?php $the_query = new WP_Query( $args=array(
    					'posts_per_page' => 5
    				) ); ?>
          <?php if ( $the_query->have_posts() ) : ?>
          	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
              <li>
                  <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium'); ?>
                  <span><?php the_title(); ?></span>
                </a>
              </li>
          	<?php endwhile; ?>
          	<?php wp_reset_postdata(); ?>
          <?php else : ?>
          	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
          <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<?php the_posts_navigation(); ?>
