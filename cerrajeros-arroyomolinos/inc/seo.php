<?php
/**
 * SEO técnico básico: meta description, canonical y título.
 *
 * Solo actúa si NO hay un plugin SEO activo (Yoast, Rank Math, AIOSEO,
 * SEOPress, The SEO Framework o Slim SEO), para no duplicar etiquetas.
 * WordPress ya imprime el canonical de entradas y páginas; aquí se añade el
 * de la página del blog y de las categorías/etiquetas.
 *
 * Orden para la meta description:
 *   1. Extracto escrito a mano en la página o entrada.
 *   2. Texto por defecto de las páginas clave (ver default_descriptions()).
 *   3. Resumen automático del contenido.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * ¿Hay un plugin SEO que ya gestione títulos, descripciones y schema?
 */
function seo_plugin_active() {
	$active = defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
		|| defined( 'SEOPRESS_VERSION' )
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' )
		|| defined( 'SLIM_SEO_VER' );

	/**
	 * Fuerza la detección (true = el tema no imprime meta description ni schema general).
	 *
	 * @param bool $active Resultado de la detección automática.
	 */
	return (bool) apply_filters( 'cerrajeros_arroyomolinos_seo_plugin_active', $active );
}

/**
 * Descripciones por defecto de las páginas clave, por slug.
 *
 * @return array<string,string>
 */
function default_descriptions() {
	$phone = business()['phone_display'];

	return array(
		'__front'                              => "Cerrajeros en Arroyomolinos (Madrid): cambio de cerradura y bombín, cerrojos de seguridad y reparación de cierres metálicos. Llama al {$phone}.",
		'__blog'                               => 'Consejos sobre cerraduras, bombines, cerrojos y cierres metálicos para viviendas y locales de Arroyomolinos.',
		'cambio-de-cerradura-y-bombin'         => "Cambio de cerradura y bombín en Arroyomolinos: llave partida, bombín que no gira, llaves perdidas o intento de robo. Llama al {$phone}.",
		'instalacion-de-cerrojos-de-seguridad' => "Instalación de cerrojos de seguridad en Arroyomolinos para viviendas, portales, trasteros y locales. Te asesoramos por teléfono: {$phone}.",
		'reparacion-de-cierres-metalicos'      => "Reparación de cierres metálicos en Arroyomolinos: cerraduras, lamas, guías y mecanismo de persianas de locales y garajes. Llama al {$phone}.",
		'contacto'                             => "Contacta con Cerrajeros Arroyomolinos: llama al {$phone}. Estamos en C. de Cartagena, 8-66, 28939 Arroyomolinos (Madrid).",
		'quienes-somos'                        => 'Cerrajeros Arroyomolinos es una cerrajería de Arroyomolinos (Madrid), en C. de Cartagena, 8-66. Así trabajamos y por esto puedes confiar en nosotros.',
	);
}

/**
 * Meta description de la vista actual.
 */
function current_description() {
	$defaults    = default_descriptions();
	$description = '';

	if ( is_front_page() ) {
		$front_id    = (int) get_option( 'page_on_front' );
		$description = ( $front_id && has_excerpt( $front_id ) ) ? get_the_excerpt( $front_id ) : $defaults['__front'];
	} elseif ( is_home() ) {
		$blog_id     = (int) get_option( 'page_for_posts' );
		$description = ( $blog_id && has_excerpt( $blog_id ) ) ? get_the_excerpt( $blog_id ) : $defaults['__blog'];
	} elseif ( is_singular() ) {
		$post = get_queried_object();

		if ( has_excerpt( $post ) ) {
			$description = get_the_excerpt( $post );
		} elseif ( 'page' === $post->post_type && isset( $defaults[ $post->post_name ] ) ) {
			$description = $defaults[ $post->post_name ];
		} else {
			$description = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 28, '…' );
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();
		if ( '' === trim( wp_strip_all_tags( (string) $description ) ) ) {
			$description = sprintf( 'Artículos sobre %s en el blog de Cerrajeros Arroyomolinos.', single_term_title( '', false ) );
		}
	}

	$description = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $description ) ) );

	return apply_filters( 'cerrajeros_arroyomolinos_meta_description', $description );
}

/**
 * Imprime meta description y canonical (cuando WordPress no lo hace).
 */
function print_meta_tags() {
	if ( seo_plugin_active() ) {
		return;
	}

	$description = current_description();
	if ( '' !== $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}

	$canonical = '';
	$paged     = max( 1, (int) get_query_var( 'paged' ) );

	if ( is_home() && ! is_front_page() && get_option( 'page_for_posts' ) ) {
		$canonical = get_permalink( (int) get_option( 'page_for_posts' ) );
	} elseif ( is_category() || is_tag() ) {
		$link      = get_term_link( get_queried_object() );
		$canonical = is_wp_error( $link ) ? '' : $link;
	}

	if ( $canonical ) {
		if ( $paged > 1 ) {
			$canonical = user_trailingslashit( trailingslashit( $canonical ) . 'page/' . $paged );
		}
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\print_meta_tags', 2 );

/**
 * Título de la portada más descriptivo si no hay lema configurado.
 *
 * @param array $parts Partes del título.
 */
function title_parts( $parts ) {
	if ( seo_plugin_active() ) {
		return $parts;
	}

	if ( is_front_page() && empty( $parts['tagline'] ) ) {
		$parts['tagline'] = 'Cambio de bombín, cerrojos y cierres metálicos';
	}

	return $parts;
}
add_filter( 'document_title_parts', __NAMESPACE__ . '\title_parts' );

/**
 * Separador del título: "Página | Cerrajeros Arroyomolinos".
 */
function title_separator( $sep ) {
	return seo_plugin_active() ? $sep : '|';
}
add_filter( 'document_title_separator', __NAMESPACE__ . '\title_separator' );
