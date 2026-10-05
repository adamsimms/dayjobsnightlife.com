# Day Jobs / Nightlife

Source for the custom layout on the live site. The active theme is Azur 1.0.4, installed as-is. These files are the parts that are not in the theme.

- `layout/djnl-azur-index.php` rebuilds the header, homepage, footer, single post, and category templates, and writes the custom CSS.
- `layout/djnl-archive-title.php` goes in `wp-content/mu-plugins/`. It sets the category title, the staggered columns, and the scroll that loads more posts.

From the WordPress directory, reapply the templates with:

```
wp eval 'include "/absolute/path/to/layout/djnl-azur-index.php";'
```

The script expects the existing posts, categories, and navigation. It does not install Azur. It also sets the palette: purple `#9d00ff` for links and titles, blue `#37bbff` for hover. Azur's own default link color is blue, so titles stay that blue until this script has been applied.

Category links in the menu are stored on the navigation post. The script rewrites them to root-relative paths such as `/category/restaurants/`, so they stay on whatever address you used to open the site. Absolute `https://` menu links send the browser to HTTPS, and that certificate is not set up.
