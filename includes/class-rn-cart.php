<?php
/**
 * Robot Ninja Cart Helper class
 *
 * @author 	Prospress
 * @since 	1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RN_Cart {

	/**
	 * Initialise Robot Ninja Helper Cart handler
	 *
	 * @since 1.0
	 */
	public static function init() {
		add_action( 'wp_login', __CLASS__ . '::maybe_empty_cart', 12, 2 );
	}

	/**
	 * Make sure we have an empty cart when the Robot Ninja customer logs in.
	 *
	 * @since 1.0
	 * @param string $user_login
	 * @param WP_User $user
	 */
	public static function maybe_empty_cart( $user_login, $user ) {
		global $current_user;

		if ( Robot_Ninja_Helper()->customer_email == $user->user_email ) {
			$old_current_user   = $current_user;
			$current_user       = $user;
			$wc_session_handler = new WC_Session_Handler();

			$wc_session_handler->destroy_session(); // empties the cart and clears cookies and sessions
			delete_user_meta( $user->ID, '_woocommerce_persistent_cart' ); // force the removal of persistent cart at login because the current user global is not set yet and get_current_user_id() returns 0

			$current_user = $old_current_user;
		}
	}
}
RN_Cart::init();
