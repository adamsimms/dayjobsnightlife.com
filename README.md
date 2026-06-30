# Day Jobs and the Nightlife

WordPress site for [dayjobsnightlife.com](https://dayjobsnightlife.com), managed with [Bedrock](https://roots.io/bedrock/) and a custom [Sage 10](https://roots.io/sage/) theme.

## Should WordPress live in this repo?

**Yes — for this project, that is the right call.** This repository now uses Bedrock, which means:

| In git | Not in git |
| --- | --- |
| WordPress core (via Composer) | `.env` secrets |
| Theme source + built assets | Database |
| Plugin declarations (Composer) | `web/app/uploads/` media |
| Config templates | Server credentials |

That gives you versioned infrastructure, reproducible installs, and safer deployments. You still migrate the database and uploads separately when moving environments.

## Hosting options

### Option A: Bedrock-native hosting (best)

Point the web server document root at `web/`. Deploy the full Bedrock project.

### Option B: Classic shared hosting + FTP (common)

Keep the existing WordPress install on the server and deploy **only the built theme** to:

`public_html/wp-content/themes/dayjobsnightlife/`

Set GitHub secret `FTP_DEPLOY_MODE=theme`.

## Requirements

- PHP 8.3+
- Composer 2
- Node.js 20+
- MySQL

## Local setup

```bash
cp .env.example .env
# Edit .env with local database credentials and WP_HOME

composer install
cd web/app/themes/dayjobsnightlife
composer install
npm install
npm run build
```

Point your local site URL at the value of `WP_HOME` in `.env` (for example `https://dayjobsnightlife.test`).

## Theme development

```bash
cd web/app/themes/dayjobsnightlife
npm run dev
```

## Plugins

Installed via Composer:

- Advanced Custom Fields

Recommended manual installs:

- [Soil](https://roots.io/plugins/soil/)
- Mailchimp plugin for the footer signup form

Theme options live under **Appearance → Customize → Theme Options**.

ACF field groups are versioned in `web/app/themes/dayjobsnightlife/resources/acf-json/`.

## Auto deploy to FTP

Configure these GitHub repository secrets:

| Secret | Example | Purpose |
| --- | --- | --- |
| `FTP_SERVER` | `ftp.example.com` | FTP host |
| `FTP_USERNAME` | `deploy@example.com` | FTP user |
| `FTP_PASSWORD` | `***` | FTP password |
| `FTP_DEPLOY_MODE` | `theme` or `bedrock` | Deploy strategy |
| `FTP_THEME_PATH` | `/public_html/wp-content/themes/dayjobsnightlife/` | Theme-only target |
| `FTP_REMOTE_PATH` | `/public_html/` | Bedrock/full-site target |

Pushes to `master`/`main` run `.github/workflows/deploy.yml`.

## Project structure

```
config/                 WordPress configuration
web/
  app/
    plugins/            Composer-managed plugins
    themes/
      dayjobsnightlife/ Sage 10 theme
        app/              PHP (Composers, setup, options)
        resources/        Blade views, SCSS, images, ACF JSON
        public/           Built assets
  wp/                   WordPress core (Composer)
```

## License

MIT
