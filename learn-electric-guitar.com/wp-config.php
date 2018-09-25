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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'kjvbodbx_wp247');

/** MySQL database username */
define('DB_USER', 'kjvbodbx_wp247');

/** MySQL database password */
define('DB_PASSWORD', '[uL37P@SP4');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'qborpp9hko6yjxppkiqrdoxokdl7gtlpz1ss0hyzu9d7aqszttia4rd3x2qugw1t');
define('SECURE_AUTH_KEY',  'lznjmbtdc5brasl9hmew77pi4iddosybqjfkzzsmcy6cpfhkjwabh2wok6s9rtvj');
define('LOGGED_IN_KEY',    'id9dbuyckp9pyn2hmt08hqvj75lk5i6kk4goix0hwa7mmkomm16m2vcbalywmgw8');
define('NONCE_KEY',        'c39xn2v0fpdx1dwdlmxgbosrdvjlfv0vjch0dbh39uifwszidrdlgntwqsdtnjcf');
define('AUTH_SALT',        '05dqcvbje8gmm64ehyftxmippesfjxmqxlr0g15hbafecxofs6k9ozczfglutvww');
define('SECURE_AUTH_SALT', '33keyni7b4iks3td4xgu44qtybwfxx6cyuzjqbpc3h1w4uucf2jj0cvhigy1ivcn');
define('LOGGED_IN_SALT',   'rcbmjvtekxa4mxghpt8osn0d2hefgbyvb3l7rb7avsnncbhkagqtc0xbncsoreiz');
define('NONCE_SALT',       'gto6hk4ttkjsslsczwu1k6fyd5fm2sna2picxt4l45lb9dtkqdpt3pd2wcbhxxoi');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wptb_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
