<?php
/**
 * Category archives show the category name on its own.
 */

add_filter(
	'get_the_archive_title_prefix',
	static function ( $prefix ) {
		if ( is_category() ) {
			return '';
		}
		return $prefix;
	}
);

add_filter(
	'query_loop_block_query_vars',
	static function ( $query, $block ) {
		$include = $block->context['query']['include'] ?? null;
		if ( empty( $include ) || ! is_array( $include ) ) {
			return $query;
		}
		$ids = array_values( array_filter( array_map( 'intval', $include ) ) );
		if ( ! $ids ) {
			return $query;
		}
		$query['post__in']            = $ids;
		$query['orderby']             = 'post__in';
		$query['ignore_sticky_posts'] = 1;
		return $query;
	},
	10,
	2
);

add_action(
	'pre_get_posts',
	static function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! $query->is_category() ) {
			return;
		}
		$query->set( 'posts_per_page', 12 );
	}
);

add_filter(
	'render_block',
	static function ( $html, $block ) {
		if ( ( $block['blockName'] ?? '' ) !== 'core/post-template' ) {
			return $html;
		}
		if ( strpos( $html, 'djnl-masonry' ) === false ) {
			return $html;
		}
		$html = preg_replace( '/<ul\b/', '<div', $html, 1 );
		$html = preg_replace( '/<\/ul>/', '</div>', $html, 1 );
		return str_replace( [ '<li', '</li>' ], [ '<div', '</div>' ], $html );
	},
	10,
	2
);

add_action(
	'wp_footer',
	static function () {
		if ( ! is_category() ) {
			return;
		}
		echo <<<'HTML'
<script>
(function () {
  var grid = document.querySelector(".djnl-masonry");
  if (!grid) return;
  var nextLink = document.querySelector("a.wp-block-query-pagination-next");
  var nextUrl = nextLink ? nextLink.href : "";
  var loading = false;
  var gap = 44;
  var offset = 200;
  var seen = {};

  function remember(node) {
    var link = node.querySelector("a");
    if (link) seen[link.href] = true;
  }

  Array.prototype.forEach.call(grid.children, remember);

  function columnCount() {
    return window.matchMedia("(max-width: 640px)").matches ? 1 : 2;
  }

  var frame = 0;
  function layout() {
    cancelAnimationFrame(frame);
    frame = requestAnimationFrame(place);
  }

  function place() {
    var count = columnCount();
    var items = Array.prototype.slice.call(grid.children);
    var width = grid.clientWidth;
    if (!width || !items.length) return;
    var colWidth = (width - gap * (count - 1)) / count;
    var heights = [];
    for (var i = 0; i < count; i++) heights.push(i === 1 ? offset : 0);
    grid.classList.add("is-ready");
    grid.style.setProperty("--djnl-col", colWidth + "px");
    items.forEach(function (item) {
      item.style.position = "absolute";
      item.style.width = colWidth + "px";
      var shortest = 0;
      for (var c = 1; c < count; c++) {
        if (heights[c] < heights[shortest]) shortest = c;
      }
      item.style.left = (shortest * (colWidth + gap)) + "px";
      item.style.top = heights[shortest] + "px";
      heights[shortest] += item.offsetHeight + gap;
    });
    var max = 0;
    heights.forEach(function (h) { if (h > max) max = h; });
    grid.style.height = Math.max(0, max - gap) + "px";
  }

  function watch(node) {
    Array.prototype.forEach.call(node.querySelectorAll("img"), function (img) {
      if (img.complete) return;
      img.addEventListener("load", layout);
      img.addEventListener("error", layout);
    });
  }

  function maybeLoad() {
    if (!nextUrl || loading) return;
    var rect = grid.getBoundingClientRect();
    if (rect.bottom < window.innerHeight + 900) loadMore();
  }

  function loadMore() {
    if (!nextUrl || loading) return;
    loading = true;
    grid.setAttribute("aria-busy", "true");
    var url = nextUrl;
    fetch(url, { credentials: "same-origin" })
      .then(function (response) { return response.text(); })
      .then(function (html) {
        var doc = new DOMParser().parseFromString(html, "text/html");
        var added = 0;
        Array.prototype.forEach.call(doc.querySelectorAll(".djnl-masonry > *"), function (node) {
          var link = node.querySelector("a");
          if (link && seen[link.href]) return;
          var copy = document.importNode(node, true);
          remember(copy);
          watch(copy);
          grid.appendChild(copy);
          added += 1;
        });
        var nxt = doc.querySelector("a.wp-block-query-pagination-next");
        nextUrl = nxt && nxt.href && nxt.href !== url ? nxt.href : "";
        if (!added) nextUrl = "";
        loading = false;
        grid.removeAttribute("aria-busy");
        layout();
        maybeLoad();
      })
      .catch(function () {
        loading = false;
        grid.removeAttribute("aria-busy");
      });
  }

  Array.prototype.forEach.call(grid.children, watch);
  window.addEventListener("scroll", maybeLoad, { passive: true });
  window.addEventListener("resize", layout);
  layout();
  maybeLoad();
})();
</script>
HTML;
	}
);
