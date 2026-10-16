<?php
/**
 * Move repeated WordPress styles into one stylesheet.
 *
 * Usage:
 * php wordpress/scripts/share-styles.php /path/to/static-export
 */

if ( PHP_SAPI === 'cli' && isset( $argv[0] ) && realpath( $argv[0] ) === realpath( __FILE__ ) ) {
	$dir = $argv[1] ?? '';
	if ( '' === $dir || ! is_dir( $dir ) ) {
		fwrite( STDERR, "usage: php wordpress/scripts/share-styles.php /path/to/static-export\n" );
		exit( 1 );
	}
	djnl_share_styles( $dir );
}

function djnl_share_styles( string $root ): void {
	$root  = rtrim( $root, '/' );
	$files = djnl_html_files( $root );
	$ready = false;
	foreach ( $files as $file ) {
		$head = file_get_contents( $file, false, null, 0, 200000 );
		if ( is_string( $head ) && str_contains( $head, 'global-styles-inline-css' ) ) {
			$ready = true;
			break;
		}
	}
	if ( ! $ready ) {
		fwrite( STDERR, "styles are already shared\n" );
		djnl_finish_static( $root );
		return;
	}

	$order = array(
		'wp-img-auto-sizes-contain-inline-css',
		'wp-block-navigation-link-inline-css',
		'wp-block-navigation-inline-css',
		'wp-block-site-logo-inline-css',
		'wp-block-paragraph-inline-css',
		'wp-block-group-inline-css',
		'wp-block-query-title-inline-css',
		'wp-block-post-title-inline-css',
		'wp-block-post-date-inline-css',
		'wp-block-post-author-name-inline-css',
		'wp-block-post-terms-inline-css',
		'wp-block-post-featured-image-inline-css',
		'wp-block-image-inline-css',
		'wp-block-post-content-inline-css',
		'wp-block-post-navigation-link-inline-css',
		'wp-block-post-template-inline-css',
		'wp-block-query-pagination-inline-css',
		'wp-block-heading-inline-css',
		'wp-block-search-inline-css',
		'wp-block-spacer-inline-css',
		'wp-block-library-inline-css',
	);
	$skip = array(
		'wp-emoji-styles-inline-css'       => true,
		'global-styles-inline-css'         => true,
		'core-block-supports-inline-css'   => true,
	);

	$blocks   = array();
	$extra    = array();
	$global   = array();
	$supports = array();
	$seen_g   = array();
	$seen_s   = array();
	$fonts    = '';

	foreach ( $files as $file ) {
		$html = file_get_contents( $file );
		if ( ! is_string( $html ) || ! str_contains( $html, '<style' ) ) {
			continue;
		}
		foreach ( djnl_style_tags( $html ) as $tag ) {
			if ( 'wp-fonts-local' === $tag['class'] || ( '' === $tag['id'] && str_contains( $tag['css'], '@font-face' ) ) ) {
				if ( '' === $fonts ) {
					$fonts = $tag['css'];
				}
				continue;
			}
			if ( isset( $skip[ $tag['id'] ] ) ) {
				if ( 'global-styles-inline-css' === $tag['id'] ) {
					djnl_add_rules( $global, $seen_g, $tag['css'] );
				} elseif ( 'core-block-supports-inline-css' === $tag['id'] ) {
					djnl_add_rules( $supports, $seen_s, $tag['css'] );
				}
				continue;
			}
			if ( '' === $tag['id'] || isset( $blocks[ $tag['id'] ] ) ) {
				continue;
			}
			$blocks[ $tag['id'] ] = $tag['css'];
			if ( ! in_array( $tag['id'], $order, true ) ) {
				$extra[] = $tag['id'];
			}
		}
	}

	$parts = array( '/* Shared styles for the static pages. */' );
	foreach ( array_merge( $order, $extra ) as $id ) {
		if ( isset( $blocks[ $id ] ) ) {
			$parts[] = trim( $blocks[ $id ] );
		}
	}
	if ( $global ) {
		$parts[] = implode( "\n", $global );
	}
	if ( $supports ) {
		$parts[] = implode( "\n", $supports );
	}
	if ( '' !== $fonts ) {
		$parts[] = trim( $fonts );
	}
	$css  = implode( "\n\n", $parts ) . "\n";
	$path = $root . '/css/site.css';
	file_put_contents( $path, $css );

	$before = 0;
	$after  = 0;
	$pages  = 0;
	foreach ( $files as $file ) {
		$html = file_get_contents( $file );
		if ( ! is_string( $html ) || ! str_contains( $html, 'wp-theme-azur' ) ) {
			continue;
		}
		$before += strlen( $html );
		$next    = djnl_strip_page( $html );
		if ( ! is_string( $next ) ) {
			fwrite( STDERR, "strip failed {$file}\n" );
			$after += strlen( $html );
			continue;
		}
		if ( str_contains( $html, '</main>' ) && ! str_contains( $next, '</main>' ) ) {
			fwrite( STDERR, "refusing to drop the page body {$file}\n" );
			$after += strlen( $html );
			continue;
		}
		if ( $next !== $html ) {
			file_put_contents( $file, $next );
			$pages++;
		}
		$after += strlen( $next );
	}

	echo 'site.css ' . strlen( $css ) . "\n";
	echo "pages {$pages}\n";
	echo "html {$before} -> {$after}\n";
	djnl_finish_static( $root );
}

