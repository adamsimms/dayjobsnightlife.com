<?php
/**
 * Title: footer
 * Slug: azur/footer
 * Inserter: no
 */

declare( strict_types = 1 );
?>
<!-- wp:spacer {"height":"90px"} -->
<div style="height:90px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70"}}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"400px"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)"><!-- wp:paragraph {"align":"left","style":{"typography":{"fontWeight":"500","fontStyle":"normal"}},"fontSize":"x-small"} -->
<p class="has-text-align-left has-x-small-font-size" style="font-style:normal;font-weight:500"><?php /* Translators: 1. is the start of a 'a' HTML element, 2. is the end of a 'a' HTML element */ 
echo sprintf( esc_html__( 'Azur Theme ● Designed with %1$sWordPress%2$s', 'azur' ), '<a href="' . esc_url( 'https://wordpress.org' ) . '" rel="nofollow">', '</a>' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
