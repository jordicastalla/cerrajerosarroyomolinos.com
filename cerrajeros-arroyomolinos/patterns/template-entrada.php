<?php
/**
 * Title: Plantilla: Entrada del blog
 * Slug: cerrajeros-arroyomolinos/template-entrada
 * Template Types: single
 * Description: Artículo del blog con migas de pan, H1, contenido, llamada y más artículos.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

$ca_cabecera = CA\group(
	CA\box(
		CA\breadcrumbs_block()
		. CA\block(
			'post-terms',
			array(
				'term'      => 'category',
				'className' => 'ca-entrada__categoria',
			)
		)
		. CA\post_title( 1, 'ca-entrada__titulo' )
		. CA\group(
			CA\block( 'post-date', array( 'className' => 'ca-entrada__fecha' ) )
			. CA\block(
				'post-author-name',
				array(
					'className' => 'ca-entrada__autor',
				)
			),
			array(
				'class'  => 'ca-entrada__meta',
				'layout' => array(
					'type'     => 'flex',
					'flexWrap' => 'wrap',
				),
			)
		),
		'ca-entrada__cabecera-interior'
	),
	array(
		'tag'   => 'header',
		'name'  => 'Cabecera del artículo',
		'align' => 'full',
		'class' => 'ca-entrada__cabecera',
		'bg'    => 'tertiary',
		'text'  => 'main',
	)
);

$ca_cuerpo = CA\group(
	CA\block(
		'post-featured-image',
		array(
			'aspectRatio' => '16/9',
			'align'       => 'wide',
			'className'   => 'ca-entrada__imagen',
		)
	)
	. CA\block(
		'post-content',
		array(
			'className' => 'ca-entrada__contenido ca-contenido',
			'layout'    => array( 'type' => 'constrained' ),
		)
	)
	. CA\block(
		'post-terms',
		array(
			'term'      => 'post_tag',
			'className' => 'ca-entrada__etiquetas',
		)
	),
	array(
		'tag'   => 'article',
		'name'  => 'Artículo',
		'align' => 'full',
		'class' => 'ca-seccion ca-entrada',
	)
);

$ca_relacionado = CA\box(
	CA\block( 'post-date', array( 'className' => 'ca-articulo__fecha' ) )
	. CA\block(
		'post-title',
		array(
			'level'     => 3,
			'isLink'    => true,
			'className' => 'ca-articulo__titulo',
		)
	),
	'ca-relacionado'
);

$ca_mas = CA\section(
	CA\etiqueta( 'Más artículos' )
	. CA\block(
		'query',
		array(
			'queryId' => 99,
			'query'   => array(
				'perPage'  => 3,
				'pages'    => 1,
				'offset'   => 0,
				'postType' => 'post',
				'order'    => 'desc',
				'orderBy'  => 'date',
				'inherit'  => false,
			),
			'className' => 'ca-relacionados__query',
		),
		"<div class=\"wp-block-query ca-relacionados__query\">\n"
		. CA\block(
			'post-template',
			array(
				'className' => 'ca-relacionados__items',
				'layout'    => array(
					'type'        => 'grid',
					'columnCount' => 3,
				),
			),
			$ca_relacionado
		)
		. '</div>'
	),
	array(
		'name'  => 'Más artículos',
		'class' => 'ca-relacionados',
		'bg'    => 'base',
		'text'  => 'main',
	)
);

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	$ca_cabecera
	. $ca_cuerpo
	. CA\cta_franja( '¿Te ha surgido una duda con tu cerradura? Llámanos y te lo explicamos.' )
	. $ca_mas
);
