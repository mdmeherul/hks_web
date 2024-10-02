<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hks_db' );

/** Database username */
define( 'DB_USER', 'HKSdevUSR' );

/** Database password */
define( 'DB_PASSWORD', 'HKSdevDB@2024' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Cw=IJvK]J:B%ipu>>2dD)VMZYl_HYDp9pfz,x!,Q}GlPx[%bx!BZ8Gddfrt9{ ;V' );
define( 'SECURE_AUTH_KEY',  '!bXF6>/Ld5q&7P=2Z{NC;#h|m-d5~^91zxgq>^Aer^>EKf9Qh?Y!@!T3>+tPIe$h' );
define( 'LOGGED_IN_KEY',    '9`dOt<2j=WEwP@tD(SLge4y>rvLz3XjK:XO5~{IiFWiJ#hkf1Gj&]/7JNcu*VA&*' );
define( 'NONCE_KEY',        'K3<8|m#TB# eqT3_.kH2Qoy_|!wg%ct(#)^vu#8t^egW]?pQn*6W8ON=3:45sLzp' );
define( 'AUTH_SALT',        '<XEP`JO:Vn)C%Q=i.5Z#I=JTog|.^_c?Y+40ezT&|R38ha5qpfi!@0;CTq+0NxEN' );
define( 'SECURE_AUTH_SALT', '^EiG5.=S$Z*a17U6Z0~(Q/E.*I1h{e[nzO;7H26y~j!qXQCQY<RS9%i(0X)u6FzG' );
define( 'LOGGED_IN_SALT',   '}XU9#Ju6k}!kIg2:J]IJvXrj6-L=mYPEkBH@{7;:9MhOm2r7yl1}Dwj+cLXDR&>L' );
define( 'NONCE_SALT',       'satFJgD^kU:s_/^_r}Cd@ehtr}o16@$!Err17WX%d<|-IYE5xSvNhO!m34W.:^)M' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