function djnl_html_files( string $root ): array {
	$files = array();
	$it    = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS )
	);
	foreach ( $it as $file ) {
		if ( $file->isFile() && str_ends_with( strtolower( $file->getFilename() ), '.html' ) ) {
			$files[] = $file->getPathname();
		}
	}
	sort( $files, SORT_STRING );
	$index = $root . '/index.html';
	if ( in_array( $index, $files, true ) ) {
		$files = array_merge( array( $index ), array_values( array_diff( $files, array( $index ) ) ) );
	}
	return $files;
}

function djnl_style_tags( string $html ): array {
	$tags = array();
	if ( ! preg_match_all( '#<style\b([^>]*)>(.*?)</style>#is', $html, $matches, PREG_SET_ORDER ) ) {
		return $tags;
	}
	foreach ( $matches as $match ) {
		$attrs = $match[1];
		$id    = '';
		$class = '';
		if ( preg_match( '#\bid=[\'"]([^\'"]+)#', $attrs, $id_match ) ) {
			$id = $id_match[1];
		}
		if ( preg_match( '#\bclass=[\'"]([^\'"]+)#', $attrs, $class_match ) ) {
			$class = $class_match[1];
		}
		$tags[] = array(
			'id'    => $id,
			'class' => $class,
			'css'   => $match[2],
		);
	}
	return $tags;
}

function djnl_add_rules( array &$ordered, array &$seen, string $css ): void {
	foreach ( djnl_split_css( $css ) as $rule ) {
		if ( '' === $rule || str_contains( strtolower( $rule ), 'duotone' ) ) {
			continue;
		}
		if ( isset( $seen[ $rule ] ) ) {
			continue;
		}
		$seen[ $rule ] = true;
		$ordered[]     = $rule;
	}
}

function djnl_split_css( string $css ): array {
	$rules = array();
	$len   = strlen( $css );
	$i     = 0;
	while ( $i < $len ) {
		while ( $i < $len && ctype_space( $css[ $i ] ) ) {
			$i++;
		}
		if ( $i >= $len ) {
			break;
		}
		if ( substr( $css, $i, 2 ) === '/*' ) {
			$end = strpos( $css, '*/', $i + 2 );
			$end = false === $end ? $len : $end + 2;
			$i   = $end;
			continue;
		}
		$start = $i;
		$depth = 0;
		while ( $i < $len ) {
			$char = $css[ $i ];
			if ( '{' === $char ) {
				$depth++;
			} elseif ( '}' === $char ) {
				$depth--;
				if ( 0 === $depth ) {
					$i++;
					break;
				}
			}
			$i++;
		}
		$rule = trim( substr( $css, $start, $i - $start ) );
		if ( '' !== $rule ) {
			$rules[] = $rule;
		}
	}
	return $rules;
}

function djnl_strip_page( string $html ): string {
	$html = djnl_remove_elements(
		$html,
		'style',
		function () {
			return true;
		}
	);
	$link = '<link rel="stylesheet" href="/css/site.css" />' . "\n";
	if ( ! str_contains( $html, 'href="/css/site.css"' ) ) {
		$azur = preg_replace( '#(<link[^>]+id=[\'"]azur-style-css[\'"][^>]*>)#i', $link . '$1', $html, 1 );
		if ( is_string( $azur ) && $azur !== $html ) {
			$html = $azur;
		} else {
			$head = preg_replace( '#</head>#i', $link . '</head>', $html, 1 );
			if ( is_string( $head ) ) {
				$html = $head;
			}
		}
	}
	$generator = preg_replace( '#<meta[^>]+name=[\'"]generator[\'"][^>]*>\s*#i', '', $html );
	if ( is_string( $generator ) ) {
		$html = $generator;
	}
	$html = djnl_remove_elements(
		$html,
		'svg',
		function ( $chunk ) {
			return str_contains( $chunk, 'wp-duotone-default-filter' );
		}
	);
	$html = djnl_remove_elements(
		$html,
		'script',
		function ( $chunk ) {
			return str_contains( $chunk, 'wp-emoji-settings' ) || str_contains( $chunk, 'wp-emoji-loader' );
		}
	);
	return djnl_strip_static_links( $html );
}

function djnl_finish_static( string $root ): void {
	file_put_contents( $root . '/_headers', djnl_headers() );
	$fonts = djnl_trim_fonts( $root );
	$pages = 0;
	foreach ( djnl_html_files( $root ) as $file ) {
		$html = file_get_contents( $file );
		if ( ! is_string( $html ) || ! str_contains( $html, 'wp-theme-azur' ) ) {
			continue;
		}
		$next = djnl_strip_static_links( $html );
		if ( str_contains( $html, '</main>' ) && ! str_contains( $next, '</main>' ) ) {
			fwrite( STDERR, "refusing to drop the page body {$file}\n" );
			continue;
		}
		if ( $next !== $html ) {
			file_put_contents( $file, $next );
			$pages++;
		}
	}
	$bmp = djnl_delete_bmp_html( $root );
	djnl_delete_tree( $root . '/wp-content' );
	echo "static links {$pages}\n";
	echo "fonts {$fonts}\n";
	echo "bmp {$bmp}\n";
	require_once __DIR__ . '/static-seo.php';
	djnl_apply_seo( $root );
}

