<?php
/**
 * Asistente opcional de páginas.
 *
 * Las plantillas de servicio, contacto y "quiénes somos" se asignan solas por
 * slug (page-{slug}.html). Para que todo funcione desde el primer momento, un
 * aviso en el escritorio ofrece crear las páginas que falten y configurar la
 * portada y la página del blog. No hace nada sin que un administrador pulse el
 * botón, nunca borra ni modifica páginas existentes y solo cambia los ajustes
 * de lectura si la web todavía muestra las últimas entradas en la portada.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Páginas que necesita la web: slug => título.
 *
 * @return array<string,string>
 */
function required_pages() {
	$pages = array(
		'inicio' => 'Inicio',
		'blog'   => 'Blog',
	);

	foreach ( services() as $slug => $service ) {
		$pages[ $slug ] = $service['title'];
	}

	$pages['quienes-somos'] = 'Quiénes somos';
	$pages['contacto']      = 'Contacto';

	return $pages;
}

/**
 * Slugs de las páginas que todavía no existen.
 *
 * @return string[]
 */
function missing_pages() {
	$missing = array();

	foreach ( required_pages() as $slug => $title ) {
		if ( 'inicio' === $slug && get_option( 'page_on_front' ) ) {
			continue;
		}
		if ( 'blog' === $slug && get_option( 'page_for_posts' ) ) {
			continue;
		}
		if ( ! get_page_by_path( $slug ) ) {
			$missing[] = $slug;
		}
	}

	return $missing;
}

/**
 * Aviso en el escritorio.
 */
function page_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) || get_user_meta( get_current_user_id(), 'ca_page_setup_dismissed', true ) ) {
		return;
	}

	$missing = missing_pages();
	if ( ! $missing ) {
		return;
	}

	$pages  = required_pages();
	$titles = array_map(
		static function ( $slug ) use ( $pages ) {
			return $pages[ $slug ];
		},
		$missing
	);

	$create_url  = wp_nonce_url( admin_url( 'admin-post.php?action=ca_create_pages' ), 'ca_create_pages' );
	$dismiss_url = wp_nonce_url( admin_url( 'admin-post.php?action=ca_dismiss_pages' ), 'ca_dismiss_pages' );
	?>
	<div class="notice notice-info">
		<p><strong>Cerrajeros Arroyomolinos:</strong> faltan estas páginas para que se apliquen sus plantillas: <?php echo esc_html( implode( ', ', $titles ) ); ?>.</p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( $create_url ); ?>">Crear las páginas que faltan</a>
			<a class="button-link" href="<?php echo esc_url( $dismiss_url ); ?>" style="margin-left:1em">No volver a mostrar</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', __NAMESPACE__ . '\page_setup_notice' );

/**
 * Crea las páginas que faltan y configura portada y blog si procede.
 */
function create_pages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'No tienes permisos para hacer esto.' );
	}
	check_admin_referer( 'ca_create_pages' );

	$pages = required_pages();
	$ids   = array();

	foreach ( missing_pages() as $slug ) {
		$id = wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => $pages[ $slug ],
				'post_name'   => $slug,
			),
			true
		);

		if ( ! is_wp_error( $id ) ) {
			$ids[ $slug ] = $id;
		}
	}

	if ( 'posts' === get_option( 'show_on_front' ) && isset( $ids['inicio'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['inicio'] );
	}

	if ( ! get_option( 'page_for_posts' ) && isset( $ids['blog'] ) ) {
		update_option( 'page_for_posts', $ids['blog'] );
	}

	wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
	exit;
}
add_action( 'admin_post_ca_create_pages', __NAMESPACE__ . '\create_pages' );

/**
 * Oculta el aviso para el usuario actual.
 */
function dismiss_pages_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'No tienes permisos para hacer esto.' );
	}
	check_admin_referer( 'ca_dismiss_pages' );
	update_user_meta( get_current_user_id(), 'ca_page_setup_dismissed', 1 );
	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
	exit;
}
add_action( 'admin_post_ca_dismiss_pages', __NAMESPACE__ . '\dismiss_pages_notice' );
