<?php
/**
 * Title: Plantilla: Cambio de cerradura y bombín
 * Slug: cerrajeros-arroyomolinos/template-cambio-de-cerradura-y-bombin
 * Template Types: page
 * Description: Página de servicio: cambio de cerradura y bombín.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

$ca_slug = 'cambio-de-cerradura-y-bombin';

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_servicio( $ca_slug )
	. CA\problemas( CA\content_problemas_bombin() )
	. CA\texto_imagen( CA\content_texto_bombin(), 'derecha' )
	. CA\post_content_block()
	. CA\cta_franja( '¿No sabes si cambiar el bombín o la cerradura entera? Te lo explicamos por teléfono.' )
	. CA\faq( CA\content_faq_bombin() )
	. CA\otros_servicios( $ca_slug )
);