function djnl_headers(): string {
	return <<<'EOF'
# HTML keeps the Pages default: revalidate on each visit.
# Images, fonts, and the stylesheet stay cached.
/assets/images/*
  Cache-Control: public, max-age=31536000, immutable

/assets/fonts/*
  Cache-Control: public, max-age=31536000, immutable

/css/site.css
  Cache-Control: public, max-age=31536000, immutable
EOF;
}

function djnl_strip_static_links( string $html ): string {
	$next = preg_replace( '#<link\b[^>]*href=[\'"][^\'"]*/wp-json[^\'"]*[\'"][^>]*>\s*#i', '', $html );
	if ( ! is_string( $next ) ) {
		return $html;
	}
	$azur = preg_replace( '#<link\b[^>]*id=[\'"]azur-style-css[\'"][^>]*>\s*#i', '', $next );
	return is_string( $azur ) ? $azur : $next;
}

function djnl_trim_fonts( string $root ): int {
	$path = $root . '/css/site.css';
	$css  = file_get_contents( $path );
	if ( ! is_string( $css ) ) {
		return 0;
	}
	$dir = $root . '/fonts';
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0755, true );
	}
	$kept = 0;
	$css  = preg_replace_callback(
		'#@font-face\{[^}]+\}#',
		function ( array $match ) use ( $root, $dir, &$kept ): string {
			$rule = $match[0];
			if ( ! preg_match( '#font-style:\s*normal#', $rule ) ) {
				return '';
			}
			if ( ! preg_match( '#font-weight:\s*(400|500|600|700)\b#', $rule, $weight ) ) {
				return '';
			}
			if ( ! preg_match( "#url\\(\\s*['\"]?([^'\")]+)#", $rule, $url ) ) {
				return '';
			}
			$src  = $url[1];
			$path = parse_url( $src, PHP_URL_PATH );
			$path = is_string( $path ) && '' !== $path ? $path : $src;
			$name = basename( $path );
			$from = $root . '/' . ltrim( $path, '/' );
			$dest = $dir . '/' . $name;
			if ( is_file( $from ) ) {
				copy( $from, $dest );
			}
			if ( ! is_file( $dest ) ) {
				fwrite( STDERR, "missing font {$name}\n" );
				return $rule;
			}
			$kept++;
			$rewritten = preg_replace( '#url\\([^)]+\\)\\)?#', "url('/assets/fonts/{$name}')", $rule, 1 );
			return is_string( $rewritten ) ? $rewritten : $rule;
		},
		$css
	);
	if ( is_string( $css ) ) {
		file_put_contents( $path, $css );
	}
	return $kept;
}

function djnl_delete_bmp_html( string $root ): int {
	$removed = 0;
	foreach ( glob( $root . '/assets/images/*', GLOB_ONLYDIR ) ?: array() as $dir ) {
		if ( str_ends_with( strtolower( $dir ), '.bmp' ) ) {
			djnl_delete_tree( $dir );
			$removed++;
		}
	}
	return $removed;
}

function djnl_delete_tree( string $dir ): void {
	if ( ! is_dir( $dir ) ) {
		return;
	}
	$files = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::CHILD_FIRST
	);
	foreach ( $files as $file ) {
		if ( $file->isDir() ) {
			rmdir( $file->getPathname() );
		} else {
			unlink( $file->getPathname() );
		}
	}
	rmdir( $dir );
}

function djnl_remove_elements( string $html, string $tag, callable $remove ): string {
	$out    = '';
	$offset = 0;
	$open   = '<' . $tag;
	$close  = '</' . $tag . '>';
	$len    = strlen( $html );
	while ( $offset < $len ) {
		$start = stripos( $html, $open, $offset );
		if ( false === $start ) {
			break;
		}
		$next = $start + strlen( $open );
		if ( $next < $len && ! str_contains( " \t\r\n>/", $html[ $next ] ) ) {
			$offset = $next;
			continue;
		}
		$gt = strpos( $html, '>', $start );
		if ( false === $gt ) {
			break;
		}
		$end = stripos( $html, $close, $gt );
		if ( false === $end ) {
			break;
		}
		$end  += strlen( $close );
		$chunk = substr( $html, $start, $end - $start );
		$out  .= substr( $html, $offset, $start - $offset );
		if ( ! $remove( $chunk ) ) {
			$out .= $chunk;
		} else {
			while ( $end < $len && str_contains( " \t\r\n", $html[ $end ] ) ) {
				$end++;
			}
		}
		$offset = $end;
	}
	$out .= substr( $html, $offset );
	return $out;
}
