<?php
/** Shared theme settings and helpers. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function yzrh_core_get_default_settings() {
	$defaults = array(
		'display_show_sidebar_post' => true,
		'display_show_sidebar_archive' => true,
		'display_show_author_box' => true,
		'seo_jsonld_enabled' => true,
		'seo_jsonld_website' => true,
		'seo_jsonld_organization' => true,
		'seo_jsonld_breadcrumbs' => true,
		'seo_jsonld_blogposting' => true,
		'seo_jsonld_service' => true,
		'seo_jsonld_blog' => true,
		'seo_jsonld_blog_itemlist' => true,
		'seo_jsonld_author' => true,
		'seo_jsonld_interview_collection' => true,
	);
	return apply_filters( 'yzrh_core_default_settings', $defaults );
}

function yzrh_core_get_settings() {
	$defaults = yzrh_core_get_default_settings();
	$stored = get_option( 'yzrh_settings', array() );
	$stored = is_array( $stored ) ? array_intersect_key( $stored, $defaults ) : array();
	return wp_parse_args( $stored, $defaults );
}

function yzrh_get_setting( $key, $default = null ) {
	$settings = yzrh_core_get_settings();
	return array_key_exists( $key, $settings ) ? $settings[ $key ] : $default;
}
