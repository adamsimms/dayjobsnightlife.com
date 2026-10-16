<?php
/**
 * Save the local WordPress site as a folder of static files.
 *
 * Usage, from anywhere:
 * php wordpress/scripts/export-static.php
 *
 * The local site must already be running at http://127.0.0.1:8080/.
 * Writes a fresh folder. Copy that folder into the repo root when ready.
 */

$origin = 'http://127.0.0.1:8080';
$out    = '/Users/adamsimms/Desktop/dayjobsnightlife-static';
$host   = '127.0.0.1';
$port   = 8080;

if ( is_dir( $out ) ) {
	fwrite( STDERR, "output already exists: {$out}\nRemove it before running again.\n" );
	exit( 1 );
}
mkdir( $out, 0755, true );

$seen_html  = array();
$seen_files = array();
$failures   = array();
$html_count = 0;
$file_count = 0;
$bytes      = 0;

$queue = seeds( $origin );
$queue[] = $origin . '/';

while ( $queue ) {
	$batch = array();
	while ( $queue && count( $batch ) < 6 ) {
		$url = array_shift( $queue );
		$key = html_key( $url );
		if ( isset( $seen_html[ $key ] ) || ! $key ) {
			continue;
		}
		$seen_html[ $key ] = true;
		$batch[]           = $url;
	}
	if ( ! $batch ) {
		continue;
	}
	foreach ( fetch_batch( $batch ) as $result ) {
		$code = (int) $result['code'];
		$body = (string) $result['body'];
		if ( 200 !== $code || '' === $body ) {
			$failures[] = $code . ' ' . $result['url'];
			continue;
		}
		$final = $result['effective'] ?: $result['url'];
		if ( ! same_site( $final, $host, $port ) ) {
			continue;
		}
		$rel = dest_for( $final, true );
		if ( ! $rel ) {
			continue;
		}
		foreach ( extract_refs( $body, $final ) as $ref ) {
			$abs = resolve_url( $final, $ref );
			if ( ! $abs || ! same_site( $abs, $host, $port ) ) {
				continue;
			}
			$kind = kind_of( $abs );
			if ( 'html' === $kind && ! blocked_html( $abs ) ) {
				$queue[] = strip_fragment( $abs );
			} elseif ( 'file' === $kind ) {
				enqueue_file( $seen_files, $abs );
			}
		}
		$saved = rewrite_text( strip_wp_discovery( $body ) );
		write_rel( $out, $rel, $saved );
		$html_count++;
		$bytes += strlen( $saved );
		if ( 0 === $html_count % 50 ) {
			echo "pages {$html_count}\n";
		}
	}
}

$file_queue = array_keys( $seen_files );
$index      = 0;
while ( $index < count( $file_queue ) ) {
	$batch = array_slice( $file_queue, $index, 6 );
	$index += count( $batch );
	foreach ( fetch_batch( $batch ) as $result ) {
		$code = (int) $result['code'];
		$body = (string) $result['body'];
		$url  = $result['effective'] ?: $result['url'];
		if ( 200 !== $code || '' === $body || ! same_site( $url, $host, $port ) ) {
			$failures[] = $code . ' ' . $result['url'];
			continue;
		}
		if ( strlen( $body ) > 25 * 1024 * 1024 ) {
			$failures[] = 'too-large ' . $url;
			continue;
		}
		$rel = dest_for( $url, false );
		if ( ! $rel ) {
			continue;
		}
		$is_css = str_ends_with( strtolower( $rel ), '.css' );
		if ( $is_css ) {
			foreach ( extract_css_urls( $body ) as $ref ) {
				$abs = resolve_url( $url, $ref );
				if ( $abs && same_site( $abs, $host, $port ) && 'file' === kind_of( $abs ) ) {
					enqueue_file( $seen_files, $abs );
					if ( ! in_array( strip_fragment( $abs ), $file_queue, true ) ) {
						$file_queue[] = strip_query( strip_fragment( $abs ) );
					}
				}
			}
			$body = rewrite_text( $body );
		}
		write_rel( $out, $rel, $body );
		$file_count++;
		$bytes += strlen( $body );
	}
}

$not_found = @file_get_contents(
	$origin . '/this-page-does-not-exist-djnl/',
	false,
	stream_context_create(
		array(
			'http' => array( 'ignore_errors' => true ),
		)
	)
);
if ( is_string( $not_found ) && str_contains( $not_found, 'wp-theme-azur' ) ) {
	write_rel( $out, '404.html', rewrite_text( strip_wp_discovery( $not_found ) ) );
}

