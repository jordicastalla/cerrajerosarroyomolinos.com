<?php
/**
 * Title: Plantilla: Resultados de búsqueda
 * Slug: cerrajeros-arroyomolinos/template-busqueda
 * Template Types: search
 * Description: Resultados de búsqueda.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

/**
 * Listado editorial de entradas (sin tarjetas): fecha, título, extracto y miniatura opcional.
 *
 * @param string $empty_text Texto si no hay resultados.
 */
$ca_listado = static function ( $empty_text ) {
	$item = CA\box(
		CA\block( 'post-date', array( 'className' => 'ca-articulo__fecha' ) )
		. CA\box(
			CA\block(
				'post-title',
				array(
					'level'     => 2,
					'isLink'    => true,
					'className' => 'ca-articulo__titulo',
				)
			)
			. CA\block(
				'post-excerpt',
				array(
					'excerptLength' => 26,
					'moreText'      => '',
					'className'     => 'ca-articulo__extracto',
				)
			),
			'ca-articulo__cuerpo'
		)
		. CA\block(
			'post-featured-image',
			array(
				'isLink'      => true,
				'aspectRatio' => '4/3',
				'sizeSlug'    => 'medium',
				'className'   => 'ca-articulo__imagen',
			)
		),
		'ca-articulo'
	);

	$query = CA\block(
		'query',
		array(
			'queryId'   => 10,
			'query'     => array(
				'perPage'  => 10,
				'pages'    => 0,
				'offset'   => 0,
				'postType' => 'post',
				'order'    => 'desc',
				'orderBy'  => 'date',
				'inherit'  => true,
			),
			'align'     => 'wide',
			'className' => 'ca-listado',
		),
		"<div class=\"wp-block-query alignwide ca-listado\">\n"
		. CA\block( 'post-template', array( 'className' => 'ca-listado__items' ), $item )
		. CA\block(
			'query-pagination',
			array(
				'paginationArrow' => 'arrow',
				'className'       => 'ca-paginacion',
				'layout'          => array(
					'type'           => 'flex',
					'justifyContent' => 'space-between',
				),
			),
			CA\block( 'query-pagination-previous', array( 'label' => 'Anteriores' ) )
			. CA\block( 'query-pagination-numbers' )
			. CA\block( 'query-pagination-next', array( 'label' => 'Siguientes' ) )
		)
		. CA\block( 'query-no-results', array(), CA\para( esc_html( $empty_text ), 'ca-listado__vacio' ) )
		. '</div>'
	);

	return CA\group(
		$query,
		array(
			'tag'   => 'section',
			'name'  => 'Listado de artículos',
			'align' => 'full',
			'class' => 'ca-seccion ca-blog',
			'bg'    => 'base',
			'text'  => 'main',
		)
	);
};

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_pagina(
		array(
			'etiqueta'      => 'Búsqueda',
			'titulo_bloque' => CA\block(
				'query-title',
				array(
					'type'      => 'search',
					'level'     => 1,
					'className' => 'ca-intro__titulo',
				)
			),
			'extra'         => CA\block(
				'search',
				array(
					'label'          => 'Buscar en la web',
					'showLabel'      => false,
					'placeholder'    => 'Buscar…',
					'buttonText'     => 'Buscar',
					'buttonPosition' => 'button-inside',
					'className'      => 'ca-buscador',
				)
			),
			'nombre'        => 'Introducción de la búsqueda',
		)
	)
	. $ca_listado( 'No hemos encontrado nada con esa búsqueda. Prueba con otras palabras o llámanos.' )
	. CA\cta_franja()
);
