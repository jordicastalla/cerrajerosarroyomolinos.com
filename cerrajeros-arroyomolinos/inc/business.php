<?php
/**
 * Datos del negocio y de los servicios.
 *
 * Única fuente de verdad para nombre, dirección y teléfono (NAP). Los patrones,
 * el JSON-LD y el pie leen de aquí, así que un cambio de teléfono se hace en un
 * solo sitio. Solo contiene datos facilitados por el cliente: no hay horarios,
 * valoraciones ni coordenadas porque no se han proporcionado.
 *
 * Se puede modificar desde un plugin con el filtro `cerrajeros_arroyomolinos_business`.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Datos de contacto del negocio.
 *
 * @return array<string,string>
 */
function business() {
	static $data = null;

	if ( null === $data ) {
		$data = apply_filters(
			'cerrajeros_arroyomolinos_business',
			array(
				'name'           => 'Cerrajeros Arroyomolinos',
				'phone'          => '+34919931713',
				'phone_display'  => '+34 919 931 713',
				'street'         => 'C. de Cartagena, 8-66',
				'postal_code'    => '28939',
				'locality'       => 'Arroyomolinos',
				'region'         => 'Madrid',
				'country'        => 'ES',
				'country_name'   => 'España',
				'maps_url'       => 'https://maps.app.goo.gl/jLn37cxXrJHYf4xF9',
				'area_served'    => 'Arroyomolinos',
			)
		);
	}

	return $data;
}

/**
 * Enlace tel: listo para usar en atributos href.
 */
function phone_href() {
	return 'tel:' . business()['phone'];
}

/**
 * Servicios con página propia. La clave es el slug de la página y de su plantilla.
 *
 * @return array<string,array<string,string>>
 */
function services() {
	return array(
		'cambio-de-cerradura-y-bombin'         => array(
			'title'       => 'Cambio de cerradura y bombín',
			'short'       => 'Cambio de bombín',
			'description' => 'Cambiamos el bombín o la cerradura completa cuando se rompe, cuando pierdes las llaves o cuando quieres una puerta más segura.',
			'service'     => 'Cambio de cerradura y bombín',
		),
		'instalacion-de-cerrojos-de-seguridad' => array(
			'title'       => 'Instalación de cerrojos de seguridad',
			'short'       => 'Cerrojos de seguridad',
			'description' => 'Añadimos un segundo punto de cierre a puertas de vivienda, portales, trasteros y locales.',
			'service'     => 'Instalación de cerrojos de seguridad',
		),
		'reparacion-de-cierres-metalicos'      => array(
			'title'       => 'Reparación de cierres metálicos',
			'short'       => 'Cierres metálicos',
			'description' => 'Arreglamos cierres y persianas metálicas de locales y garajes: cerradura, lamas, guías y mecanismo.',
			'service'     => 'Reparación de cierres metálicos',
		),
	);
}

/**
 * URL de una página por su slug, con alternativa si la página aún no existe.
 *
 * @param string $slug Slug de la página (sin barras).
 */
function page_url( $slug ) {
	$page = get_page_by_path( $slug );

	if ( $page instanceof \WP_Post && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}

	return home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * URL de la página de entradas (blog), si está configurada.
 */
function blog_url() {
	$page_for_posts = (int) get_option( 'page_for_posts' );

	if ( $page_for_posts ) {
		return get_permalink( $page_for_posts );
	}

	return page_url( 'blog' );
}

/**
 * URL de un recurso del tema hijo.
 *
 * @param string $path Ruta relativa dentro del tema.
 */
function asset( $path ) {
	return get_theme_file_uri( ltrim( $path, '/' ) );
}
