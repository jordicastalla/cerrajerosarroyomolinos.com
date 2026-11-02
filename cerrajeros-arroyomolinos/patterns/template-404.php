<?php
/**
 * Title: Plantilla: 404
 * Slug: cerrajeros-arroyomolinos/template-404
 * Template Types: 404
 * Description: Página no encontrada: "Esta puerta no abre".
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

$ca_links = array();
foreach ( CA\services() as $ca_slug => $ca_service ) {
	$ca_links[] = CA\service_link( $ca_slug );
}
$ca_links[] = sprintf( '<a href="%s">Contacto</a>', esc_url( CA\page_url( 'contacto' ) ) );
$ca_links[] = sprintf( '<a href="%s">Volver al inicio</a>', esc_url( home_url( '/' ) ) );

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\group(
		CA\box(
			CA\box(
				CA\etiqueta( 'Error 404' )
				. CA\heading( 'Esta puerta no abre', 1, 'ca-error__titulo' )
				. CA\para( 'La página que buscas no existe o ha cambiado de dirección. Prueba con alguno de estos enlaces o llámanos y te ayudamos.', 'ca-hero__lead' )
				. CA\box( CA\para( 'Llámanos', 'ca-cta__rotulo' ) . CA\call_button( 'is-style-ca-placa' ), 'ca-hero__cta' ),
				'ca-hero__main'
			)
			. CA\box(
				CA\heading( 'Quizá buscabas', 2, 'ca-hero__indice-titulo' )
				. CA\items_list( $ca_links, 'ca-indice', true ),
				'ca-hero__indice'
			),
			'ca-hero__grid',
			array( 'align' => 'wide' )
		),
		array(
			'tag'   => 'section',
			'name'  => 'Página no encontrada',
			'align' => 'full',
			'class' => 'ca-hero ca-error',
			'bg'    => 'primary-alt',
			'text'  => 'base',
		)
	)
);
