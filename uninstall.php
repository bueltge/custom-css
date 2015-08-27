<?php # -*- coding: utf-8 -*-
/**
 * Uninstall routines. This file is called automatically when the plugin
 * is deleted per user interface.
 *
 * @see http://codex.wordpress.org/Function_Reference/register_uninstall_hook
 */

namespace InpsydeCustomCss;

// If uninstall not called from WordPress, then exit.
// Prevent direct access.
defined( 'WP_UNINSTALL_PLUGIN' ) || die();

// Delete the custom option in database.
delete_option( 'inpsyde_custom_css_settings' );