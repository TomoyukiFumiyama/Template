<?php
/** Image configuration and extension points. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function yzrh_image_sizes() {
	add_image_size( 'yzrh-card', 720, 480, true );
}
add_action( 'after_setup_theme', 'yzrh_image_sizes' );
