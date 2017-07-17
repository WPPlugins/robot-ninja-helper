<?php
/**
 * Plugin name: Robot Ninja Helper
 * Plugin URI: https://github.com/Prospress/robot-ninja-helper
 * Description: Helper plugin for Robot Ninja users.
 * Author: Prospress Inc.
 * Author URI: https://prospress.com
 * Version: 1.0.0
 * GitHub Plugin URI: Prospress/robot-ninja-helper
 * GitHub Plugin URI: https://github.com/Prospress/robot-ninja-helper
 * Requires at least: 4.4
 * Text Domain: robot-ninja-helper
 *
 * Copyright 2017 Prospress, Inc.  (email : freedoms@prospress.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package		Robot Ninja Helper
 * @author 		Prospress
 * @since		1.0
 */
class Robot_Ninja_Helper {

	/**
	 * The single instance of the class.
	 */
	protected static $_instance = null;

	/**
	 * @var Robot Ninja Customer Email
	 */
	public $customer_email = 'robotninja@prospress.com';

	/**
	 * Main Robot Ninja Instance.
	 *
	 * @return Robot_Ninja_Helper
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Robot_Ninja_Helper Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialise the Robot Ninja Helper
	 *
	 * @since 1.0
	 */
	public function init() {
		if ( class_exists( 'WooCommerce' ) && version_compare( get_option( 'woocommerce_db_version' ), '3.0', '>=' ) ) {
			$this->load_includes();
		} else {
			add_action( 'admin_notices', array( $this, 'inactive_notice' ) );
		}
	}

	/**
	 * Load plugin textdomain
	 *
	 * @since 1.0
	 */
	public function load_plugin_textdomain() {
	    load_plugin_textdomain( 'robot-ninja-helper', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Load Robot Ninja Helper plugin files
	 *
	 * @since 1.0
	 */
	public function load_includes() {
		require_once( dirname( __FILE__ ) . '/includes/class-rn-api.php' );
		require_once( dirname( __FILE__ ) . '/includes/class-rn-cart.php' );
	}

	/**
	 * Show an admin notice when WooCommerce is not active or not atleast version WC2.6 is not installed.
	 *
	 * @since 1.0
	 */
	public function inactive_notice() {
		if ( current_user_can( 'activate_plugins' ) ) : ?>
			<div id="message" class="error">
				<p><?php esc_html_e( 'Robot Ninja will not be able to connect to your store properly. Make sure you have at least WordPress 4.4 and WooCommerce 4.6 installed. If you\'re stuck, read our documentation to properly set up your site or get in contact with us.', 'robot-ninja-helper' ); ?></p>
			</div>
		<?php endif;
	}
}

/**
 * For plugin-wide access to initial instance.
 */
function robot_ninja_helper() {
	return Robot_Ninja_Helper::instance();
}
robot_ninja_helper();
