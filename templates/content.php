<?php

use Roots\Sage\Extras;

$tagline = Extras\tagline();
?>

<article <?php post_class(); ?>>
  <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
  <h2 class="entry-title">
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
      <?php if ($tagline) : ?>
        <span>/ <em><?php echo esc_html($tagline); ?></em></span>
      <?php endif; ?>
    </a>
  </h2>
  <p><?php the_excerpt(); ?></p>
</article>
