<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: Custom CSS
 * Plugin URI:
 * Description: A simple, solid way to add custom CSS to your WordPress website.
 * Author:      Frank Bültge
 * Version:     2015-08-25
 * Author URI:  http://inpsyde.com
 * Text Domain: inpsyde_custom_css
 * Domain Path: /languages
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package WordPress
 * @author  Frank Bültge <frank@bueltge.de>
 */

namespace InpsydeCustomCss;

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

//add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );
init();
function init() {

	// Load only on the front end of the site.
	if ( ! is_admin() ) {
		require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/core.php' );
		require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/frontend.php' );
	}

	// Load only on admin area.
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/core.php' );
		require_once( __DIR__ . DIRECTORY_SEPARATOR . 'inc/admin.php' );
	}
}