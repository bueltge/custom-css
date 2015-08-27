<?php # -*- coding: utf-8 -*-

namespace InpsydeCustomCss\Admin;
use InpsydeCustomCss\Core as Core;

// Prevent direct file access.
! defined( 'ABSPATH' ) && die();

add_action( 'admin_init', __NAMESPACE__ . '\textdomain' );
/**
 * Load a plugin's translated strings.
 *
 * @since 2015-08-25
 */
function textdomain() {

	load_plugin_textdomain( 'inpsyde_custom_css' );
}

add_action( 'admin_init', __NAMESPACE__ . '\register_settings' );
/**
 * Register a setting for css rules.
 *
 * @since 2015-08-25
 */
function register_settings() {

	register_setting( 'inpsyde_custom_css_settings_group', 'inpsyde_custom_css_settings' );
}

add_action( 'admin_menu', __NAMESPACE__ . '\add_admin_menu' );
/**
 *  Add sub menu page to the themes main menu.
 *
 * @since 2015-08-25
 */
function add_admin_menu() {

	$page_hook_suffix = add_theme_page(
		esc_html__( 'Custom Stylesheet', 'inpsyde_custom_css' ),
		esc_html__( 'Custom CSS', 'inpsyde_custom_css' ),
		'edit_theme_options',
		'inpsyde_custom_css',
		__NAMESPACE__ . '\get_admin_page'
	);

	add_action( 'admin_print_scripts-' . $page_hook_suffix, __NAMESPACE__ . '\add_highlight_js' );
}

/**
 * Render admin page to edit style.
 *
 * @since 2015-08-25
 */
function get_admin_page() {

	// Get custom settings from database.
	$settings = get_option( 'inpsyde_custom_css_settings' );
	isset( $settings[ 'source' ] )
	&& $source = Core\filter_source( $settings[ 'source' ] );

	// Delete the settings field in the database, if empty.
	if ( isset( $source ) && '' === $source ) {
		delete_option( 'inpsyde_custom_css_settings' );
	}

	// No custom source set a default string.
	! isset( $source )
	&& $source = esc_html__(
		'No custom rules currently.', 'inpsyde_custom_css'
	);
	?>
	<h1><?php esc_html_e( 'Custom Stylesheet', 'inpsyde_custom_css' ); ?></h1>
	<p><?php esc_html_e(
			'Add your custom stylesheet rules in the textarea below to add or overwrite css rules in the front end of your site.',
			'inpsyde_custom_css'
		); ?></p>

	<div class="wrap">
		<form name="inpsyde_custom_css-form" action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'inpsyde_custom_css_settings_group' ); ?>
			<label for=""><?php esc_attr_e( 'CSS Rules', 'inpsyde_custom_css' ); ?></label><br>
			<textarea id="inpsyde_custom_css_settings[source]"
				name="inpsyde_custom_css_settings[source]"><?php echo esc_html(
					$source
				); ?></textarea>
			<?php submit_button(
				esc_html__( 'Save Changes' ), 'primary', 'submit', TRUE
			); ?>
		</form>
	</div>
	<?php
}

add_action( 'admin_notices', __NAMESPACE__ . '\get_update_notice' );
/**
 * Get admin message to display save status.
 *
 * @since 2015-08-25
 */
function get_update_notice() {

	if ( ! isset( $_GET[ 'page' ] ) || 'inpsyde_custom_css' !== esc_attr( $_GET[ 'page' ] ) ) {
		return;
	}

	if ( ! isset( $_GET[ 'settings-updated' ] ) || 'true' !== esc_attr( $_GET[ 'settings-updated' ] ) ) {
		return;
	}
	?>
	<div class="updated">
		<p><?php esc_attr_e( 'Custom stylesheet updated successfully.', 'inpsyde_custom_css' ); ?></p>
	</div>
	<?php
}

function add_highlight_js() {

	wp_register_style(
		'codemirror',
		plugins_url( 'css/codemirror.css', str_replace( 'inc', '', __FILE__ ) ),
		'',
		'5.6.0',
		'screen'
	);
	wp_enqueue_style( 'codemirror' );

	wp_register_script(
		'codemirror',
		plugins_url( 'js/codemirror.js', str_replace( 'inc', '', __FILE__ ) ),
		array(),
		'5.6.0',
		TRUE
	);
	wp_register_script(
		'codemirror-css',
		plugins_url( 'js/css.js', str_replace( 'inc', '', __FILE__ ) ),
		array( 'codemirror' ),
		'5.6.0',
		TRUE
	);
	wp_register_script(
		'inpsyde_custom_css',
		plugins_url( 'js/inpsyde_custom_css.js', str_replace( 'inc', '', __FILE__ ) ),
		array( 'codemirror-css' ),
		'0.1',
		TRUE
	);
	wp_enqueue_script( 'inpsyde_custom_css' );
}