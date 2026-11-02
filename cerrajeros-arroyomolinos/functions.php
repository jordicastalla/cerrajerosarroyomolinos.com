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
