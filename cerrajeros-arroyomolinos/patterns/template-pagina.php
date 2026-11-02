<?php
/**
 * Title: Plantilla: Página
 * Slug: cerrajeros-arroyomolinos/template-pagina
 * Template Types: page
 * Description: Página genérica con introducción, contenido y franja de llamada.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_pagina(
		array(
			'etiqueta' => 'Cerrajeros Arroyomolinos',
			'nombre'   => 'Introducción de página',
		)
	)
	. CA\group(
		CA\post_content_block(),
		array(
			'tag'   => 'div',
			'name'  => 'Contenido de la página',
			'align' => 'full',
			'class' => 'ca-seccion ca-pagina',
		)
	)
	. CA\cta_franja()
);
