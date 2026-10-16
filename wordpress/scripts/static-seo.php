<?php
/**
 * Descriptions, canonical URLs, social tags, and a sitemap for the static export.
 */

function djnl_apply_seo( string $root ): void {
	$origin = 'https://dayjobsnightlife.com';
	$urls   = array();
	$pages  = 0;
	foreach ( djnl_html_files( $root ) as $file ) {
		$rel = ltrim( substr( $file, strlen( rtrim( $root, '/' ) ) ), '/' );
		if ( str_starts_with( $rel, 'assets/' ) ) {
			continue;
		}
		$html = file_get_contents( $file );
		if ( ! is_string( $html ) || ! str_contains( $html, '</head>' ) ) {
			continue;
		}
		if ( '404.html' === $rel ) {
			$next = djnl_write_seo_head( $html, '', 'The page you requested is not on Day Jobs / Nightlife.', true );
			if ( $next !== $html ) {
				file_put_contents( $file, $next );
				$pages++;
			}
			continue;
		}
		$public = djnl_public_path( $rel );
		if ( null === $public ) {
			continue;
		}
		$noindex   = djnl_should_noindex( $rel );
		$canon_path = djnl_preferred_path( $root, $public );
		$canonical = $origin . $canon_path;
		$desc      = djnl_meta_description( $html, $public );
		$next      = djnl_write_seo_head( $html, $canonical, $desc, $noindex );
		if ( str_contains( $html, '</main>' ) && ! str_contains( $next, '</main>' ) ) {
			fwrite( STDERR, "refusing to drop the page body {$file}\n" );
			continue;
		}
		if ( $next !== $html ) {
			file_put_contents( $file, $next );
			$pages++;
		}
		if ( ! $noindex && $canon_path === $public ) {
			$urls[ $canonical ] = gmdate( 'Y-m-d', filemtime( $file ) );
		}
	}
	djnl_write_sitemap( $root, $urls );
	file_put_contents(
		$root . '/robots.txt',
		"User-agent: *\nAllow: /\n\nSitemap: {$origin}/sitemap.xml\n"
	);
	echo 'seo pages ' . $pages . "\n";
	echo 'sitemap ' . count( $urls ) . "\n";
}

function djnl_public_path( string $rel ): ?string {
	if ( '404.html' === $rel ) {
		return null;
	}
	if ( 'index.html' === $rel ) {
		return '/';
	}
	if ( ! str_ends_with( $rel, '/index.html' ) ) {
		return null;
	}
	return '/' . substr( $rel, 0, -strlen( 'index.html' ) );
}

function djnl_should_noindex( string $rel ): bool {
	return str_starts_with( $rel, 'tag/' )
		|| str_starts_with( $rel, 'type/' )
		|| 'here/index.html' === $rel
		|| '404.html' === $rel;
}

function djnl_preferred_path( string $root, string $public ): string {
	if ( str_starts_with( $public, '/category/' ) || str_starts_with( $public, '/author/' ) || str_starts_with( $public, '/tag/' ) ) {
		return $public;
	}
	$mirror = $root . '/category' . rtrim( $public, '/' ) . '/index.html';
	if ( is_file( $mirror ) ) {
		return '/category' . $public;
	}
	return $public;
}

function djnl_meta_description( string $html, string $public ): string {
	if ( '/' === $public && preg_match( '#<div class="[^"]*\bdjnl-about\b[^"]*">.*?<p\b[^>]*>(.*?)</p>#is', $html, $about ) ) {
		return djnl_clip( djnl_plain( $about[1] ), 160 );
	}
	$paragraph = djnl_first_paragraph( $html );
	if ( strlen( $paragraph ) >= 40 && ! str_contains( $paragraph, 'Montreal has thousands of restaurants' ) ) {
		return djnl_clip( $paragraph, 160 );
	}
	$title = djnl_plain_title( $html );
	if ( '' === $title ) {
		$title = 'Day Jobs / Nightlife';
	}
	return djnl_clip( $title . '. A guide to restaurants, bars, hotels, and the social scene in Montreal.', 160 );
}

function djnl_first_paragraph( string $html ): string {
	$scope = $html;
	if ( preg_match( '#<div class="wp-block-post-content\b[^>]*>(.*)#is', $html, $content ) ) {
		$scope = $content[1];
	} elseif ( preg_match( '#<main\b[^>]*>(.*)</main>#is', $html, $main ) ) {
		$scope = $main[1];
	}
	if ( ! preg_match( '#<p\b[^>]*>(.*?)</p>#is', $scope, $paragraph ) ) {
		return '';
	}
	return djnl_plain( $paragraph[1] );
}

