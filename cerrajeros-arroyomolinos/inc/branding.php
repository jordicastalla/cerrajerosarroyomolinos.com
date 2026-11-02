<?php
/**
 * Logo y favicon de reserva.
 *
 * El tema incluye el logo y el icono facilitados por el cliente
 * (assets/images). Mientras no se suba un logo en Apariencia → Editor
 * (bloque "Logo del sitio") ni un icono del sitio, se usan estos archivos.
 * En cuanto se configuren desde WordPress, prevalecen los de WordPress.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Marcado del logo incluido en el tema.
 */
function fallback_logo_html() {
	return sprintf(
		'<a href="%1$s" class="custom-logo-link" rel="home"><img src="%2$s" srcset="%2$s 480w, %3$s 960w" sizes="(min-width: 782px) 240px, 180px" width="480" height="134" alt="%4$s" class="custom-logo ca-logo" decoding="async"></a>',
		esc_url( home_url( '/' ) ),
		esc_url( asset( 'assets/images/logo-cerrajeros-arroyomolinos-480.webp' ) ),
		esc_url( asset( 'assets/images/logo-cerrajeros-arroyomolinos-960.webp' ) ),
		esc_attr( business()['name'] . ' — inicio' )
	);
}

/**
 * Si no hay logo personalizado, el bloque "Logo del sitio" muestra el del tema.
 *
 * @param string $html Marcado generado por WordPress (vacío si no hay logo).
 */
function fallback_custom_logo( $html ) {
	if ( '' !== trim( (string) $html ) || has_custom_logo() ) {
		return $html;
	}

	return fallback_logo_html();
}
add_filter( 'get_custom_logo', __NAMESPACE__ . '\fallback_custom_logo' );

/**
 * URL absoluta del logo (para el JSON-LD).
 */
function logo_url() {
	$logo_id = (int) get_theme_mod( 'custom_logo' );

	if ( $logo_id ) {
		$src = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $src ) {
			return $src;
		}
	}

	return asset( 'assets/images/logo-cerrajeros-arroyomolinos-960.webp' );
}

/**
 * Favicon de reserva si no se ha configurado el icono del sitio.
 */
function fallback_favicon() {
	if ( has_site_icon() ) {
		return;
	}

	printf( '<link rel="icon" href="%s" sizes="32x32" type="image/png">' . "\n", esc_url( asset( 'assets/images/favicon-32.png' ) ) );
	printf( '<link rel="icon" href="%s" sizes="192x192" type="image/png">' . "\n", esc_url( asset( 'assets/images/favicon-192.png' ) ) );
	printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( asset( 'assets/images/apple-touch-icon.png' ) ) );
	echo '<meta name="theme-color" content="#0B2545">' . "\n";
}
add_action( 'wp_head', __NAMESPACE__ . '\fallback_favicon', 5 );
