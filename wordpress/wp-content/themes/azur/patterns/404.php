<?php
/**
 * Title: 404
 * Slug: azur/404
 * Inserter: no
 */

declare( strict_types = 1 );
?>
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"left":"var:preset|spacing|70","right":"var:preset|spacing|70"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<main class="wp-block-group" style="padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)"><!-- wp:paragraph -->
<p><?php esc_html_e('Oops! That page can’t be found.', 'azur');?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"","showLabel":false,"buttonText":"","buttonPosition":"button-inside","buttonUseIcon":true,"style":{"border":{"top":{"color":"var:preset|color|primary","style":"solid","width":"2px"},"right":{"color":"var:preset|color|primary","style":"solid","width":"2px"},"bottom":{"color":"var:preset|color|primary","style":"solid","width":"2px"},"left":{"color":"var:preset|color|primary","style":"solid","width":"2px"}}}} /--></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
