<?php # -*- coding: utf-8 -*-

namespace InpsydeCustomCss\Core;

// Prevent direct file access.
! defined( 'ABSPATH' ) && die();

/**
 * Filter the source for foolish strings.
 *
 * @param string $source The custom css source code from settings.
 *
 * @return string
 */
function filter_source( $source ) {

	$source = wp_kses( $source, array( '\'', '\"' ) );
	// Remove blank lines from string.
	$source = preg_replace( "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $source );
	return $source;
}
