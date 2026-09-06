<?php
/** Performance extension point. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Allows projects to disable emoji assets without changing theme code. */
if ( apply_filters( 'yzrh_disable_emoji_assets', false ) ) {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
