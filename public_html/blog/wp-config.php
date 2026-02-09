<?php
include '../inc/config.php';
$env = ($_SERVER['HTTP_HOST'] == 'localhost:8001') ? 'localhost:8001' : 'production';
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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $config[$env]['DB_NAME']);

/** Database username */
define('DB_USER', $config[$env]['DB_USER']);

/** Database password */
define('DB_PASSWORD', $config[$env]['DB_PASSWORD']);

/** Database hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         'b(=[m@NPG?02 c3%mJ(|#pde3~,Ny;qb9b1Hd0Y--w>FM&k^:Ve|bEX];,7issKR' );
define( 'SECURE_AUTH_KEY',  'RFo_93YwPiUTmv@RarT2}Y{/N4_BcIegimp`Sk9N}(LdWeJmnh]#Dn1|KgD:5~!8' );
define( 'LOGGED_IN_KEY',    'gBToJWe(QF`T1bp4I_?eKHN&LaWPCh<ms@k-Ib/WXfddrT*T8 kktW65^S0{TZs}' );
define( 'NONCE_KEY',        ',`Wdx 0_rBZ7Lg6$S>].O?=9,;DawFi<S~7NOYb:f@yN?BazQTw?7nw*`G506#z&' );
define( 'AUTH_SALT',        '1+tF{Io;Lk6R(Q>aCl ]Q0t,QzKa^:0Q}j{!W06PO;fU%fjp9#[>o#w+N)Xrd}ic' );
define( 'SECURE_AUTH_SALT', 'q-a@N(H(!y5Px)R#<`2*#i_NeRM~< 5YL+[[SkkG$8`O6XC]1m#c[Z9WV^giQzPH' );
define( 'LOGGED_IN_SALT',   'F&%qim{ G?Ep[w6wKSmvf7AXYko~j;6[D8f>cH<ES#hW,Tft:E*W!O@O#>kqhNTj' );
define( 'NONCE_SALT',       'OgufQ?Ya|053?p.=QS)p~Ga_MEp#K>(VqKv9%{qk+81pZ=~ut%!H`r.AJ%=4%64%' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'ts_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
