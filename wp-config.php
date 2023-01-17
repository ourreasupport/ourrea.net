<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'WPCACHEHOME', '/srv/www/ourrea.net/wp-content/plugins/wp-super-cache/' );

define( 'DB_NAME', 'ourrea.net' );

/** MySQL database username */
define( 'DB_USER', 'ourrea.net' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Ourrea7375@' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'FEZT?u?7u?.k-Uxy1w4bC*W71%(w:,cH1$V4Ot$uaJ+sD8-hEi^XU;RWnl)92>ft' );
define( 'SECURE_AUTH_KEY',  'm|RN![O8!&9ueZ#q6R+M/X~y89rd5+@6kB(jgii@CyYm?|v7Tdd^+R^$[[SS)VUt' );
define( 'LOGGED_IN_KEY',    ',vyKschYp,UWGmv|U.F4s]Xq+w]C^]s+m,-5uwG,N0,BbEHy2f7Ir_e*N=< )^t~' );
define( 'NONCE_KEY',        'Y5`/{<| w!_7QsM_Qh<LCMk78_KK*jnI4c/@/BX,|_MkMmG!d(z=iFP)u^bK];DU' );
define( 'AUTH_SALT',        'x@>Ps4Ic@dNqx7O_XtB7ei~Dsc#.Fo6S,=g{s.=HbF={*u[]}xv Sv4BUc6W]FPM' );
define( 'SECURE_AUTH_SALT', 'l[8l=<(Nn;(s~[GdxzhmBmF3*UCjV3vdBTC+GmF$KQ&JxVPJ2|+Iln+#]^/fpyjm' );
define( 'LOGGED_IN_SALT',   'S7Vrp]CS<T//^Yb#aupmR#!QaD14DC#vH3HrXaq`$S-x}hx%2Jz+x}I<Xo:Z;j=R' );
define( 'NONCE_SALT',       '~+YUup{~;Yq{JXX0FPoazoG.K-8;S(8]a3F/9N?sf4e*;jA|Ym*Gyd55OwXWHmVs' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpbmdcxt_';

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

define('WP_CACHE', true);
define('DISALLOW_FILE_EDIT', true);
/* That's all, stop editing! Happy publishing. */

define('WP_HOME','https://ourrea.net');
define('WP_SITEURL','https://ourrea.net');

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
