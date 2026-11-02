<?php
/**
 * Title: Plantilla: Instalación de cerrojos de seguridad
 * Slug: cerrajeros-arroyomolinos/template-instalacion-de-cerrojos-de-seguridad
 * Template Types: page
 * Description: Página de servicio: instalación de cerrojos de seguridad.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

$ca_slug = 'instalacion-de-cerrojos-de-seguridad';

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_servicio( $ca_slug )
	. CA\texto_centrado( CA\content_centrado_cerrojos() )
	. CA\texto_imagen( CA\content_texto_cerrojo(), 'izquierda' )
	. CA\ventajas( CA\content_ventajas_cerrojos() )
	. CA\post_content_block()
	. CA\cta_telefono(
		array(
			'titulo' => '¿Quieres reforzar tu puerta con un cerrojo?',
			'texto'  => 'Cuéntanos qué puerta es y te decimos qué opciones tiene.',
		)
	)
	. CA\faq( CA\content_faq_cerrojos() )
	. CA\otros_servicios( $ca_slug )
);
