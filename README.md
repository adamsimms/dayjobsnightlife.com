# Day Jobs and the Nightlife

Custom WordPress theme for [dayjobsnightlife.com](https://dayjobsnightlife.com), originally built on [Sage 8](https://roots.io/sage/) and modernized for current Node and PHP tooling.

## Requirements

| Prerequisite | Version |
| --- | --- |
| WordPress | 5.x or newer |
| PHP | 7.4+ |
| Node.js | 20.x |
| npm | 9+ |

### Recommended WordPress plugins

| Plugin | Purpose |
| --- | --- |
| [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/) | `tag-line` field on posts |
| [Soil](https://roots.io/plugins/soil/) | Cleaner markup, nice search, relative URLs |
| Mailchimp plugin | Powers the footer signup form via shortcode |

Configure social links, contact details, Mailchimp shortcode, and Adobe Fonts kit ID under **Appearance → Customize → Theme Options**.

## Development

```bash
nvm use
npm install
npm run build
```

### Available scripts

| Command | Description |
| --- | --- |
| `npm run build` | Compile theme assets into `dist/` |
| `npm run build:production` | Production build with asset revisioning |
| `npm run watch` | Watch files and reload via BrowserSync |
| `npm run lint:js` | Lint theme JavaScript |
| `composer phpcs` | Lint PHP against `ruleset.xml` |

Update `assets/manifest.json` → `config.devUrl` to match your local WordPress URL before running `npm run watch`.

## Theme structure

```
assets/          Source styles, scripts, and images
dist/            Compiled assets (committed for deployment)
lib/             PHP theme logic
templates/       Partial templates
templates/home/  Homepage layout partials
home.php         Homepage template
```

Homepage category IDs and featured-post meta values live in `lib/home.php`.

## Deployment

Built assets are committed in `dist/`, so the theme works on a server without Node installed. After changing styles or scripts locally, run `npm run build:production` and commit the updated `dist/` files.

## License

MIT
