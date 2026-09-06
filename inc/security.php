<?php
/**
 * Theme-wide security hardening helpers.
 *
 * @package yzrh
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Security hardening utility class.
 */
class YZRH_Security_Hardening {
	/**
	 * Bootstrap the hardening measures.
	 */
	public static function init() {
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'the_generator', '__return_empty_string' );
		add_filter( 'style_loader_src', array( __CLASS__, 'remove_asset_version' ), 10, 2 );
		add_filter( 'script_loader_src', array( __CLASS__, 'remove_asset_version' ), 10, 2 );

		add_filter( 'xmlrpc_enabled', '__return_false' );
		add_filter( 'xmlrpc_methods', '__return_empty_array' );
		add_filter( 'wp_headers', array( __CLASS__, 'remove_x_pingback_header' ) );
		add_filter( 'pings_open', '__return_false' );
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'comments_array', '__return_empty_array', 10, 2 );

		add_action( 'send_headers', array( __CLASS__, 'send_security_headers' ) );
		add_action( 'init', array( __CLASS__, 'disable_comment_support' ), 100 );
		add_action( 'admin_init', array( __CLASS__, 'disable_comment_support' ) );
		add_action( 'admin_menu', array( __CLASS__, 'hide_comment_admin_menu' ), 100 );
		add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'hide_comment_admin_bar' ) );
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'hide_comment_dashboard_widget' ) );
	}

	/** Remove comment support from every registered public content type. */
	public static function disable_comment_support() {
		foreach ( get_post_types() as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
			}
			if ( post_type_supports( $post_type, 'trackbacks' ) ) {
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}

	/** Remove the Comments screen from the administration menu. */
	public static function hide_comment_admin_menu() {
		remove_menu_page( 'edit-comments.php' );
	}

	/** Remove the Comments shortcut from the administration toolbar. */
	public static function hide_comment_admin_bar() {
		global $wp_admin_bar;
		if ( $wp_admin_bar ) {
			$wp_admin_bar->remove_menu( 'comments' );
		}
	}

	/** Remove the recent comments dashboard widget. */
	public static function hide_comment_dashboard_widget() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	/**
	 * Strip the version query arg from enqueued assets.
	 *
	 * @param string $src    Asset URL.
	 * @param string $handle Asset handle.
	 * @return string
	 */
	public static function remove_asset_version( $src, $handle ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( false === strpos( $src, 'ver=' ) ) {
			return $src;
		}

		$parts = explode( '?', $src, 2 );

		if ( 2 !== count( $parts ) ) {
			return $src;
		}

		$base   = $parts[0];
		$params = wp_parse_args( $parts[1] );

		if ( isset( $params['ver'] ) ) {
			unset( $params['ver'] );
		}

		$query = http_build_query( $params );

		return $query ? $base . '?' . $query : $base;
	}

	/**
	 * Remove the X-Pingback header from responses.
	 *
	 * @param array $headers Response headers.
	 * @return array
	 */
	public static function remove_x_pingback_header( $headers ) {
		if ( isset( $headers['X-Pingback'] ) ) {
			unset( $headers['X-Pingback'] );
		}

		return $headers;
	}

	/**
	 * Send a set of recommended security headers with each response.
	 *
	 * Allows filtering via {@see 'yzrh_security_headers'}.
	 */
	public static function send_security_headers() {
		if ( headers_sent() ) {
			return;
		}

		$headers = apply_filters( 'yzrh_security_headers', self::get_default_security_headers() );

		if ( empty( $headers ) || ! is_array( $headers ) ) {
			return;
		}

		foreach ( $headers as $name => $value ) {
			if ( empty( $name ) || '' === trim( $value ) ) {
				continue;
			}

			header( sprintf( '%s: %s', $name, $value ), true );
		}
	}


	/**
	 * Default security header map used by {@see self::send_security_headers()}.
	 *
	 * @return array<string, string>
	 */
	protected static function get_default_security_headers() {
		return array(
			'Strict-Transport-Security'         => 'max-age=63072000; includeSubDomains; preload',
			'X-Frame-Options'                   => 'SAMEORIGIN',
			'X-Content-Type-Options'            => 'nosniff',
			'X-Permitted-Cross-Domain-Policies' => 'none',
			'Referrer-Policy'                   => 'strict-origin-when-cross-origin',
			'Permissions-Policy'                => 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()',
		);
	}
}

YZRH_Security_Hardening::init();
