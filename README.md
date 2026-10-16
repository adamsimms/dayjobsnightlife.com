# Day Jobs / Nightlife

Static site for [dayjobsnightlife.pages.dev](https://dayjobsnightlife.pages.dev/). HTML lives at the repo root. Styles are in `css/`, media in `assets/images/` and `assets/fonts/`. Cloudflare Pages deploys from the `main` branch.

## Deploy

Pushes to `main` deploy production. The Pages build drops non-site paths before upload:

```
rm -rf wordpress README.md .gitignore
```

Build output directory: `/`

## WordPress tooling

Layout templates and the static export scripts are under [`wordpress/`](wordpress/). They are not part of the live site. See [`wordpress/README.md`](wordpress/README.md).
