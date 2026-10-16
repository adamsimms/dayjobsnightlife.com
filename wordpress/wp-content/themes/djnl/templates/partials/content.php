<article <?php post_class(); ?>>
  <header>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <h3><em><?php //the_field('tag-line'); ?></em></h3>
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
    <?php //get_template_part('partials/entry-meta'); ?>
  </header>
</article>
