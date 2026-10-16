# Day Jobs / Nightlife

Static site for [dayjobsnightlife.pages.dev](https://dayjobsnightlife.pages.dev/). HTML, CSS, fonts, and images live at the repo root. Cloudflare Pages deploys from the `main` branch.

## Deploy

Pushes to `main` deploy production. The Pages build drops the WordPress tooling before upload:

```
rm -rf wordpress
```

Build output directory: `/`

## WordPress tooling

Layout templates and the static export scripts are under [`wordpress/`](wordpress/). They are not part of the live site. See [`wordpress/README.md`](wordpress/README.md).
