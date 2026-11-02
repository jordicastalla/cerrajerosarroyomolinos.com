<?php
/**
 * Datos estructurados (JSON-LD, un único @graph por página).
 *
 * - Locksmith (tipo de LocalBusiness de Schema.org): nombre, teléfono,
 *   dirección, mapa y zona de servicio. Solo datos facilitados por el cliente:
 *   sin horarios, valoraciones, precios ni coordenadas.
 * - WebSite y WebPage (ContactPage / AboutPage / CollectionPage según la página).
 * - Service en las páginas de servicio.
 * - BreadcrumbList con el mismo rastro que se muestra en pantalla.
 * - BlogPosting en las entradas.
 *
 * Si hay un plugin SEO activo (ver seo_plugin_active()), se omiten WebSite,
 * WebPage, BreadcrumbList y BlogPosting, que esos plugins ya generan, y solo
 * se mantienen Locksmith y Service. Todo se puede desactivar con:
 *
 *   add_filter( 'cerrajeros_arroyomolinos_schema', '__return_false' );
 *
 * Las FAQ usan microdatos en el propio HTML (inc/faq-microdata.php), así que
 * aquí no se repite FAQPage.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Nodo del negocio.
 */
function schema_business_node() {
	$b    = business();
	$home = home_url( '/' );

	$catalog = array();
	foreach ( services() as $slug => $service ) {
		$catalog[] = array(
			'@type'       => 'Offer',
			'itemOffered' => array(
				'@type' => 'Service',
				'name'  => $service['service'],
				'url'   => page_url( $slug ),
			),
		);
	}

	return array(
		'@type'           => 'Locksmith',
		'@id'             => $home . '#cerrajeria',
		'name'            => $b['name'],
		'url'             => $home,
		'telephone'       => $b['phone'],
		'logo'            => logo_url(),
		'image'           => logo_url(),
		'address'         => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $b['street'],
			'postalCode'      => $b['postal_code'],
			'addressLocality' => $b['locality'],
			'addressRegion'   => $b['region'],
			'addressCountry'  => $b['country'],
		),
		'hasMap'          => $b['maps_url'],
		'areaServed'      => array(
			'@type' => 'City',
			'name'  => $b['area_served'],
		),
		'hasOfferCatalog' => array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Servicios de cerrajería',
			'itemListElement' => $catalog,
		),
	);
}

/**
 * Construye el @graph de la vista actual.
 *
 * @return array
 */
function schema_graph() {
	$home        = home_url( '/' );
	$business_id = $home . '#cerrajeria';
	$website_id  = $home . '#website';
	$full        = ! seo_plugin_active();
	$language    = get_bloginfo( 'language' );
	$graph       = array( schema_business_node() );

	if ( $full ) {
		$graph[] = array(
			'@type'      => 'WebSite',
			'@id'        => $website_id,
			'url'        => $home,
			'name'       => business()['name'],
			'publisher'  => array( '@id' => $business_id ),
			'inLanguage' => $language,
		);
	}

	$url = '';
	if ( is_singular() ) {
		$url = get_permalink( get_queried_object_id() );
	} elseif ( is_front_page() ) {
		$url = $home;
	} elseif ( is_home() && get_option( 'page_for_posts' ) ) {
		$url = get_permalink( (int) get_option( 'page_for_posts' ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$link = get_term_link( get_queried_object() );
		$url  = is_wp_error( $link ) ? '' : $link;
	}

	$webpage_id = $url ? $url . '#webpage' : '';
	$trail      = breadcrumb_trail();
	$slug       = is_singular( 'page' ) ? get_queried_object()->post_name : '';

	if ( $full && $url && ! is_404() && ! is_search() ) {
		$type = 'WebPage';
		if ( 'contacto' === $slug ) {
			$type = 'ContactPage';
		} elseif ( 'quienes-somos' === $slug ) {
			$type = 'AboutPage';
		} elseif ( is_home() || is_archive() ) {
			$type = 'CollectionPage';
		}

		$webpage = array(
			'@type'      => $type,
			'@id'        => $webpage_id,
			'url'        => $url,
			'name'       => wp_get_document_title(),
			'isPartOf'   => array( '@id' => $website_id ),
			'inLanguage' => $language,
		);

		$description = current_description();
		if ( $description ) {
			$webpage['description'] = $description;
		}

		if ( is_front_page() || in_array( $slug, array( 'contacto', 'quienes-somos' ), true ) ) {
			$webpage['about'] = array( '@id' => $business_id );
		}

		if ( count( $trail ) > 1 ) {
			$webpage['breadcrumb'] = array( '@id' => $url . '#breadcrumb' );
		}

		$graph[] = $webpage;
	}

	// Servicio en su página.
	$services = services();
	if ( $slug && isset( $services[ $slug ] ) ) {
		$service = array(
			'@type'       => 'Service',
			'@id'         => $url . '#servicio',
			'name'        => $services[ $slug ]['service'],
			'serviceType' => $services[ $slug ]['service'],
			'description' => $services[ $slug ]['description'],
			'url'         => $url,
			'provider'    => array( '@id' => $business_id ),
			'areaServed'  => array(
				'@type' => 'City',
				'name'  => business()['area_served'],
			),
		);
		if ( $full ) {
			$service['mainEntityOfPage'] = array( '@id' => $webpage_id );
		}
		$graph[] = $service;
	}

	if ( $full && $url && count( $trail ) > 1 ) {
		$items = array();
		foreach ( $trail as $position => $crumb ) {
			$item = array(
				'@type'    => 'ListItem',
				'position' => $position + 1,
				'name'     => $crumb['name'],
			);
			if ( '' !== $crumb['url'] ) {
				$item['item'] = $crumb['url'];
			}
			$items[] = $item;
		}

		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'@id'             => $url . '#breadcrumb',
			'itemListElement' => $items,
		);
	}

	if ( $full && is_singular( 'post' ) ) {
		$post      = get_queried_object();
		$posting   = array(
			'@type'            => 'BlogPosting',
			'@id'              => $url . '#articulo',
			'headline'         => wp_strip_all_tags( get_the_title( $post ) ),
			'datePublished'    => get_the_date( 'c', $post ),
			'dateModified'     => get_the_modified_date( 'c', $post ),
			'mainEntityOfPage' => array( '@id' => $webpage_id ),
			'isPartOf'         => array( '@id' => $webpage_id ),
			'publisher'        => array( '@id' => $business_id ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', (int) $post->post_author ),
				'url'   => get_author_posts_url( (int) $post->post_author ),
			),
			'inLanguage'       => $language,
		);
		$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : '';
		if ( $excerpt ) {
			$posting['description'] = wp_strip_all_tags( $excerpt );
		}
		if ( has_post_thumbnail( $post ) ) {
			$posting['image'] = get_the_post_thumbnail_url( $post, 'full' );
		}
		$graph[] = $posting;
	}

	/**
	 * Filtra el @graph completo antes de imprimirlo.
	 *
	 * @param array $graph Nodos Schema.org.
	 */
	return apply_filters( 'cerrajeros_arroyomolinos_schema_graph', $graph );
}

/**
 * Imprime el JSON-LD en el <head>.
 */
function print_schema() {
	if ( ! apply_filters( 'cerrajeros_arroyomolinos_schema', true ) ) {
		return;
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@graph'   => schema_graph(),
	);

	echo '<script type="application/ld+json">'
		. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP )
		. "</script>\n";
}
add_action( 'wp_head', __NAMESPACE__ . '\print_schema', 30 );
