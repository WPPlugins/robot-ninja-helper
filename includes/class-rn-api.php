<?php
/**
 * Robot Ninja API Class
 *
 * @author 	Prospress
 * @since 	1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RN_API {

	/**
	 * Init Robot Ninja API Class
	 *
	 * @since 1.0
	 */
	public static function init() {
		// Register our custom routes
		add_action( 'rest_api_init', __CLASS__ . '::register_custom_routes' );

		// Register additional fields to be added to the GET system status endpoint
		add_action( 'rest_api_init', __CLASS__ . '::register_system_status_field', 15 );
	}

	/**
	 * Register Custom Routes
	 *
	 * @since 1.0
	 */
	public static function register_custom_routes() {
		// A simple GET route we can check quickly to determine if the plugin is activated as part of service discovery/onboarding
		register_rest_route( 'rn/helper', '/status', array(
			'methods'  => \WP_REST_Server::READABLE,
			'callback' => __CLASS__ . '::return_plugin_status',
		) );
	}

	/**
	 * Register the additional fields for the WC System Status endpoint.
	 *
	 * @since 1.0
	 */
	public static function register_system_status_field() {
		register_rest_field( 'system_status',
			'robot_ninja_data',
			array(
				'get_callback'    => __CLASS__ . '::add_robot_ninja_data',
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}

	/**
	 * Add additional field to the system status endpoint response for robot ninja
	 *
	 * @since 1.0
	 * @param mixed $response
	 * @param string $field_name
	 * @param WP_Rest_Request
	 * @return Object
	 */
	public static function add_robot_ninja_data( $response, $field_name, $request ) {
		// add some products for robot ninja to test
		$info = new stdClass();
		$info->guest_checkout_enabled = ( 'yes' == get_option( 'woocommerce_enable_guest_checkout' ) ) ? true : false;
		$info->products = $info->pages = array();

		// get two of the most popular products with a price above 0.
		$products_ids = wc_get_products(
			array(
				'status'     => 'publish',
				'meta_key'   => 'total_sales',
				'orderby'    => 'meta_value_num',
				'limit'      => 2,
				'return'     => 'ids',
				'meta_query' => array(
					array(
						'key'       => '_visibility',
						'value'     => array( 'catalog', 'visible' ),
						'compare'   => 'IN',
					),
					array(
						'key'       => '_regular_price',
						'value'     => 0,
						'compare'   => '>',
					),
					array(
						'key'       => '_stock_status',
						'value'     => 'instock',
						'compare'   => '=',
					),
				),
			)
		);

		foreach ( $products_ids as $product_id ) {
			$info->products[ $product_id ] = get_permalink( $product_id );
		}

		$i = 0;
		foreach ( array( 'shop', 'cart', 'checkout', 'my_account' ) as $page_key ) {
			$page_info                = $response['pages'][ $i ];
			$info->pages[ $page_key ] = $response['environment']->site_url . '/?p=' . $page_info['page_id'];
			$i++;
		}

		return $info;
	}

	/**
	 * Simple callback returning that the plugin is activated
	 *
	 * @since  1.0
	 * @param  WP_Rest_Request $request
	 * @return WP_REST_Response
	 */
	public static function return_plugin_status( $request ) {
		$data = array(
			'status' => 'activated',
		);
		return new WP_REST_Response( $data, 200 );
	}
}
RN_API::init();
