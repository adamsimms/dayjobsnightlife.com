# Day Jobs / Nightlife

Source for the custom layout on the live site. The active theme is Azur 1.0.4, installed as-is. These files are the parts that are not in the theme.

- `layout/djnl-azur-index.php` rebuilds the header, homepage, footer, single post, and category templates, and writes the custom CSS.
- `layout/djnl-archive-title.php` goes in `wp-content/mu-plugins/`. It sets the category title, the staggered columns, and the scroll that loads more posts.

From the WordPress directory, reapply the templates with:

```
wp eval 'include "/absolute/path/to/layout/djnl-azur-index.php";'
```

The script expects the existing posts, categories, and navigation. It does not install Azur.
