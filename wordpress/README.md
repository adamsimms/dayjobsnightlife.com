# WordPress layout and export

Source for the custom Azur layout used when the site still ran WordPress, plus scripts that crawl a local WP install into a static folder.

These paths are kept in git for regeneration. Cloudflare Pages removes `wordpress/` before deploy, so nothing here is public on the static site.

## Layout

- `layout/djnl-azur-index.php` rebuilds the header, homepage, footer, single post, and category templates, and writes the custom CSS.
- `layout/djnl-archive-title.php` goes in `wp-content/mu-plugins/`. It sets the category title, the staggered columns, and the scroll that loads more posts.

From the WordPress directory, reapply the templates with:

```
wp eval 'include "/absolute/path/to/wordpress/layout/djnl-azur-index.php";'
```

The script expects the existing posts, categories, and navigation. It does not install Azur. Palette: purple `#9d00ff` for links and titles, blue `#37bbff` for hover.

## Static export

With a local site running at `http://127.0.0.1:8080/`:

```
php wordpress/scripts/export-static.php
```

That writes a fresh static tree (default output path is set in the script). Review it, then copy the result into the repo root when you want a new Pages deploy. Do not point the export straight at this git root while the site files are already here.
