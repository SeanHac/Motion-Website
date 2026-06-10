<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'LE6~S0oRm^6n$OR-qq`B2:~(9p7u[/8_GOJs82L,/P[EW8}>+I<HgE=L-Y?-kT}M' );
define( 'SECURE_AUTH_KEY',   'tf: x6Wn.~*iXEG+`nPQGDUi{P/6UVQKURtClS^~@^/VUhS$4<Z4qj]eVog._I5@' );
define( 'LOGGED_IN_KEY',     ',W$`e*Co#T Fiiqat.wi-2WYdS:.7O|=Y((S`a,:@.3C`ccxA)_O-f)6eAf In|(' );
define( 'NONCE_KEY',         '!13,Oofx6SQiht5AcppWlxBG>J=N._o2cnC,8k2^[ZR7lay&aB1;jOB_7U3,mo|X' );
define( 'AUTH_SALT',         '8&p5YXVk/dt2`E9Pz[m0_+S&LWXCd>:c8YJ+|No! 98I@L+kZ^p@msk{J.9_]m.)' );
define( 'SECURE_AUTH_SALT',  'SZ-^)5h4-v$Rqffm<?ryU^$*>eq`l)_eXbDEv(EPnBX|?PEZsFE^&+SP3]E&V[!3' );
define( 'LOGGED_IN_SALT',    '6+Zfx&^p`k(<z=S/u]Ie%`+<)WhP4)S*;K)mL*&Yb %{eao@R#A3J9jOS|1V(&WH' );
define( 'NONCE_SALT',        'tna>-$/s~O:K^P(xC.iS!flrxQqxX228D|O.;&}_Fr>!k/z6@s7<u`l;]beZAq}J' );
define( 'WP_CACHE_KEY_SALT', '/CbdWxb1n7l.f_;T5p<wuW$R*n!8yjoK]7 |5M{U`xBY$$%dwxFxgZ5a/t5;C|&I' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'WP_MEMORY_LIMIT', '512M' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
