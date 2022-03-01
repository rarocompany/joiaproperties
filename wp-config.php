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
define( 'AUTH_KEY',         'D*$}TtXU`Xh#c73!p}`*5N@#QuyTKa95ndz#g26j4,d:56YVL>xX=@*vI?e34~jI' );
define( 'SECURE_AUTH_KEY',  'Zy%IjTxft4s(k#V8* lJIN@nC*b(14~@Ff$Go#}}Am=>@hA7Rr1{BFr}DPV/Y?:(' );
define( 'LOGGED_IN_KEY',    '|-)PoU}WTMP<wvJ4K]ZJ7jo0[WmA)U{uZ7IGbGAz=2DsWBY<0IW^]]IZKUjIKURw' );
define( 'NONCE_KEY',        '830JH=GGd!ACzyNtczS_|#]+:qRbyHVVLW+p=4ka/keL{-*Zoxbz5Y>7Z-k828W5' );
define( 'AUTH_SALT',        ' rK<!m!ng;X$oXGO%}.TA_8QR4{FG-EJi`NP}Mgs5`P,mW.gswItBi?QM6)]iX1z' );
define( 'SECURE_AUTH_SALT', 'L6rFXZ%I<z)bm;B5:,z?64{;q=opOAQ;KdvKcib5A9@^}n(i=Y|dP.J/Esz3>>Cg' );
define( 'LOGGED_IN_SALT',   'y-`V$kpmUZ,z~^|2aeFZplHk4vADaqwa9tz`cW[?2pdR{GaEGW-_q68}Y3dEi><q' );
define( 'NONCE_SALT',       '.:FjLIBf#uvnW{V:ym],%X,#:}g r2ZOk39R[]~za*Z>X;MOQjv0wFMd1}!}MdiN' );

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
