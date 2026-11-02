<?php
/**
 * Configuración general: soportes, hojas de estilo, fuentes, estilos de bloque
 * y categorías de patrones.
 *
 * Ollie (tema padre) ya encola su propio style.css y sus estilos por bloque; aquí
 * solo añadimos lo del tema hijo.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Soportes del tema.
 */
function theme_setup() {
	// Extracto en páginas: se usa como meta description si no hay plugin SEO.
	add_post_type_support( 'page', 'excerpt' );

	// Logo personalizado (el tema trae uno de reserva, ver inc/branding.php).
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 134,
			'width'       => 480,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup', 11 );

/**
 * Hoja de estilos del tema hijo (el padre la encola Ollie).
 */
function enqueue_styles() {
	wp_enqueue_style(
		'cerrajeros-arroyomolinos',
		get_stylesheet_uri(),
		array( 'ollie' ),
		VERSION
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_styles', 20 );

/**
 * Cabinet Grotesk es opcional: su licencia (ITF Free Font License) no permite
 * que la incluyamos aquí sin confirmarlo, así que se sube a mano a
 * assets/fonts/cabinet-grotesk/. Si el archivo no está, quitamos su @font-face
 * para no provocar una petición 404 y los títulos usan "Cerrojo Display"
 * (derivada de Mona Sans, OFL), que va justo detrás en la pila de fuentes.
 *
 * @param \WP_Theme_JSON_Data $theme_json Datos del theme.json del tema.
 * @return \WP_Theme_JSON_Data
 */
function drop_missing_font_faces( $theme_json ) {
	$data     = $theme_json->get_data();
	$families = $data['settings']['typography']['fontFamilies'] ?? null;

	// Tras fusionar padre e hijo, las fuentes del tema van bajo la clave "theme".
	if ( isset( $families['theme'] ) ) {
		$families = $families['theme'];
	}

	if ( ! is_array( $families ) ) {
		return $theme_json;
	}

	$changed = false;

	foreach ( $families as $i => $family ) {
		if ( empty( $family['fontFace'] ) ) {
			continue;
		}

		foreach ( $family['fontFace'] as $j => $face ) {
			$src = (array) ( $face['src'] ?? array() );
			$src = reset( $src );

			if ( is_string( $src ) && str_starts_with( $src, 'file:./' ) ) {
				$relative = substr( $src, strlen( 'file:./' ) );

				if ( ! file_exists( get_theme_file_path( $relative ) ) ) {
					unset( $families[ $i ]['fontFace'][ $j ] );
					$changed = true;
				}
			}
		}

		$families[ $i ]['fontFace'] = array_values( $families[ $i ]['fontFace'] );
	}

	if ( ! $changed ) {
		return $theme_json;
	}

	return $theme_json->update_with(
		array(
			'version'  => 3,
			'settings' => array(
				'typography' => array(
					'fontFamilies' => array_values( $families ),
				),
			),
		)
	);
}
add_filter( 'wp_theme_json_data_theme', __NAMESPACE__ . '\drop_missing_font_faces' );

/**
 * Precarga de las dos fuentes que pinta la primera pantalla (H1 y texto).
 * Mejora el LCP porque el navegador no espera a descubrirlas en el CSS.
 */
function preload_fonts() {
	$fonts = array();

	$heading = file_exists( get_theme_file_path( 'assets/fonts/cabinet-grotesk/CabinetGrotesk-Extrabold.woff2' ) )
		? 'assets/fonts/cabinet-grotesk/CabinetGrotesk-Extrabold.woff2'
		: 'assets/fonts/cerrojo-display/CerrojoDisplay-ExtraBold.woff2';

	$fonts[] = $heading;
	$fonts[] = 'assets/fonts/rethink-sans/RethinkSans-Variable.woff2';

	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( $font ) )
		);
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\preload_fonts', 1 );

/**
 * El script de emojis de WordPress añade peso en todas las páginas y no aporta
 * nada a esta web. Lo quitamos para mejorar el rendimiento.
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', __NAMESPACE__ . '\disable_emojis' );

/**
 * Estilos de bloque propios. El CSS de todos ellos está en style.css.
 */
function register_block_styles() {
	$styles = array(
		'core/button'    => array(
			'ca-llamada' => 'Llamada (icono de teléfono)',
			'ca-placa'   => 'Placa de cobre (teléfono destacado)',
			'ca-contorno' => 'Contorno',
		),
		'core/group'     => array(
			'ca-corte'         => 'Corte de llave (borde superior)',
			'ca-corte-derecha' => 'Corte de llave (a la derecha)',
			'ca-plano'         => 'Plano técnico (cuadrícula)',
			'ca-placa-acero'   => 'Placa de acero',
		),
		'core/paragraph' => array(
			'ca-etiqueta' => 'Etiqueta técnica',
		),
		'core/heading'   => array(
			'ca-cinta' => 'Cinta rotulada',
		),
		'core/list'      => array(
			'ca-numerada' => 'Lista numerada técnica',
		),
		'core/image'     => array(
			'ca-marco' => 'Marco de plano técnico',
		),
		'core/separator' => array(
			'ca-regla'    => 'Regla (marcas de medida)',
			'ca-remaches' => 'Remaches',
		),
	);

	foreach ( $styles as $block => $variations ) {
		foreach ( $variations as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block_styles' );

/**
 * Categorías de patrones.
 */
function register_pattern_categories() {
	register_block_pattern_category(
		'cerrajeros-arroyomolinos',
		array(
			'label'       => 'Cerrajeros Arroyomolinos',
			'description' => 'Secciones de la web de Cerrajeros Arroyomolinos.',
		)
	);
	register_block_pattern_category(
		'cerrajeros-arroyomolinos-intro',
		array(
			'label'       => 'Cerrajeros · Introducciones',
			'description' => 'Cabeceras e introducciones de página.',
		)
	);
	register_block_pattern_category(
		'cerrajeros-arroyomolinos-llamada',
		array(
			'label'       => 'Cerrajeros · Llamadas a la acción',
			'description' => 'Bloques para que el visitante llame por teléfono.',
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_pattern_categories', 9 );

/**
 * Bloque "Más artículos" de la entrada: excluye la entrada que se está leyendo.
 * Se identifica por su queryId (99) en templates/single.html.
 *
 * @param array     $query Argumentos de WP_Query.
 * @param \WP_Block $block Bloque Plantilla de entrada.
 * @return array
 */
function exclude_current_post( $query, $block ) {
	if ( is_singular() && isset( $block->context['queryId'] ) && 99 === (int) $block->context['queryId'] ) {
		$query['post__not_in'] = array_merge( (array) ( $query['post__not_in'] ?? array() ), array( get_queried_object_id() ) );
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', __NAMESPACE__ . '\\exclude_current_post', 10, 2 );

/**
 * Las ilustraciones SVG del tema no son adjuntos de la biblioteca de medios,
 * así que WordPress no les pone width/height. Se los añadimos (680×510, su
 * viewBox) para que el navegador reserve el hueco y pueda cargarlas en diferido.
 *
 * Las que no están en la introducción (primera pantalla) se cargan en diferido.
 *
 * @param string $content HTML del bloque Imagen.
 * @param array  $block   Bloque analizado.
 * @return string
 */
function size_theme_illustrations( $content, $block = array() ) {
	if ( false === strpos( $content, '/assets/images/ilustracion-' ) ) {
		return $content;
	}

	$tags = new \WP_HTML_Tag_Processor( $content );

	while ( $tags->next_tag( 'img' ) ) {
		$src = (string) $tags->get_attribute( 'src' );

		if ( false !== strpos( $src, '/assets/images/ilustracion-' ) && null === $tags->get_attribute( 'width' ) ) {
			$tags->set_attribute( 'width', '680' );
			$tags->set_attribute( 'height', '510' );
			$tags->set_attribute( 'decoding', 'async' );

			if ( false === strpos( (string) ( $block['attrs']['className'] ?? '' ), 'ca-intro__figura' ) && null === $tags->get_attribute( 'loading' ) ) {
				$tags->set_attribute( 'loading', 'lazy' );
			}
		}
	}

	return $tags->get_updated_html();
}
add_filter( 'render_block_core/image', __NAMESPACE__ . '\size_theme_illustrations', 10, 2 );
