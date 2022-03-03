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
define( 'DB_NAME', 'joiabd' );

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
define( 'AUTH_KEY',         'z*v,UQG^DdG8fR(zGsx9=1V;cur;o&=^!m3QA3CkJ&9wq8w~>HOOU~Vq-sqn=Pm:' );
define( 'SECURE_AUTH_KEY',  'N)q-i7@7.;/O55(YE_A.Eo-e)LU8AIiY}DaQnkOsIB;u}nd[cHr!&Z?(<Mq= 14y' );
define( 'LOGGED_IN_KEY',    'S ?P0I!d5s6&?(>]?0ECV#0YM)@BNq6+i{<4U:@^Z<e{`I&mj|vj{w`uagi[5sac' );
define( 'NONCE_KEY',        'QtM@Q3*7WQ.)7,tw!e|KYBGm5o`zu _82b5.d!BQbc$$J,X{&39x9bEa><f)z5Jl' );
define( 'AUTH_SALT',        '(vv/Pv~<AS_R^[DVjf7hD<]~h mGdOX{>*f#lUIb^uf`$G$oLb:nH {?Jx4p^agb' );
define( 'SECURE_AUTH_SALT', 'GRmc7_.B;zdmj}tU|k&Glk}.sU}7;0qU#t~9>zr&!#pv5H<6,ORt[a5$zhUrn=[3' );
define( 'LOGGED_IN_SALT',   'V8?@788lHj_m<&t&nI?y3;B?mc_xAMp)i$6iQpUM#@EW30]qNziCn%>L+d>#}+_m' );
define( 'NONCE_SALT',       'c<Yfg/Ag<2w|0:V3:M#54/=<D6Yt(K/slx[s*g%_lKn]$oX5Ro)&L^&V7e0DaYny' );

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
