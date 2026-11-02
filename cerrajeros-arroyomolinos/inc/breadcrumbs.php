<?php
/**
 * Migas de pan.
 *
 * WordPress no trae un bloque de migas de pan, así que registramos uno
 * dinámico muy pequeño (blocks/breadcrumbs). El rastro se calcula aquí y lo
 * reutiliza inc/schema.php para el BreadcrumbList en JSON-LD: lo que se ve y
 * lo que se declara a los buscadores es siempre lo mismo.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Registra el bloque "Migas de pan".
 */
function register_breadcrumbs_block() {
	register_block_type( get_theme_file_path( 'blocks/breadcrumbs' ) );
}
add_action( 'init', __NAMESPACE__ . '\register_breadcrumbs_block' );

/**
 * Rastro de la página actual.
 *
 * @return array<int,array{name:string,url:string}> Lista ordenada; el último elemento es la página actual.
 */
function breadcrumb_trail() {
	if ( is_front_page() ) {
		return array();
	}

	$trail = array(
		array(
			'name' => 'Inicio',
			'url'  => home_url( '/' ),
		),
	);

	$page_for_posts = (int) get_option( 'page_for_posts' );
	$blog_crumb     = $page_for_posts
		? array(
			'name' => get_the_title( $page_for_posts ),
			'url'  => get_permalink( $page_for_posts ),
		)
		: null;

	if ( is_home() ) {
		$trail[] = $blog_crumb ? $blog_crumb : array(
			'name' => 'Blog',
			'url'  => home_url( '/' ),
		);
	} elseif ( is_singular( 'page' ) ) {
		$page = get_queried_object();
		foreach ( array_reverse( get_post_ancestors( $page ) ) as $ancestor_id ) {
			$trail[] = array(
				'name' => get_the_title( $ancestor_id ),
				'url'  => get_permalink( $ancestor_id ),
			);
		}
		$trail[] = array(
			'name' => get_the_title( $page ),
			'url'  => get_permalink( $page ),
		);
	} elseif ( is_singular( 'post' ) ) {
		if ( $blog_crumb ) {
			$trail[] = $blog_crumb;
		}
		$categories = get_the_category( get_queried_object_id() );
		if ( $categories ) {
			$trail[] = array(
				'name' => $categories[0]->name,
				'url'  => get_category_link( $categories[0] ),
			);
		}
		$trail[] = array(
			'name' => get_the_title( get_queried_object_id() ),
			'url'  => get_permalink( get_queried_object_id() ),
		);
	} elseif ( is_singular() ) {
		$trail[] = array(
			'name' => get_the_title( get_queried_object_id() ),
			'url'  => get_permalink( get_queried_object_id() ),
		);
	} elseif ( is_category() || is_tag() || is_tax() ) {
		if ( $blog_crumb ) {
			$trail[] = $blog_crumb;
		}
		$term    = get_queried_object();
		$trail[] = array(
			'name' => single_term_title( '', false ),
			'url'  => get_term_link( $term ),
		);
	} elseif ( is_author() ) {
		if ( $blog_crumb ) {
			$trail[] = $blog_crumb;
		}
		$trail[] = array(
			'name' => get_the_author_meta( 'display_name', (int) get_query_var( 'author' ) ),
			'url'  => get_author_posts_url( (int) get_query_var( 'author' ) ),
		);
	} elseif ( is_date() ) {
		if ( $blog_crumb ) {
			$trail[] = $blog_crumb;
		}
		$trail[] = array(
			'name' => wp_strip_all_tags( get_the_archive_title() ),
			'url'  => '',
		);
	} elseif ( is_search() ) {
		$trail[] = array(
			'name' => sprintf( 'Búsqueda: %s', get_search_query() ),
			'url'  => '',
		);
	} elseif ( is_404() ) {
		$trail[] = array(
			'name' => 'Página no encontrada',
			'url'  => '',
		);
	}

	foreach ( $trail as &$crumb ) {
		$crumb['name'] = wp_strip_all_tags( (string) $crumb['name'] );
		$crumb['url']  = is_wp_error( $crumb['url'] ) ? '' : (string) $crumb['url'];
	}
	unset( $crumb );

	/**
	 * Permite ajustar el rastro de migas de pan.
	 *
	 * @param array $trail Elementos con claves name y url.
	 */
	return apply_filters( 'cerrajeros_arroyomolinos_breadcrumbs', $trail );
}

/**
 * Marcado HTML de las migas de pan.
 *
 * @param array  $trail   Rastro (ver breadcrumb_trail()).
 * @param string $wrapper Atributos del contenedor (get_block_wrapper_attributes()).
 */
function breadcrumbs_html( array $trail, $wrapper = 'class="ca-migas"' ) {
	if ( count( $trail ) < 2 ) {
		return '';
	}

	$items = '';
	$last  = count( $trail ) - 1;

	foreach ( $trail as $index => $crumb ) {
		if ( $index === $last || '' === $crumb['url'] ) {
			$items .= sprintf(
				'<li><span%s>%s</span></li>',
				$index === $last ? ' aria-current="page"' : '',
				esc_html( $crumb['name'] )
			);
		} else {
			$items .= sprintf(
				'<li><a href="%s">%s</a></li>',
				esc_url( $crumb['url'] ),
				esc_html( $crumb['name'] )
			);
		}
	}

	return sprintf( '<nav %s aria-label="Migas de pan"><ol>%s</ol></nav>', $wrapper, $items );
}
