<?php
/** Administration and query behavior. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
 * Applies archive ordering for interview list requests.
 *
 * @param WP_Query $query Query object.
 */
function yzrh_interview_archive_ordering( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'interview' ) ) {
		return;
	}

	$order = isset( $_GET['order'] ) ? strtoupper( sanitize_key( wp_unslash( $_GET['order'] ) ) ) : 'DESC'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! in_array( $order, array( 'ASC', 'DESC' ), true ) ) {
		$order = 'DESC';
	}

	$query->set( 'orderby', 'date' );
	$query->set( 'order', $order );
}
add_action( 'pre_get_posts', 'yzrh_interview_archive_ordering' );
