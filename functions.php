<?php
/**
 * Theme bootstrap.
 *
 * Functional code lives in /inc so that each concern can be disabled or
 * extended independently.
 *
 * @package yzrh
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$yzrh_modules = array(
	'helpers.php',
	'setup.php',
	'assets.php',
	'security.php',
	'performance.php',
	'seo.php',
	'admin.php',
	'images.php',
	'cleanup.php',
	'customizer.php',
);

foreach ( $yzrh_modules as $yzrh_module ) {
	require_once get_template_directory() . '/inc/' . $yzrh_module;
}

unset( $yzrh_module, $yzrh_modules );
