<?php
/**
 * Title: Plantilla: Quiénes somos
 * Slug: cerrajeros-arroyomolinos/template-quienes-somos
 * Template Types: page
 * Description: Página "Quiénes somos": presentación, confianza y forma de trabajar.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_pagina(
		array(
			'etiqueta' => 'Cerrajería en Arroyomolinos',
			'lead'     => 'Somos Cerrajeros Arroyomolinos, una cerrajería con base en C. de Cartagena, 8-66. Cambiamos cerraduras y bombines, instalamos cerrojos de seguridad y reparamos cierres metálicos.',
			'nombre'   => 'Introducción de quiénes somos',
		)
	)
	. CA\texto_centrado( CA\content_centrado_quienes() )
	. CA\confianza()
	. CA\por_que_elegirnos()
	. CA\como_trabajamos( 'is-style-ca-corte' )
	. CA\ventajas( CA\content_ventajas_general() )
	. CA\post_content_block()
	. CA\cta_telefono()
);
