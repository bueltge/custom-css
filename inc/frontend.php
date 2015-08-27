<?php # -*- coding: utf-8 -*-

namespace InpsydeCustomCss\Frontend;
use InpsydeCustomCss\Core as Core;

// Prevent direct file access.
! defined( 'ABSPATH' ) && die();

get_stylesheet();
/**
 * Print stylesheet for reading source on front end, if is requested.
 *
 * @since 2015-08-26
 */
function get_stylesheet() {

	// Print the stylesheet only on right url parameters from stylesheet url request.
	if ( ! isset( $_GET[ 'inpsyde_custom_css' ] ) || 1 !== (int) $_GET[ 'inpsyde_custom_css' ] ) {
		return;
	}

	ob_start();
	header( 'Content-type: text/css' );
	$settings = get_option( 'inpsyde_custom_css_settings' );
	$source   = Core\filter_source( $settings[ 'source' ] );
	$source   = str_replace( '&gt;', '>', $source );
	$source   = '/* Request timestamp: ' . date( 'Y-m-d H:i:s' ) . ' */' . "\n" . $source;
	echo $source;
	die();
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_stylesheet', 99 );
/**
 * Register and enqueue stylesheet in wp.
 *
 * The url of the stylesheet is query var to the url, not an static string.
 * This write the css rules to the browser and list it in front end.
 *
 * @since 2015-08-26
 */
function add_stylesheet() {

	wp_register_style( 'inpsyde_custom_style', add_query_arg( array( 'inpsyde_custom_css' => 1 ), esc_url( home_url() ) ) );
	wp_enqueue_style( 'inpsyde_custom_style' );
}
