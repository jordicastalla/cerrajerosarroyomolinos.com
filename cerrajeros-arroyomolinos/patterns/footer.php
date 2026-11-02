<?php
/**
 * Title: Pie de página
 * Slug: cerrajeros-arroyomolinos/footer
 * Categories: footer
 * Keywords: pie, footer, dirección, teléfono
 * Description: Pie con logo, servicios, dirección, teléfono y la barra de llamada fija para móvil.
 * Block Types: core/template-part/footer
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

$ca_b = CA\business();

$ca_servicios = array();
foreach ( CA\services() as $ca_slug => $ca_service ) {
	$ca_servicios[] = CA\service_link( $ca_slug );
}

$ca_empresa = array(
	sprintf( '<a href="%s">Quiénes somos</a>', esc_url( CA\page_url( 'quienes-somos' ) ) ),
	sprintf( '<a href="%s">Blog</a>', esc_url( CA\blog_url() ) ),
	sprintf( '<a href="%s">Contacto</a>', esc_url( CA\page_url( 'contacto' ) ) ),
);

$ca_grid = CA\box(
	CA\box(
		CA\block( 'site-logo', array( 'width' => 200, 'shouldSyncIcon' => false, 'className' => 'ca-footer__logo' ) ) // phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing
		. CA\para( 'Cerrajería en Arroyomolinos (Madrid): cambio de cerraduras y bombines, cerrojos de seguridad y reparación de cierres metálicos.', 'ca-footer__lema' ),
		'ca-footer__marca'
	)
	. CA\box( CA\etiqueta( 'Servicios' ) . CA\items_list( $ca_servicios, 'ca-footer__lista' ), 'ca-footer__col' )
	. CA\box( CA\etiqueta( 'Empresa' ) . CA\items_list( $ca_empresa, 'ca-footer__lista' ), 'ca-footer__col' )
	. CA\box(
		CA\etiqueta( 'Contacto' )
		. CA\para( CA\phone_link(), 'ca-footer__telefono' )
		. CA\para( esc_html( $ca_b['street'] ) . '<br>' . esc_html( $ca_b['postal_code'] . ' ' . $ca_b['locality'] . ', ' . $ca_b['region'] ), 'ca-footer__direccion' )
		. CA\para( sprintf( '<a href="%s" target="_blank" rel="noreferrer noopener">Cómo llegar (Google Maps)</a>', esc_url( $ca_b['maps_url'] ) ), 'ca-footer__mapa' ),
		'ca-footer__col ca-footer__contacto'
	),
	'ca-footer__grid',
	array( 'align' => 'wide' )
);

$ca_legal = CA\box(
	CA\para( '© ' . esc_html( wp_date( 'Y' ) ) . ' ' . esc_html( $ca_b['name'] ) )
	. CA\para( esc_html( $ca_b['street'] . ' · ' . $ca_b['postal_code'] . ' ' . $ca_b['locality'] ) ),
	'ca-footer__legal',
	array( 'align' => 'wide' )
);

/*
 * Barra de llamada fija en móvil. Aparece al desplazarse (CSS con scroll-driven
 * animations donde el navegador lo admite; en el resto está siempre visible)
 * y reserva su propio espacio al final de la página para no tapar contenido.
 */
$ca_callbar = CA\group(
	CA\para( '¿Te ayudamos?', 'ca-callbar__texto' )
	. CA\call_button( 'is-style-ca-llamada', 'Llamar · ' . esc_html( $ca_b['phone_display'] ) ),
	array(
		'name'   => 'Barra de llamada (móvil)',
		'class'  => 'ca-callbar',
		'layout' => array(
			'type'           => 'flex',
			'flexWrap'       => 'nowrap',
			'justifyContent' => 'space-between',
		),
	)
);

echo CA\group( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	$ca_grid . $ca_legal . $ca_callbar,
	array(
		'name'  => 'Pie',
		'align' => 'full',
		'class' => 'ca-footer',
		'bg'    => 'primary-alt-accent',
		'text'  => 'base',
	)
);
