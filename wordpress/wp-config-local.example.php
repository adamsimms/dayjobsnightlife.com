<?php
/**
 * Local boot only. Copy to wp-config-local.php next to wp-config.php
 * and require it before the production database settings.
 * Do not commit wp-config-local.php or wp-config.php with real credentials.
 */
define( 'DB_NAME', 'djnl_local' );
define( 'DB_USER', 'your_local_user' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );

define( 'WP_CACHE', false );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_ENVIRONMENT_TYPE', 'local' );

define( 'WP_HOME', 'http://127.0.0.1:8080' );
define( 'WP_SITEURL', 'http://127.0.0.1:8080' );

// The built-in PHP server cannot serve a page and WordPress's loopback cron at the same time.
define( 'DISABLE_WP_CRON', true );
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'WP_AUTO_UPDATE_CORE', false );
