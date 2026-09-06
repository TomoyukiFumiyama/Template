<?php
/** Safe document-head cleanup. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
