/**
 * Editor del bloque "Migas de pan": sin compilación, usa los globales de WordPress.
 * En el editor se muestra la vista previa renderizada en el servidor.
 */
( function ( blocks, element, blockEditor, ServerSideRender ) {
	var el = element.createElement;

	blocks.registerBlockType( 'cerrajeros-arroyomolinos/breadcrumbs', {
		edit: function ( props ) {
			return el(
				'div',
				blockEditor.useBlockProps(),
				el( ServerSideRender, {
					block: 'cerrajeros-arroyomolinos/breadcrumbs',
					attributes: props.attributes,
					skipBlockSupportAttributes: true,
				} )
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.serverSideRender );
