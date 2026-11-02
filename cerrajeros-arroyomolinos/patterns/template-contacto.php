<?php
/**
 * Title: Plantilla: Contacto
 * Slug: cerrajeros-arroyomolinos/template-contacto
 * Template Types: page
 * Description: Página de contacto: teléfono, dirección y zona de trabajo. Sin formularios.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_pagina(
		array(
			'etiqueta' => 'Contacto',
			'lead'     => 'La forma más rápida de hablar con nosotros es por teléfono. Cuéntanos qué te pasa y te decimos cómo lo resolvemos.',
			'nombre'   => 'Introducción de contacto',
		)
	)
	. CA\contacto_telefono()
	. CA\ubicacion()
	. CA\zonas()
	. CA\post_content_block()
	. CA\faq( CA\content_faq_contacto() )
);
