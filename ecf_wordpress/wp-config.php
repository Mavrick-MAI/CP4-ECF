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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecf_wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '_+909g|A`^JYD6O-g iXyA9${Qt&Kjh,P{}m*aP<>6]u3$nLL:IUz236z)MmPQB[' );
define( 'SECURE_AUTH_KEY',  'L<V4}z.l21BTlekM]L%etHFV<HyA.eNA};8FwTH71Oa~?*A]Vk^]52Z{[~3B+,#%' );
define( 'LOGGED_IN_KEY',    'DYBf!QC2Vf6LHuw9slkWKPxJAP;?S:5}x[t-%#(4>P27wvcA#S>l57#EpX6E:,%#' );
define( 'NONCE_KEY',        '/sT:GdVzQ_-. U-jhloNkG^q`e&Y$.f)hkB:9XUYt(rM-}33u@Pe(b}[P5Ex$k|%' );
define( 'AUTH_SALT',        '_tqcr_vPIO)%r`;,x1LCU*)oC&eLeSkSK9>{*9e)T=b&WRS2bw4[~^mQYGN_7#45' );
define( 'SECURE_AUTH_SALT', 't!l*7Aj<3N~@&:4Z2;YLr8Mw<:yI^4>R@QUc_XP[uA~+y/1aF90@`7LV&[HzIhSH' );
define( 'LOGGED_IN_SALT',   ';08lYF 97`U]`[BB1:JQR@d+NzqhxdTmo+hDF<)+ii!`T1}`L*gimXime* =})b9' );
define( 'NONCE_SALT',       'S]x+5-SqRTL}y~!$/0ZS}A)geH<(~&g^;G], `#mT])TNvH]&%xLTz}9EaL-./jX' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
