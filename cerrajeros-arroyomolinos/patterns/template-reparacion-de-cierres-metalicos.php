<?php
/**
 * Title: Plantilla: Reparación de cierres metálicos
 * Slug: cerrajeros-arroyomolinos/template-reparacion-de-cierres-metalicos
 * Template Types: page
 * Description: Página de servicio: reparación de cierres metálicos.
 * Viewport Width: 1400
 * Inserter: false
 */

use CerrajerosArroyomolinos as CA;

$ca_slug = 'reparacion-de-cierres-metalicos';

echo CA\template_shell( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\intro_servicio( $ca_slug )
	. CA\situaciones( CA\content_situaciones_cierres() )
	. CA\texto_imagen( CA\content_texto_cierre(), 'derecha' )
	. CA\como_trabajamos( 'is-style-ca-corte' )
	. CA\post_content_block()
	. CA\faq( CA\content_faq_cierres() )
	. CA\cta_franja( '¿El cierre de tu local no sube o no baja? Llámanos antes de forzarlo.' )
	. CA\otros_servicios( $ca_slug )
);
