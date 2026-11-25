<?php
/**
 * Cerrajeros Arroyomolinos — tema hijo de Ollie.
 *
 * Este archivo solo carga los módulos de /inc. Cada módulo está documentado
 * en su propia cabecera:
 *
 *  - inc/business.php     Datos del negocio (NAP) en un único sitio.
 *  - inc/setup.php        Soportes, estilos, fuentes, estilos de bloque, categorías de patrones.
 *  - inc/branding.php     Logo y favicon de reserva mientras no se suban desde WordPress.
 *  - inc/breadcrumbs.php  Rastro de migas de pan + bloque dinámico "Migas de pan".
 *  - inc/faq-microdata.php Microdatos FAQPage/Question/Answer para el patrón FAQ.
 *  - inc/seo.php          Meta description, canonical y título (solo sin plugin SEO).
 *  - inc/schema.php       JSON-LD: Locksmith, WebSite, WebPage, Service, BreadcrumbList, BlogPosting.
 *  - inc/content.php      Textos por defecto (en castellano) de las secciones.
 *  - inc/patterns.php     Funciones que generan el marcado de bloques de los patrones.
 *  - inc/page-setup.php   Asistente opcional para crear las páginas con sus slugs.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

const VERSION = '1.0.0';

$ca_modules = array(
	'business',
	'setup',
	'branding',
	'breadcrumbs',
	'faq-microdata',
	'seo',
	'schema',
	'content',
	'patterns',
	'page-setup',
);

foreach ( $ca_modules as $ca_module ) {
	require_once __DIR__ . '/inc/' . $ca_module . '.php';
}
unset( $ca_modules, $ca_module );

/* -------------------------------------------------------------------------
 * <title> al principio del bloque de Rank Math o Yoast SEO
 * ---------------------------------------------------------------------- */

/*
 * En los temas de bloques, WordPress añade su <title>
 * (_block_template_render_title_tag) al elegir la plantilla, después de que
 * los plugins registren sus hooks. Con title-tag declarado, Rank Math y Yoast
 * imprimen su propio <title> al principio de su bloque (antes de la meta
 * description); Yoast intenta quitar el del núcleo, pero lo hace antes de que
 * se añada. Para no tener dos, se quita el del núcleo cuando hay uno de los
 * dos plugins; sin ellos, el del núcleo se imprime al principio del <head>.
 */
add_action(
	'after_setup_theme',
	static function () {
		add_theme_support( 'title-tag' );
	}
);
add_action(
	'wp_head',
	static function () {
		if ( false === has_action( 'wp_head', '_block_template_render_title_tag' ) ) {
			return;
		}
		remove_action( 'wp_head', '_block_template_render_title_tag', 1 );

		// Rank Math y Yoast imprimen su propio <title> al principio de su bloque.
		$rank_math = false !== has_action( 'rank_math/head', '_wp_render_title_tag' );
		$yoast     = current_theme_supports( 'title-tag' ) && has_action( 'wpseo_head' );
		if ( ! $rank_math && ! $yoast ) {
			// Sin ellos (o con plugins que solo filtran el texto, como The SEO
			// Framework), el <title> del núcleo se imprime aquí, antes que el resto.
			_block_template_render_title_tag();
		}
	},
	0
);