echo "pages {$html_count}\n";
echo "files {$file_count}\n";
echo "bytes {$bytes}\n";
echo 'failures ' . count( $failures ) . "\n";
foreach ( array_slice( $failures, 0, 40 ) as $line ) {
	echo $line, "\n";
}
require_once __DIR__ . '/share-styles.php';
djnl_share_styles( $out );
echo "out {$out}\n";

function seeds( string $origin ): array {
	$index = file_get_contents( $origin . '/wp-sitemap.xml' );
	$urls  = array();
	if ( ! is_string( $index ) ) {
		return $urls;
	}
	preg_match_all( '#<loc>([^<]+)</loc>#', $index, $maps );
	foreach ( $maps[1] as $map ) {
		$xml = file_get_contents( html_entity_decode( $map ) );
		if ( ! is_string( $xml ) ) {
			continue;
		}
		preg_match_all( '#<loc>([^<]+)</loc>#', $xml, $locs );
		foreach ( $locs[1] as $loc ) {
			$urls[] = html_entity_decode( $loc );
		}
	}
	return $urls;
}

function enqueue_file( array &$seen, string $url ): void {
	$url = strip_query( strip_fragment( $url ) );
	$seen[ $url ] = true;
}

function fetch_batch( array $urls ): array {
	$multi   = curl_multi_init();
	$handles = array();
	foreach ( $urls as $url ) {
		$ch = curl_init( $url );
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_MAXREDIRS      => 5,
				CURLOPT_TIMEOUT        => 90,
				CURLOPT_CONNECTTIMEOUT => 10,
				CURLOPT_ENCODING       => '',
				CURLOPT_USERAGENT      => 'djnl-static-export',
			)
		);
		curl_multi_add_handle( $multi, $ch );
		$handles[ $url ] = $ch;
	}
	do {
		$status = curl_multi_exec( $multi, $active );
		if ( $active ) {
			curl_multi_select( $multi, 1.0 );
		}
	} while ( $active && CURLM_OK === $status );

	$out = array();
	foreach ( $handles as $url => $ch ) {
		$out[] = array(
			'url'       => $url,
			'effective' => curl_getinfo( $ch, CURLINFO_EFFECTIVE_URL ),
			'code'      => curl_getinfo( $ch, CURLINFO_HTTP_CODE ),
			'body'      => curl_multi_getcontent( $ch ),
		);
		curl_multi_remove_handle( $multi, $ch );
	}
	curl_multi_close( $multi );
	return $out;
}

function extract_refs( string $html, string $base ): array {
	$refs = array();
	if ( preg_match_all( '/(?:href|src|poster)\\s*=\\s*([\'"])(.*?)\\1/i', $html, $m ) ) {
		foreach ( $m[2] as $ref ) {
			$refs[] = $ref;
		}
	}
	if ( preg_match_all( '/srcset\\s*=\\s*([\'"])(.*?)\\1/i', $html, $m ) ) {
		foreach ( $m[2] as $srcset ) {
			foreach ( explode( ',', $srcset ) as $part ) {
				$part = trim( $part );
				if ( '' === $part ) {
					continue;
				}
				$bits   = preg_split( '/\\s+/', $part );
				$refs[] = $bits[0];
			}
		}
	}
	foreach ( extract_css_urls( $html ) as $ref ) {
		$refs[] = $ref;
	}
	return $refs;
}

function extract_css_urls( string $text ): array {
	$refs = array();
	if ( preg_match_all( '/url\\(\\s*([\'"]?)([^\'")]+)\\1\\s*\\)/i', $text, $m ) ) {
		foreach ( $m[2] as $ref ) {
			if ( str_starts_with( $ref, 'data:' ) || str_starts_with( $ref, '#' ) ) {
				continue;
			}
			$refs[] = $ref;
		}
	}
	return $refs;
}

function resolve_url( string $base, string $ref ): ?string {
	$ref = trim( html_entity_decode( $ref, ENT_QUOTES ) );
	if ( '' === $ref || str_starts_with( $ref, '#' ) || str_starts_with( $ref, 'mailto:' ) || str_starts_with( $ref, 'tel:' ) || str_starts_with( $ref, 'data:' ) || str_starts_with( $ref, 'javascript:' ) ) {
		return null;
	}
	if ( str_starts_with( $ref, '//' ) ) {
		$ref = 'http:' . $ref;
	}
	$parts = parse_url( $ref );
	if ( ! empty( $parts['host'] ) ) {
		return $ref;
	}
	$b    = parse_url( $base );
	$path = $parts['path'] ?? '';
	if ( ! str_starts_with( $path, '/' ) ) {
		$dir  = preg_replace( '#/[^/]*$#', '/', $b['path'] ?? '/' );
		$path = $dir . $path;
	}
	$query = isset( $parts['query'] ) ? '?' . $parts['query'] : '';
	return $b['scheme'] . '://' . $b['host'] . ( isset( $b['port'] ) ? ':' . $b['port'] : '' ) . normalize_path( $path ) . $query;
}

