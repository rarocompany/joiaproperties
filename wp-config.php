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
define( 'AUTH_KEY',         'gIvm?^[qEkLYg<0uoiN&AP:2g ;@0_Aq)EdT/AGdy2t+dT@LjDZe-,:ZC>U#V$%B' );
define( 'SECURE_AUTH_KEY',  'Z=5*;/i^=fbj{S-``kK<<SPrCb[J)CE%imDE>!)gLs{Ws0w?UdCArRe>*-S}R.`!' );
define( 'LOGGED_IN_KEY',    'gFhU7JAajkD;q}+!Eo1oA@LiT^#u?Acr;HoiThtKU`J`gjeY,=O`QP%ZX6f.d Gz' );
define( 'NONCE_KEY',        '->|W<yNUIgDZy+|lc.Phqc`NTW|;IUqZbO2y@iLzR1P?WcUyxjha)nUeQ%_(US`f' );
define( 'AUTH_SALT',        'cX+!/(P#C)UeYn5xlurd.d$gVp {=^&nBLyOzwQF{UZ(NqX$uX_y]e( EfudeE$`' );
define( 'SECURE_AUTH_SALT', 'xP`J=`ITX2Wt7y:H-H),lm#yi}mk%?KO!p4%]/Nab@mO`u~PXGE3KbHm-[@PPaBn' );
define( 'LOGGED_IN_SALT',   'MOK#1@h;kJHv~6of)h>.Pz:iwLO7KKJ;4<~X8i0%9/Il;UPE><w`)]^Z.LGPq,D9' );
define( 'NONCE_SALT',       '^yZDbg?@x{m;Da?DQjQ* uTBJ*kYuVt5;~~$tZHlR;37da{H7E_Er/.z0{AuxOpc' );

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
