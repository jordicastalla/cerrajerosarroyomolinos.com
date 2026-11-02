<?php
/**
 * Render del bloque "Migas de pan".
 *
 * En el editor (petición REST) no hay consulta real, así que se muestra un
 * ejemplo para poder maquetar.
 *
 * @package cerrajeros-arroyomolinos
 *
 * @var array    $attributes Atributos del bloque.
 * @var WP_Block $block      Instancia del bloque.
 */

defined( 'ABSPATH' ) || exit;

$ca_is_preview = defined( 'REST_REQUEST' ) && REST_REQUEST;

$ca_trail = $ca_is_preview
	? array(
		array(
			'name' => 'Inicio',
			'url'  => home_url( '/' ),
		),
		array(
			'name' => 'Página actual',
			'url'  => '',
		),
	)
	: \CerrajerosArroyomolinos\breadcrumb_trail();

echo \CerrajerosArroyomolinos\breadcrumbs_html( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en breadcrumbs_html().
	$ca_trail,
	get_block_wrapper_attributes( array( 'class' => 'ca-migas' ) )
);
