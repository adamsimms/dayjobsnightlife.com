<?php
/**
 * Local preview: Azur index with a featured post, category links, about, and footer.
 */

global $wpdb;

$header = <<<'HTML'
<!-- wp:html -->
<ul class="djnl-swatches" aria-hidden="true"><li class="blue"></li><li class="green"></li><li class="pink"></li><li class="orange"></li><li class="grey"></li></ul>
<!-- /wp:html -->

<!-- wp:group {"className":"djnl-header","style":{"spacing":{"padding":{"top":"2.15rem","right":"var:preset|spacing|70","bottom":"var:preset|spacing|40","left":"var:preset|spacing|70"},"blockGap":"0","margin":{"bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-header" style="margin-bottom:0;padding-top:2.15rem;padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--70)"><!-- wp:navigation {"ref":9436,"overlayMenu":"never","className":"djnl-top-nav","style":{"spacing":{"blockGap":"2.25rem","margin":{"top":"0","bottom":"0"}},"typography":{"fontSize":"0.95rem","fontStyle":"normal","fontWeight":"600","letterSpacing":"0.12em","textTransform":"uppercase"}},"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","justifyContent":"left"}} /-->

<!-- wp:site-logo {"width":480,"isLink":true} /-->

<!-- wp:group {"className":"djnl-about","layout":{"type":"constrained","justifyContent":"left","contentSize":"42rem"}} -->
<div class="wp-block-group djnl-about"><!-- wp:paragraph {"style":{"typography":{"fontSize":"1.6rem","fontStyle":"normal","fontWeight":"400","lineHeight":"1.35"}}} -->
<p style="font-size:1.6rem;font-style:normal;font-weight:400;line-height:1.35">A guide to cool people and hot places in Montreal. Restaurants worth the reservation, bars worth the late night, hotels worth the weekend, so you can have a smoother transition from your day job to your nightlife.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
HTML;

$index = <<<'HTML'
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","style":{"spacing":{"padding":{"top":"5.5rem","right":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<main class="wp-block-group" style="padding-top:5.5rem;padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)"><!-- wp:html -->
<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0" aria-hidden="true"><filter id="djnl-duotone" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0 0 0 1 0" /><feComponentTransfer><feFuncR type="table" tableValues="0.26 1" /><feFuncG type="table" tableValues="0.49 1" /><feFuncB type="table" tableValues="0.71 1" /></feComponentTransfer></filter></svg>
<!-- /wp:html -->

<!-- wp:group {"align":"wide","className":"djnl-feature-row","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide djnl-feature-row"><!-- wp:group {"className":"djnl-feature-main","style":{"spacing":{"blockGap":"var:preset|spacing|80"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-feature-main"><!-- wp:query {"queryId":1,"className":"djnl-feature-query","query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"include":[8832]}} -->
<div class="wp-block-query djnl-feature-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:post-title {"level":1,"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.8","textTransform":"uppercase"}},"fontSize":"xxxx-large"} /-->

<!-- wp:post-author-name {"isLink":true,"className":"djnl-feature-author"} /-->

<!-- wp:group {"className":"djnl-feature-photo","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}}},"layout":{"type":"constrained","justifyContent":"right","contentSize":"720px"}} -->
<div class="wp-block-group djnl-feature-photo"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","scale":"cover","width":"720px","sizeSlug":"large","className":"djnl-feature-image","style":{"border":{"radius":"0px","style":"none","width":"0px"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query -->

<!-- wp:group {"className":"djnl-category","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-category"><!-- wp:heading {"level":2,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0.04em","lineHeight":"1","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0;font-style:normal;font-weight:700;letter-spacing:0.04em;line-height:1;text-transform:uppercase"><a href="/category/scene/">The Social Scene</a></h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":10,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[8832],"sticky":"exclude","inherit":false,"taxQuery":{"category":[41]}}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"4rem"}},"layout":{"type":"default"}} -->
<!-- wp:group {"className":"djnl-cat-post","style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-post"><!-- wp:group {"className":"djnl-cat-copy","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-copy"><!-- wp:post-title {"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.85","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"xxx-large"} /-->

<!-- wp:post-author-name {"isLink":true,"className":"djnl-cat-author"} /--></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","className":"djnl-feature-image djnl-hover-image"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"djnl-category","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-category"><!-- wp:heading {"level":2,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0.04em","lineHeight":"1","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0;font-style:normal;font-weight:700;letter-spacing:0.04em;line-height:1;text-transform:uppercase"><a href="/category/restaurants/">Restaurants</a></h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":11,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"taxQuery":{"category":[5]}}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"4rem"}},"layout":{"type":"default"}} -->
<!-- wp:group {"className":"djnl-cat-post","style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-post"><!-- wp:group {"className":"djnl-cat-copy","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-copy"><!-- wp:post-title {"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.85","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"xxx-large"} /-->

<!-- wp:post-author-name {"isLink":true,"className":"djnl-cat-author"} /--></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","className":"djnl-feature-image djnl-hover-image"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"djnl-category","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-category"><!-- wp:heading {"level":2,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0.04em","lineHeight":"1","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0;font-style:normal;font-weight:700;letter-spacing:0.04em;line-height:1;text-transform:uppercase"><a href="/category/bars/">Bars</a></h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":12,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"taxQuery":{"category":[7]}}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"4rem"}},"layout":{"type":"default"}} -->
<!-- wp:group {"className":"djnl-cat-post","style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-post"><!-- wp:group {"className":"djnl-cat-copy","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-copy"><!-- wp:post-title {"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.85","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"xxx-large"} /-->

<!-- wp:post-author-name {"isLink":true,"className":"djnl-cat-author"} /--></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","className":"djnl-feature-image djnl-hover-image"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"djnl-category","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-category"><!-- wp:heading {"level":2,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0.04em","lineHeight":"1","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size" style="margin-top:0;margin-bottom:0;font-style:normal;font-weight:700;letter-spacing:0.04em;line-height:1;text-transform:uppercase"><a href="/category/hotels/">Hotels</a></h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":13,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"taxQuery":{"category":[6]}}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"4rem"}},"layout":{"type":"default"}} -->
<!-- wp:group {"className":"djnl-cat-post","style":{"spacing":{"blockGap":"0.35rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-post"><!-- wp:group {"className":"djnl-cat-copy","style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-cat-copy"><!-- wp:post-title {"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.85","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"xxx-large"} /-->

<!-- wp:post-author-name {"isLink":true,"className":"djnl-cat-author"} /--></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","className":"djnl-feature-image djnl-hover-image"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
HTML;

$footer = <<<'HTML'
<!-- wp:spacer {"height":"90px"} -->
<div style="height:90px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","right":"var:preset|spacing|70","bottom":"var:preset|spacing|80","left":"var:preset|spacing|70"},"blockGap":"2.75rem"}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"40rem"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--70)"><!-- wp:site-logo {"width":280,"isLink":true} /-->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem","fontStyle":"normal","fontWeight":"400","lineHeight":"1.65"}}} -->
<p style="font-size:1.125rem;font-style:normal;font-weight:400;line-height:1.65">Montreal has thousands of restaurants, bars, and hotels, so deciding where to go is not always easy. For a romantic dinner for two, a bigger celebration, or a corporate event, <a href="mailto:hello@dayjobsnightlife.com">contact us</a> with a few details (where, when, party size, and estimated budget) and we will get back to you with a few cool choices.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem","fontStyle":"normal","fontWeight":"400","lineHeight":"1.65"}}} -->
<p style="font-size:1.125rem;font-style:normal;font-weight:400;line-height:1.65">For media requests, bookings, or all other inquiries, please contact us: <a href="mailto:hello@dayjobsnightlife.com">hello@dayjobsnightlife.com</a></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"ref":9436,"overlayMenu":"never","className":"djnl-footer-nav","style":{"spacing":{"blockGap":"1.5rem"},"typography":{"fontSize":"1.05rem","fontStyle":"normal","fontWeight":"600","letterSpacing":"0.08em","textTransform":"uppercase"}},"layout":{"type":"flex","flexWrap":"wrap","orientation":"horizontal","justifyContent":"left"}} /-->

<!-- wp:paragraph {"className":"djnl-copyright","style":{"typography":{"fontSize":"0.8rem","fontStyle":"normal","fontWeight":"500"}}} -->
<p class="djnl-copyright" style="font-size:0.8rem;font-style:normal;font-weight:500">© 2026. All Rights Reserved.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
HTML;

$single = <<<'HTML'
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","className":"djnl-single","style":{"spacing":{"padding":{"top":"3.5rem","right":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"920px"}} -->
<main class="wp-block-group djnl-single" style="padding-top:3.5rem;padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)"><!-- wp:html -->
<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0" aria-hidden="true"><filter id="djnl-duotone" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0 0 0 1 0" /><feComponentTransfer><feFuncR type="table" tableValues="0.26 1" /><feFuncG type="table" tableValues="0.49 1" /><feFuncB type="table" tableValues="0.71 1" /></feComponentTransfer></filter></svg>
<!-- /wp:html -->

<!-- wp:post-title {"level":1,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.85","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"fontSize":"xxxx-large"} /-->

<!-- wp:group {"className":"djnl-meta","style":{"spacing":{"blockGap":"0px","margin":{"top":"1.85rem","bottom":"0"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
<div class="wp-block-group djnl-meta"><!-- wp:post-date {"format":"F j, Y"} /-->

<!-- wp:post-author-name {"isLink":true} /-->

<!-- wp:post-terms {"term":"category","prefix":""} /--></div>
<!-- /wp:group -->

<!-- wp:post-featured-image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","className":"djnl-feature-image djnl-single-image","style":{"spacing":{"margin":{"top":"2.75rem","bottom":"4.5rem"}}}} /-->

<!-- wp:post-content {"layout":{"type":"constrained","justifyContent":"left","contentSize":"40rem"}} /-->

<!-- wp:post-terms {"term":"post_tag","className":"djnl-tags","style":{"typography":{"fontStyle":"normal","fontWeight":"500","letterSpacing":"0.06em","textTransform":"uppercase"},"spacing":{"margin":{"top":"5.5rem","bottom":"2.5rem"}}},"fontSize":"small"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"top":"2rem"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="margin-top:2rem"><!-- wp:post-navigation-link {"type":"previous","arrow":"arrow"} /-->

<!-- wp:post-navigation-link {"arrow":"arrow"} /--></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
HTML;

$archive = <<<'HTML'
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<!-- wp:group {"tagName":"main","className":"djnl-archive","style":{"spacing":{"padding":{"top":"3.5rem","right":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70"},"blockGap":"2.5rem"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<main class="wp-block-group djnl-archive" style="padding-top:3.5rem;padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)"><!-- wp:html -->
<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0" aria-hidden="true"><filter id="djnl-duotone" color-interpolation-filters="sRGB"><feColorMatrix type="matrix" values="0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0.2126 0.7152 0.0722 0 0 0 0 0 1 0" /><feComponentTransfer><feFuncR type="table" tableValues="0.26 1" /><feFuncG type="table" tableValues="0.49 1" /><feFuncB type="table" tableValues="0.71 1" /></feComponentTransfer></filter></svg>
<!-- /wp:html -->

<!-- wp:query-title {"type":"archive","level":1,"textAlign":"left","align":"wide","style":{"typography":{"fontStyle":"normal","fontWeight":"700","letterSpacing":"0.04em","lineHeight":"0.95","textTransform":"uppercase"}},"fontSize":"xx-large"} /-->

<!-- wp:query {"queryId":20,"query":{"perPage":24,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":true},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:group {"className":"djnl-masonry-wrap","layout":{"type":"default"}} -->
<div class="wp-block-group djnl-masonry-wrap"><!-- wp:post-template {"className":"djnl-masonry","layout":{"type":"default"}} -->
<!-- wp:group {"className":"djnl-card","style":{"spacing":{"blockGap":"0.85rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group djnl-card"><!-- wp:post-title {"level":2,"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"700","lineHeight":"0.95","textTransform":"uppercase"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->

<!-- wp:post-featured-image {"isLink":true,"scale":"cover","sizeSlug":"large","className":"djnl-feature-image"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:group -->

<!-- wp:query-pagination {"paginationArrow":"arrow","style":{"spacing":{"margin":{"top":"3rem"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
HTML;

function djnl_theme_of( int $post_id ): array {
	$terms = wp_get_object_terms( $post_id, 'wp_theme', [ 'fields' => 'slugs' ] );
	return is_wp_error( $terms ) ? [] : $terms;
}

function djnl_find_scoped( string $post_type, string $post_name, string $theme ): int {
	global $wpdb;
	$ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = %s AND post_name = %s AND post_status = 'publish'",
			$post_type,
			$post_name
		)
	);
	foreach ( $ids as $id ) {
		if ( in_array( $theme, djnl_theme_of( (int) $id ), true ) ) {
			return (int) $id;
		}
	}
	return 0;
}

function djnl_upsert( string $post_type, string $slug, string $title, string $content, string $area = '' ): int {
	global $wpdb;
	$id = djnl_find_scoped( $post_type, $slug, 'azur' );
	if ( $id ) {
		wp_update_post(
			[
				'ID'           => $id,
				'post_content' => $content,
				'post_status'  => 'publish',
			]
		);
		clean_post_cache( $id );
		return $id;
	}

	$id = wp_insert_post(
		[
			'post_type'    => $post_type,
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug . '-azur-tmp-' . wp_generate_password( 6, false ),
			'post_content' => $content,
		],
		true
	);
	if ( is_wp_error( $id ) ) {
		fwrite( STDERR, $id->get_error_message() . "\n" );
		return 0;
	}
	$wpdb->update( $wpdb->posts, [ 'post_name' => $slug ], [ 'ID' => $id ] );
	clean_post_cache( $id );
	wp_set_object_terms( $id, 'azur', 'wp_theme' );
	if ( $area ) {
		wp_set_object_terms( $id, $area, 'wp_template_part_area' );
	}
	clean_post_cache( $id );
	return (int) $id;
}

$header_id  = djnl_upsert( 'wp_template_part', 'header', 'Header', $header, 'header' );
$index_id   = djnl_upsert( 'wp_template', 'index', 'Index', $index );
$footer_id  = djnl_upsert( 'wp_template_part', 'footer', 'Footer', $footer, 'footer' );
$single_id  = djnl_upsert( 'wp_template', 'single', 'Single', $single );
$archive_id = djnl_upsert( 'wp_template', 'archive', 'Archive', $archive );

$styles_id = (int) WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
$styles    = json_decode( get_post_field( 'post_content', $styles_id, 'raw' ), true );
if ( ! is_array( $styles ) ) {
	$styles = array(
		'version'                     => 3,
		'isGlobalStylesUserThemeJSON' => true,
	);
}
$styles['styles']['css'] = '.djnl-swatches { list-style: none; margin: 0; padding: 0; position: fixed; top: 0; left: var(--wp--preset--spacing--70); z-index: 100; display: flex; gap: 2px; } .djnl-swatches li { display: block; width: 48px; height: 5px; transition: height .2s ease; } .djnl-swatches li.blue { background: #37bbff; } .djnl-swatches li.green { background: #74c707; } .djnl-swatches li.pink { background: #ff09de; } .djnl-swatches li.orange { background: #ff4c06; } .djnl-swatches li.grey { background: #636363; } .djnl-swatches li:hover { height: 10px; } ' . '.djnl-feature-image, .djnl-feature-image img { border: 0 !important; } .djnl-feature-image img { filter: none !important; } .djnl-feature-query .djnl-feature-image img { animation: djnl-soft-in 720ms ease both; } .djnl-feature-query .wp-block-post-title { width: 66.666% !important; max-width: 66.666% !important; } .djnl-feature-author, .djnl-feature-author a { display: block; width: 66.666%; max-width: 66.666%; margin-top: 1.35rem; color: #5c5c5c !important; font-size: 0.95rem !important; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; text-decoration: none !important; } .djnl-feature-author a:hover { color: #37bbff !important; } .djnl-feature-photo { width: 50% !important; max-width: 50% !important; margin-left: auto !important; margin-right: 0 !important; } .djnl-feature-photo .djnl-feature-image, .djnl-feature-photo .djnl-feature-image img { width: 100% !important; max-width: 100% !important; height: auto; } .djnl-feature-query { margin-block-end: 9rem !important; } main .djnl-feature-row.alignwide { max-width: none !important; width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; display: block !important; } .djnl-feature-photo { margin-left: auto !important; margin-right: 0 !important; } .djnl-category .djnl-hover-image { justify-self: end; margin-left: auto; } .djnl-top-nav a, .djnl-footer-nav a { color: #2f2f2f !important; text-decoration: none !important; transition: color 240ms ease; } .djnl-top-nav a:hover, .djnl-footer-nav a:hover { color: #37bbff !important; } .djnl-header { width: 100%; } .djnl-header .wp-block-site-logo { margin: 5rem 0 0 !important; } .djnl-header .wp-block-site-logo img { width: min(480px, 100%); height: auto; } .djnl-top-nav { max-width: none !important; width: 100% !important; margin: 0 !important; } .djnl-top-nav, .djnl-top-nav a, .djnl-top-nav .wp-block-navigation-item__label { font-size: clamp(0.78rem, 0.9vw, 0.95rem) !important; font-weight: 600; letter-spacing: 0.12em; } .djnl-top-nav .wp-block-navigation__container { gap: 2.25rem; flex-wrap: nowrap; justify-content: flex-start; width: 100%; } .djnl-about, .djnl-about p { color: #111111 !important; font-size: 1.6rem !important; line-height: 1.35; } .djnl-about { margin-top: 2.5rem !important; max-width: 42rem; } nav.djnl-top-nav { border-bottom: 1px solid #dedede; padding-bottom: 1.35rem; } .djnl-top-nav a { position: relative; } .djnl-top-nav a::after { content: \'\'; position: absolute; left: 0; right: 0; height: 2px; bottom: calc(-1.35rem - 1px); background: #37bbff; transform: scaleX(0); transform-origin: left center; transition: transform 240ms ease; } .djnl-top-nav a:hover::after { transform: scaleX(1); } .djnl-footer-nav .wp-block-navigation__container { gap: 1.75rem; flex-wrap: wrap; justify-content: flex-start; } .djnl-footer-nav, .djnl-footer-nav a, .djnl-footer-nav .wp-block-navigation-item__label { font-size: 1.05rem !important; } .djnl-feature-query .wp-block-post-title a { transition: color 240ms ease; } .djnl-category .wp-block-post-title, .djnl-category .wp-block-post-title a { font-size: clamp(2rem, 5.6vw, 5.15rem) !important; overflow-wrap: normal; word-break: normal; transition: color 240ms ease; } .djnl-feature-query .wp-block-post-title a:hover, .djnl-category .wp-block-post-title a:hover { color: #37bbff; } footer .wp-block-group { row-gap: 2.75rem; } footer .wp-block-group p { color: #2f2f2f !important; font-weight: 400; font-size: 1.125rem !important; line-height: 1.65; } footer .wp-block-group p.djnl-copyright { font-size: 0.8rem !important; font-weight: 500; letter-spacing: 0.02em; } footer .wp-block-group p a { color: #2f2f2f !important; text-decoration: underline; text-underline-offset: 0.12em; transition: color 240ms ease; } footer .wp-block-group p a:hover { color: #37bbff !important; } .djnl-category > .wp-block-heading, .djnl-category > .wp-block-heading a, .djnl-category > .wp-block-heading a:hover, .djnl-category > .wp-block-heading a:visited { color: #2f2f2f; text-decoration: none; } .djnl-category + .djnl-category { margin-top: 11rem; }  .djnl-feature-main, .djnl-category, .djnl-category .wp-block-query, .djnl-category .wp-block-post-template { overflow: visible; } .djnl-category .wp-block-post { position: relative; max-width: none; width: 100%; } .djnl-category .djnl-cat-post { display: grid !important; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); column-gap: 2.5rem; align-items: start; } .djnl-category .djnl-cat-copy { margin: 0; } .djnl-category .djnl-cat-author { margin-top: 1.15rem; } .djnl-cat-author, .djnl-cat-author a { display: block; color: #5c5c5c !important; font-size: 0.95rem !important; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; text-decoration: none !important; } .djnl-cat-author a:hover { color: #37bbff !important; } .djnl-hover-image { position: relative; left: auto; top: auto; width: 100%; max-width: none; margin: 0; opacity: 0; pointer-events: none; transition: opacity 520ms ease; z-index: 1; } .djnl-hover-image img { width: 100% !important; height: auto; } .djnl-category .wp-block-post:hover .djnl-hover-image, .djnl-category .wp-block-post:focus-within .djnl-hover-image { opacity: 1; } @media (max-width: 960px) { .djnl-top-nav, .djnl-top-nav a, .djnl-top-nav .wp-block-navigation-item__label { font-size: 0.68rem !important; letter-spacing: 0.08em; } .djnl-top-nav .wp-block-navigation__container { flex-wrap: nowrap; justify-content: flex-start; gap: 0.7rem; } .djnl-header .wp-block-site-logo img { width: min(480px, 78vw); } .djnl-about, .djnl-about p { font-size: 1.2rem !important; } .djnl-category .djnl-cat-post { display: block !important; } .djnl-hover-image { display: block; opacity: 1; width: min(220px, 72%); max-width: 220px; margin-top: 0.85rem; pointer-events: auto; } .djnl-category .wp-block-post { max-width: none; } .djnl-feature-photo { width: 100% !important; max-width: none !important; } .djnl-feature-query .wp-block-post-title, .djnl-feature-author, .djnl-feature-author a { width: 100% !important; max-width: none !important; } footer .wp-block-group p { font-size: 0.9rem !important; } footer .djnl-footer-nav, footer .djnl-footer-nav a, footer .djnl-footer-nav .wp-block-navigation-item__label { font-size: 0.8rem !important; } footer .wp-block-group p.djnl-copyright { font-size: 0.68rem !important; } } body:not(.home) .djnl-about { display: none !important; } main.djnl-single h1.wp-block-post-title { color: #9d00ff !important; font-size: clamp(3.2rem, 7vw, 6.25rem) !important; line-height: 0.85 !important; text-transform: uppercase; font-weight: 700; } .djnl-single .wp-block-post-content, .djnl-single .wp-block-post-content p, .djnl-single .wp-block-post-content li { color: #111111; font-weight: 400; line-height: 1.7; } .djnl-single .wp-block-post-content p { margin-top: 0; margin-bottom: 1.45rem; } .djnl-single .wp-block-post-content p { clear: both; } .djnl-single .wp-block-post-content figure, .djnl-single .wp-block-post-content .wp-block-image, .djnl-single .wp-block-post-content .wp-caption, .djnl-single .wp-block-post-content img.alignleft, .djnl-single .wp-block-post-content img.alignright, .djnl-single .wp-block-post-content img.aligncenter, .djnl-single .wp-block-post-content img.alignnone, .djnl-single .wp-block-post-content p > img { float: none !important; clear: both !important; display: block !important; margin-top: 5rem !important; margin-bottom: 5rem !important; margin-left: 0 !important; margin-right: auto !important; max-width: 100% !important; height: auto; } .djnl-single .wp-block-post-content figure.aligncenter, .djnl-single .wp-block-post-content img.aligncenter { margin-left: auto !important; margin-right: auto !important; } .djnl-single .djnl-meta { margin-top: 1.85rem !important; color: #5c5c5c !important; font-size: 0.95rem; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; } .djnl-single .djnl-meta a, .djnl-single .djnl-meta .wp-block-post-date, .djnl-single .djnl-meta .wp-block-post-author-name, .djnl-single .djnl-meta .wp-block-post-terms { color: #5c5c5c !important; text-decoration: none; font-size: inherit; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; } .djnl-single .djnl-meta a { transition: color 240ms ease; } .djnl-single .djnl-meta a:hover { color: #37bbff !important; } .djnl-single .djnl-meta > * + *::before { content: \'/\'; margin-left: 1.15rem; margin-right: 1.15rem; color: #c8c8c8; } .djnl-single .djnl-single-image { margin-top: 2.75rem !important; margin-bottom: 4.5rem !important; } @keyframes djnl-soft-in { from { opacity: 0; } to { opacity: 1; } } @media (prefers-reduced-motion: reduce) { .djnl-feature-query .djnl-feature-image img { animation: none; } .djnl-hover-image { transition: none; transform: none; } .djnl-masonry .djnl-feature-image img { transition: none !important; transform: none !important; } .djnl-top-nav a::after { transition: none; transform: none; } } .djnl-single .wp-block-post-content a { color: #9d00ff; text-decoration: underline; text-underline-offset: 0.15em; transition: color 240ms ease; } .djnl-single .wp-block-post-content a:hover { color: #37bbff; } .djnl-tags, .djnl-tags a, .djnl-tags a:visited { color: #b5b5b5 !important; text-decoration: none; font-weight: 500; } .djnl-tags { margin-top: 5.5rem !important; } .djnl-tags a:hover { color: #9d00ff !important; } .djnl-single .wp-block-post-content .wp-block-image, .djnl-single .wp-block-post-content .wp-block-image img, .djnl-single .wp-block-post-content img { border: 0 !important; filter: none !important; } .djnl-archive .djnl-feature-image, .djnl-archive .djnl-feature-image img { filter: none !important; width: 100% !important; max-width: 100% !important; height: auto !important; } .djnl-archive .wp-block-query-title { color: #111111 !important; text-transform: uppercase !important; font-weight: 700 !important; letter-spacing: 0.04em; font-size: clamp(2.4rem, 5vw, 4.25rem) !important; line-height: 0.95 !important; display: block; } main.djnl-archive .wp-block-query.alignwide, main.djnl-archive h1.wp-block-query-title { max-width: min(1320px, 100%) !important; width: 100% !important; margin-left: 0 !important; margin-right: 0 !important; } .djnl-archive .wp-block-query-pagination { display: none !important; } .djnl-masonry { column-count: 2; column-gap: 2.25rem; width: 100%; } .djnl-masonry.is-ready { column-count: auto; position: relative; } .djnl-masonry > .wp-block-post { break-inside: avoid; display: block !important; width: auto !important; margin: 0 0 2.75rem; } .djnl-masonry.is-ready > .wp-block-post { margin: 0; width: var(--djnl-col) !important; max-width: var(--djnl-col) !important; } .djnl-masonry .wp-block-post-title, .djnl-masonry .wp-block-post-title a { font-size: clamp(1.35rem, 2vw, 1.85rem) !important; line-height: 0.95 !important; text-transform: uppercase; font-weight: 700; color: #9d00ff; text-decoration: none; transition: color 240ms ease; } .djnl-masonry .wp-block-post-title a:hover, .djnl-masonry .wp-block-post:hover .wp-block-post-title a, .djnl-masonry .wp-block-post:focus-within .wp-block-post-title a { color: #37bbff; } .djnl-masonry .djnl-feature-image { overflow: hidden; display: block; } .djnl-masonry .djnl-feature-image img { transition: transform 520ms ease; } .djnl-masonry .wp-block-post:hover .djnl-feature-image img, .djnl-masonry .wp-block-post:focus-within .djnl-feature-image img { transform: scale(1.035); } @media (max-width: 640px) { .djnl-masonry { column-count: 1; } }';
$styles['settings']['color']['palette']['theme'] = array(
	array( 'slug' => 'primary', 'color' => '#9d00ff', 'name' => 'Primary' ),
	array( 'slug' => 'secondary', 'color' => '#37bbff', 'name' => 'Secondary' ),
	array( 'slug' => 'background', 'color' => '#ffffff', 'name' => 'Background' ),
	array( 'slug' => 'accent', 'color' => '#9d00ff11', 'name' => 'Accent' ),
	array( 'slug' => 'accent-2', 'color' => '#2f2f2f', 'name' => 'Accent / Two' ),
);
kses_remove_filters();
wp_update_post(
	[
		'ID'           => $styles_id,
		'post_content' => wp_json_encode( $styles ),
	]
);
kses_init_filters();
clean_post_cache( $styles_id );

if ( function_exists( 'wp_clean_theme_json_cache' ) ) {
	wp_clean_theme_json_cache();
}
wp_cache_flush();

$nav = get_post( 9436 );
if ( $nav ) {
	$clean = preg_replace( '/<!-- wp:navigation-link \{[^>]*"label":"Concierge"[^>]*\/-->\s*/', '', $nav->post_content );
	$clean = preg_replace( '#https?://(?:www\.)?dayjobsnightlife\.com#', '', $clean );
	$clean = preg_replace( '#https?://127\.0\.0\.1:8080#', '', $clean );
	if ( is_string( $clean ) && $clean !== $nav->post_content ) {
		kses_remove_filters();
		wp_update_post(
			[
				'ID'           => 9436,
				'post_content' => $clean,
			]
		);
		kses_init_filters();
	}
}
wp_update_post(
	[
		'ID'          => 16,
		'post_status' => 'draft',
	]
);

echo "header=$header_id index=$index_id footer=$footer_id single=$single_id archive=$archive_id\n";
echo 'header theme=' . implode( ',', djnl_theme_of( $header_id ) ) . "\n";
echo 'index theme=' . implode( ',', djnl_theme_of( $index_id ) ) . "\n";
echo 'footer theme=' . implode( ',', djnl_theme_of( $footer_id ) ) . "\n";
echo 'single theme=' . implode( ',', djnl_theme_of( $single_id ) ) . "\n";
echo 'archive theme=' . implode( ',', djnl_theme_of( $archive_id ) ) . "\n";
