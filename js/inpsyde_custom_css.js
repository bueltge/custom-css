/**
 * Initialization of CodeMirror with custom options.
 *
 * @since 2015-08-26
 */
var cm = CodeMirror.fromTextArea( document.getElementById( 'inpsyde_custom_css_settings[source]' ), {
	lineNumbers: true,
	lineWrapping: true,
	showCursorWhenSelecting: true
} );

/* @see http://codemirror.net/doc/manual.html#keymaps */
cm.setOption( 'extraKeys', {
	Tab: function( e ) {
		var spaces = new Array( e.getOption( 'indentUnit' ) + 1 ).join( ' ' );
		e.replaceSelection( spaces );
	}
});

/* @see http://codemirror.net/doc/manual.html#setSize */
cm.setSize(
	'100%', '120%'
);