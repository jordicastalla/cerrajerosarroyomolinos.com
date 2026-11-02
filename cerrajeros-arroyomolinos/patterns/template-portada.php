<?php
/**
 * Title: Plantilla: Portada
 * Slug: cerrajeros-arroyomolinos/template-portada
 * Template Types: front-page
 * Description: Portada: H1 y teléfono en la primera pantalla y secciones variadas.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\hero_portada()
	. CA\problemas( CA\content_problemas_general() )
	. CA\servicios()
	. CA\como_trabajamos( 'is-style-ca-corte-derecha' )
	. CA\situaciones( CA\content_situaciones_general() )
	. CA\por_que_elegirnos()
	. CA\cta_telefono()
	. CA\zonas()
	. CA\faq( CA\content_faq_general() )
	. CA\post_content_block()
);
