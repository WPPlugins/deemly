<?php
/**
 * Plugin Name: deemly
 * Plugin URI: http://deemly.co
 * Description: Make use of the deemly score and Rating & Review system
 * Author: Jens Farvig Thomsen
 * Author URI: http://deemly.co
 * Version: 1.0.3
 * Text Domain: dmly
 * Domain Path: /lang/
 *
 *
 * WordPress deemly Porfile Score is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 *
 * @package dmly
 * @author Jens Farvig Thomsen
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Setup plugin constants
 *
 * @since 0.0.1
 * @return void
 */
	
// Plugin version
if ( ! defined( 'DMLY_VERSION' ) ) {
	define( 'DMLY_VERSION', '1.0.1' );
}

// Plugin Folder Path
if ( ! defined( 'DMLY_PLUGIN_DIR' ) ) {
	define( 'DMLY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( ! defined( 'DMLY_PLUGIN_URL' ) ) {
	define( 'DMLY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin Root File
if ( ! defined( 'DMLY_PLUGIN_FILE' ) ) {
	define( 'DMLY_PLUGIN_FILE', __FILE__ );
}

// Load textdomain
load_textdomain('dmly',  DMLY_PLUGIN_DIR . 'lang/dmly-' . get_locale() . '.mo');

/**
 * Include required files
 *
 * @since 0.0.1
 * @return void
 */

require_once ( DMLY_PLUGIN_DIR . 'inc/admin/register-settings.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/scripts.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/security-manager.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/api-calls.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/admin/helper-functions.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/admin/admin-pages.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/admin/register-user-settings.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/dmly-widgets.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/short-codes.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/widgets/user-profile.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/widgets/user-ratings.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/widgets/user-rating-form.php' );
require_once ( DMLY_PLUGIN_DIR . 'inc/buddypress.php' );