function normalize_path( string $path ): string {
	$parts = array();
	foreach ( explode( '/', $path ) as $part ) {
		if ( '' === $part || '.' === $part ) {
			continue;
		}
		if ( '..' === $part ) {
			array_pop( $parts );
			continue;
		}
		$parts[] = $part;
	}
	return '/' . implode( '/', $parts );
}

function same_site( string $url, string $host, int $port ): bool {
	$p = parse_url( $url );
	return ( $p['host'] ?? '' ) === $host && (int) ( $p['port'] ?? 80 ) === $port;
}

function kind_of( string $url ): string {
	$path = parse_url( $url, PHP_URL_PATH ) ?? '/';
	$base = strtolower( basename( $path ) );
	if ( in_array( $base, array( 'robots.txt', 'favicon.ico' ), true ) ) {
		return 'file';
	}
	$ext = strtolower( pathinfo( $base, PATHINFO_EXTENSION ) );
	if ( in_array( $ext, array( 'css', 'js', 'map', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'ico', 'bmp', 'ttf', 'woff', 'woff2', 'eot', 'otf', 'mp4', 'webm', 'pdf', 'avif' ), true ) ) {
		return 'file';
	}
	if ( 'php' === $ext ) {
		return 'skip';
	}
	return 'html';
}

function blocked_html( string $url ): bool {
	$path = parse_url( $url, PHP_URL_PATH ) ?? '/';
	if ( str_contains( $url, '?' ) ) {
		return true;
	}
	$blocked = array( '/wp-admin', '/wp-json', '/wp-login.php', '/wp-cron.php', '/xmlrpc.php', '/wp-sitemap' );
	foreach ( $blocked as $prefix ) {
		if ( str_starts_with( $path, $prefix ) ) {
			return true;
		}
	}
	return 1 === preg_match( '#/(feed|comments)(/|$)#', $path );
}

function html_key( string $url ): string {
	$p = parse_url( strip_fragment( $url ) );
	$path = $p['path'] ?? '/';
	if ( ! str_ends_with( $path, '/' ) ) {
		$path .= '/';
	}
	return $path;
}

function dest_for( string $url, bool $html ): ?string {
	$path = parse_url( $url, PHP_URL_PATH ) ?? '/';
	$path = rawurldecode( $path );
	if ( str_contains( $path, '..' ) ) {
		return null;
	}
	$path = normalize_path( $path );
	if ( $html ) {
		if ( '/' === $path ) {
			return 'index.html';
		}
		return trim( $path, '/' ) . '/index.html';
	}
	$rel = ltrim( $path, '/' );
	if ( '' === $rel || str_ends_with( $rel, '/' ) ) {
		return null;
	}
	return $rel;
}

function strip_fragment( string $url ): string {
	$pos = strpos( $url, '#' );
	return false === $pos ? $url : substr( $url, 0, $pos );
}

function strip_query( string $url ): string {
	$pos = strpos( $url, '?' );
	return false === $pos ? $url : substr( $url, 0, $pos );
}

function rewrite_text( string $text ): string {
	$text = preg_replace( '#https?://127\\.0\\.0\\.1:8080#', '', $text );
	$text = preg_replace( '#https?://(?:www\\.)?dayjobsnightlife\\.com#', '', $text );
	return $text;
}

function strip_wp_discovery( string $html ): string {
	$html = preg_replace( '#<link[^>]+rel=[\'"](?:https://api\\.w\\.org/|EditURI|wlwmanifest|shortlink|pingback)[\'"][^>]*>\\s*#i', '', $html );
	$html = preg_replace( '#<link[^>]+type=[\'"]application/rss\\+xml[\'"][^>]*>\\s*#i', '', $html );
	$html = preg_replace( '#<link[^>]+type=[\'"](?:application|text)/(?:json|xml)\\+oembed[\'"][^>]*>\\s*#i', '', $html );
	return $html;
}

function write_rel( string $root, string $rel, string $body ): void {
	$dest = $root . '/' . $rel;
	$dir  = dirname( $dest );
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0755, true );
	}
	file_put_contents( $dest, $body );
}