function djnl_plain_title( string $html ): string {
	if ( ! preg_match( '#<title>(.*?)</title>#is', $html, $title ) ) {
		return '';
	}
	$text = djnl_plain( $title[1] );
	$text = preg_replace( '#\s+Day Jobs / Nightlife\s*$#u', '', $text );
	$text = preg_replace( '#[\s\-\x{2013}\x{2014}]+$#u', '', (string) $text );
	return trim( (string) $text );
}

function djnl_plain( string $html ): string {
	$text = preg_replace( '#<[^>]+>#', ' ', $html );
	$text = html_entity_decode( (string) $text, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$text = preg_replace( '/\s+/u', ' ', (string) $text );
	return trim( (string) $text );
}

function djnl_clip( string $text, int $max ): string {
	$text = trim( $text );
	if ( mb_strlen( $text ) <= $max ) {
		return $text;
	}
	$cut = mb_substr( $text, 0, $max );
	$sp  = mb_strrpos( $cut, ' ' );
	if ( false !== $sp && $sp > 80 ) {
		$cut = mb_substr( $cut, 0, $sp );
	}
	return rtrim( $cut, " \t.,;:" ) . '...';
}

function djnl_write_seo_head( string $html, string $canonical, string $description, bool $noindex ): string {
	$html = preg_replace( '#<!-- djnl-seo -->.*?<!-- /djnl-seo -->\s*#s', '', $html );
	$html = preg_replace( '#<link\b[^>]*rel=[\'"]canonical[\'"][^>]*>\s*#i', '', (string) $html );
	$html = preg_replace( '#<meta\b[^>]*name=[\'"]description[\'"][^>]*>\s*#i', '', (string) $html );
	$robots = $noindex ? 'noindex, follow, max-image-preview:large' : 'max-image-preview:large';
	$replaced = preg_replace(
		'#<meta\b[^>]*name=[\'"]robots[\'"][^>]*>#i',
		'<meta name="robots" content="' . $robots . '" />',
		(string) $html,
		1
	);
	if ( is_string( $replaced ) ) {
		$html = $replaced;
	}
	$image = '';
	if ( preg_match( '#<main\b[^>]*>.*?<img\b[^>]*\bsrc=[\'"]([^\'"]+)#is', $html, $img ) ) {
		$src = $img[1];
		if ( str_starts_with( $src, '/' ) ) {
			$image = 'https://dayjobsnightlife.com' . $src;
		} elseif ( str_starts_with( $src, 'https://dayjobsnightlife.com/' ) ) {
			$image = $src;
		}
	}
	$title = djnl_plain_title( $html );
	if ( '' === $title ) {
		$title = 'Day Jobs / Nightlife';
	}
	$type = str_contains( $html, 'single-post' ) ? 'article' : 'website';
	$esc  = static function ( string $value ): string {
		return htmlspecialchars( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	};
	$block = "<!-- djnl-seo -->\n";
	if ( '' !== $canonical ) {
		$block .= '<link rel="canonical" href="' . $esc( $canonical ) . '" />' . "\n";
	}
	$block .= '<meta name="description" content="' . $esc( $description ) . '" />' . "\n"
		. '<meta property="og:title" content="' . $esc( $title ) . '" />' . "\n"
		. '<meta property="og:description" content="' . $esc( $description ) . '" />' . "\n"
		. ( '' !== $canonical ? '<meta property="og:url" content="' . $esc( $canonical ) . '" />' . "\n" : '' )
		. '<meta property="og:type" content="' . $type . '" />' . "\n";
	if ( '' !== $image ) {
		$block .= '<meta property="og:image" content="' . $esc( $image ) . '" />' . "\n";
	}
	$block .= '<meta name="twitter:card" content="' . ( '' !== $image ? 'summary_large_image' : 'summary' ) . '" />' . "\n"
		. "<!-- /djnl-seo -->\n";
	$with = preg_replace( '#</head>#i', $block . '</head>', $html, 1 );
	return is_string( $with ) ? $with : $html;
}

function djnl_write_sitemap( string $root, array $urls ): void {
	ksort( $urls );
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	foreach ( $urls as $loc => $day ) {
		$xml .= "  <url><loc>" . htmlspecialchars( $loc, ENT_QUOTES | ENT_XML1, 'UTF-8' ) . "</loc><lastmod>{$day}</lastmod></url>\n";
	}
	$xml .= "</urlset>\n";
	file_put_contents( $root . '/sitemap.xml', $xml );
}
