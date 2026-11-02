<?php
/**
 * Generadores de marcado de bloques para patrones y plantillas.
 *
 * Los archivos de /patterns llaman a estas funciones para que todas las
 * secciones compartan exactamente el mismo marcado (y por tanto el mismo CSS)
 * aunque cambie el contenido: la FAQ de la portada y la de un servicio son la
 * misma estructura con preguntas distintas.
 *
 * Todo lo que sale de aquí son bloques nativos de WordPress (Grupo, Título,
 * Párrafo, Lista, Botones, Imagen, Detalles…) que se editan con normalidad en
 * el editor. El aspecto lo ponen las clases "ca-*" y los estilos de bloque
 * "is-style-ca-*" definidos en style.css.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/* =========================================================================
 * Primitivas
 * ====================================================================== */

/**
 * Bloque serializado (comentarios de delimitación + HTML).
 *
 * @param string $name  Nombre del bloque.
 * @param array  $attrs Atributos.
 * @param string $html  HTML guardado (vacío para bloques dinámicos).
 */
function block( $name, array $attrs = array(), $html = '' ) {
	return get_comment_delimited_block_content( $name, $attrs, $html ) . "\n";
}

/**
 * Une clases ignorando las vacías.
 */
function classes( ...$list ) {
	return trim( preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_map( 'trim', $list ) ) ) ) );
}

/**
 * Grupo.
 *
 * @param string $inner Bloques interiores.
 * @param array  $o     tag, name, align, class, bg, text, layout.
 */
function group( $inner, array $o = array() ) {
	$tag   = $o['tag'] ?? 'div';
	$attrs = array();

	if ( 'div' !== $tag ) {
		$attrs['tagName'] = $tag;
	}
	if ( ! empty( $o['name'] ) ) {
		$attrs['metadata'] = array( 'name' => $o['name'] );
	}
	if ( ! empty( $o['align'] ) ) {
		$attrs['align'] = $o['align'];
	}
	if ( ! empty( $o['class'] ) ) {
		$attrs['className'] = $o['class'];
	}
	if ( ! empty( $o['bg'] ) ) {
		$attrs['backgroundColor'] = $o['bg'];
	}
	if ( ! empty( $o['text'] ) ) {
		$attrs['textColor'] = $o['text'];
	}
	$attrs['layout'] = $o['layout'] ?? array( 'type' => 'constrained' );

	$class = classes(
		'wp-block-group',
		! empty( $o['align'] ) ? 'align' . $o['align'] : '',
		$o['class'] ?? '',
		! empty( $o['text'] ) ? 'has-' . $o['text'] . '-color has-text-color' : '',
		! empty( $o['bg'] ) ? 'has-' . $o['bg'] . '-background-color has-background' : ''
	);

	return block( 'group', $attrs, sprintf( "<%1\$s class=\"%2\$s\">\n%3\$s</%1\$s>", $tag, esc_attr( $class ), $inner ) );
}

/**
 * Atajo: grupo con maquetación de flujo (sin ancho máximo propio).
 */
function box( $inner, $class, array $o = array() ) {
	return group( $inner, array_merge( array( 'class' => $class, 'layout' => array( 'type' => 'default' ) ), $o ) );
}

/**
 * Título.
 *
 * @param string $html  Contenido (HTML en línea permitido).
 * @param int    $level Nivel 1-6.
 * @param string $class Clases adicionales.
 * @param array  $o     align, size.
 */
function heading( $html, $level = 2, $class = '', array $o = array() ) {
	$attrs = array();
	if ( 2 !== $level ) {
		$attrs['level'] = $level;
	}
	if ( ! empty( $o['align'] ) ) {
		$attrs['textAlign'] = $o['align'];
	}
	if ( $class ) {
		$attrs['className'] = $class;
	}
	if ( ! empty( $o['size'] ) ) {
		$attrs['fontSize'] = $o['size'];
	}

	$cls = classes(
		'wp-block-heading',
		! empty( $o['align'] ) ? 'has-text-align-' . $o['align'] : '',
		$class,
		! empty( $o['size'] ) ? 'has-' . $o['size'] . '-font-size' : ''
	);

	return block( 'heading', $attrs, sprintf( '<h%1$d class="%2$s">%3$s</h%1$d>', $level, esc_attr( $cls ), $html ) );
}

/**
 * Párrafo.
 *
 * @param string $html  Contenido (HTML en línea permitido).
 * @param string $class Clases.
 * @param array  $o     align, size.
 */
function para( $html, $class = '', array $o = array() ) {
	$attrs = array();
	if ( ! empty( $o['align'] ) ) {
		$attrs['align'] = $o['align'];
	}
	if ( $class ) {
		$attrs['className'] = $class;
	}
	if ( ! empty( $o['size'] ) ) {
		$attrs['fontSize'] = $o['size'];
	}

	$cls = classes(
		! empty( $o['align'] ) ? 'has-text-align-' . $o['align'] : '',
		$class,
		! empty( $o['size'] ) ? 'has-' . $o['size'] . '-font-size' : ''
	);

	return block( 'paragraph', $attrs, ( $cls ? sprintf( '<p class="%s">', esc_attr( $cls ) ) : '<p>' ) . $html . '</p>' );
}

/**
 * Etiqueta técnica (párrafo pequeño en mayúsculas).
 */
function etiqueta( $text, $class = '', array $o = array() ) {
	return para( esc_html( $text ), classes( 'is-style-ca-etiqueta', $class ), $o );
}

/**
 * Botón.
 *
 * @param string $text  Texto (ya escapado).
 * @param string $url   URL.
 * @param string $class Clases (p. ej. is-style-ca-placa).
 * @param bool   $blank Abrir en pestaña nueva.
 */
function button( $text, $url, $class = '', $blank = false ) {
	$attrs = array();
	if ( $class ) {
		$attrs['className'] = $class;
	}
	$extra = '';
	if ( $blank ) {
		$attrs['linkTarget'] = '_blank';
		$attrs['rel']        = 'noreferrer noopener';
		$extra               = ' target="_blank" rel="noreferrer noopener"';
	}

	return block(
		'button',
		$attrs,
		sprintf(
			'<div class="%1$s"><a class="wp-block-button__link wp-element-button" href="%2$s"%3$s>%4$s</a></div>',
			esc_attr( classes( 'wp-block-button', $class ) ),
			esc_url( $url ),
			$extra,
			$text
		)
	);
}

/**
 * Grupo de botones.
 */
function buttons( $inner, $class = '' ) {
	$attrs = $class ? array( 'className' => $class ) : array();

	return block( 'buttons', $attrs, sprintf( "<div class=\"%s\">\n%s</div>", esc_attr( classes( 'wp-block-buttons', $class ) ), $inner ) );
}

/**
 * Botón de llamada con el teléfono del negocio.
 *
 * @param string $style is-style-ca-placa | is-style-ca-llamada.
 * @param string $text  Texto alternativo (por defecto, el número).
 */
function call_button( $style = 'is-style-ca-llamada', $text = '' ) {
	$text = $text ? $text : esc_html( business()['phone_display'] );

	return buttons( button( $text, phone_href(), $style ) );
}

/**
 * Lista.
 *
 * @param string[] $items   Contenido de cada elemento (HTML en línea).
 * @param string   $class   Clases.
 * @param bool     $ordered Lista numerada.
 */
function items_list( array $items, $class = '', $ordered = false ) {
	$attrs = array();
	if ( $ordered ) {
		$attrs['ordered'] = true;
	}
	if ( $class ) {
		$attrs['className'] = $class;
	}

	$li = '';
	foreach ( $items as $item ) {
		$li .= block( 'list-item', array(), '<li>' . $item . '</li>' );
	}

	$tag = $ordered ? 'ol' : 'ul';

	return block( 'list', $attrs, sprintf( "<%1\$s class=\"%2\$s\">\n%3\$s</%1\$s>", $tag, esc_attr( classes( 'wp-block-list', $class ) ), $li ) );
}

/**
 * Imagen del tema (ilustraciones SVG incluidas).
 *
 * @param string $path    Ruta dentro del tema.
 * @param string $alt     Texto alternativo.
 * @param string $class   Clases.
 * @param string $caption Pie de imagen.
 * @param string $ratio   Relación de aspecto (p. ej. 4/3).
 */
function image( $path, $alt, $class = '', $caption = '', $ratio = '4/3' ) {
	$attrs = array(
		'sizeSlug'        => 'full',
		'linkDestination' => 'none',
	);
	if ( $ratio ) {
		$attrs['aspectRatio'] = $ratio;
		$attrs['scale']       = 'contain';
	}
	if ( $class ) {
		$attrs['className'] = $class;
	}

	return block(
		'image',
		$attrs,
		sprintf(
			'<figure class="%1$s"><img src="%2$s" alt="%3$s"%4$s/>%5$s</figure>',
			esc_attr( classes( 'wp-block-image size-full', $class ) ),
			esc_url( asset( $path ) ),
			esc_attr( $alt ),
			$ratio ? sprintf( ' style="aspect-ratio:%s;object-fit:contain"', esc_attr( $ratio ) ) : '',
			$caption ? '<figcaption class="wp-element-caption">' . esc_html( $caption ) . '</figcaption>' : ''
		)
	);
}

/**
 * Detalles (desplegable nativo, sin JavaScript).
 */
function details( $summary, $inner, $class = '' ) {
	$attrs = $class ? array( 'className' => $class ) : array();

	return block( 'details', $attrs, sprintf( "<details class=\"%s\"><summary>%s</summary>\n%s</details>", esc_attr( classes( 'wp-block-details', $class ) ), $summary, $inner ) );
}

/**
 * Separador.
 */
function separator( $class = '' ) {
	$attrs = $class ? array( 'className' => $class ) : array();

	return block( 'separator', $attrs, sprintf( '<hr class="%s"/>', esc_attr( classes( 'wp-block-separator has-alpha-channel-opacity', $class ) ) ) );
}

/**
 * Bloques dinámicos usados en plantillas.
 */
function post_title( $level = 1, $class = '' ) {
	$attrs = array( 'level' => $level );
	if ( $class ) {
		$attrs['className'] = $class;
	}
	return block( 'post-title', $attrs );
}

function breadcrumbs_block() {
	return block( 'cerrajeros-arroyomolinos/breadcrumbs' );
}

function template_part( $slug, $tag ) {
	return block(
		'template-part',
		array(
			'slug'    => $slug,
			'tagName' => $tag,
		)
	);
}

/**
 * Contenido de la página editable desde el editor de páginas.
 */
function post_content_block() {
	return block(
		'post-content',
		array(
			'align'     => 'full',
			'className' => 'ca-contenido',
			'layout'    => array( 'type' => 'constrained' ),
		)
	);
}

/**
 * Esqueleto de plantilla: cabecera + <main> + pie.
 *
 * @param string $sections Secciones.
 */
function template_shell( $sections ) {
	return template_part( 'header', 'header' )
		. group(
			$sections,
			array(
				'tag'    => 'main',
				'name'   => 'Contenido',
				'class'  => 'ca-main',
				'layout' => array( 'type' => 'default' ),
			)
		)
		. template_part( 'footer', 'footer' );
}

/**
 * Sección a ancho completo con su contenedor ancho interior.
 *
 * @param string $inner Contenido del contenedor ancho.
 * @param array  $o     name, class, bg, text, inner_class.
 */
function section( $inner, array $o ) {
	return group(
		box( $inner, classes( 'ca-seccion__interior', $o['inner_class'] ?? '' ), array( 'align' => 'wide' ) ),
		array(
			'tag'   => 'section',
			'name'  => $o['name'] ?? '',
			'align' => 'full',
			'class' => classes( 'ca-seccion', $o['class'] ?? '' ),
			'bg'    => $o['bg'] ?? '',
			'text'  => $o['text'] ?? '',
		)
	);
}

/**
 * Cabecera estándar de sección: etiqueta + H2 + entradilla.
 */
function section_head( $etiqueta, $titulo, $intro = '', $class = '' ) {
	return box(
		etiqueta( $etiqueta )
		. heading( esc_html( $titulo ), 2, 'ca-titulo-seccion' )
		. ( $intro ? para( $intro, 'ca-entradilla' ) : '' ),
		classes( 'ca-cabecera', $class )
	);
}

/* =========================================================================
 * Secciones
 * ====================================================================== */

/**
 * Portada: H1 "Cerrajeros Arroyomolinos", teléfono e índice de servicios.
 * Sin imágenes ni animaciones: es lo primero que se pinta.
 */
function hero_portada() {
	$b     = business();
	$index = array();

	foreach ( services() as $slug => $service ) {
		$index[] = service_link( $slug );
	}
	$index[] = sprintf( '<a href="%s">Contacto y ubicación</a>', esc_url( page_url( 'contacto' ) ) );

	$main = box(
		para( esc_html( $b['street'] . ' · ' . $b['postal_code'] . ' ' . $b['locality'] ), 'is-style-ca-etiqueta ca-hero__direccion' )
		. heading( 'Cerrajeros Arroyomolinos', 1, 'ca-hero__titulo' )
		. para( 'Cambiamos cerraduras y bombines, instalamos cerrojos de seguridad y reparamos cierres metálicos en Arroyomolinos. Llámanos, cuéntanos qué ha pasado y te decimos cómo lo solucionamos.', 'ca-hero__lead' )
		. box( para( 'Llámanos', 'ca-cta__rotulo' ) . call_button( 'is-style-ca-placa' ), 'ca-hero__cta' ),
		'ca-hero__main'
	);

	$aside = box(
		heading( 'Qué hacemos', 2, 'ca-hero__indice-titulo' )
		. items_list( $index, 'ca-indice', true ),
		'ca-hero__indice'
	);

	return group(
		box( $main . $aside, 'ca-hero__grid', array( 'align' => 'wide' ) ),
		array(
			'tag'   => 'section',
			'name'  => 'Portada',
			'align' => 'full',
			'class' => 'ca-hero',
			'bg'    => 'primary-alt',
			'text'  => 'base',
		)
	);
}

/**
 * Introducción de página de servicio. El H1 es el título de la página.
 *
 * @param string $slug Slug del servicio.
 */
function intro_servicio( $slug ) {
	$c = content_intro_servicio( $slug );

	$main = box(
		breadcrumbs_block()
		. etiqueta( 'Servicio · Arroyomolinos' )
		. post_title( 1, 'ca-intro__titulo' )
		. para( esc_html( $c['lead'] ), 'ca-intro__lead' )
		. box( para( 'Llámanos', 'ca-cta__rotulo' ) . call_button( 'is-style-ca-placa' ), 'ca-hero__cta' ),
		'ca-intro__main'
	);

	$ficha = box(
		etiqueta( 'Qué incluye' )
		. items_list( array_map( 'esc_html', $c['incluye'] ), 'ca-ficha-lista' )
		. image( $c['imagen'], $c['alt'], 'is-style-ca-marco ca-intro__figura', '', '4/3' ),
		'ca-intro__ficha',
		array( 'tag' => 'aside' )
	);

	return group(
		box( $main . $ficha, 'ca-intro__grid', array( 'align' => 'wide' ) ),
		array(
			'tag'   => 'section',
			'name'  => 'Introducción del servicio',
			'align' => 'full',
			'class' => 'ca-intro ca-intro--servicio',
			'bg'    => 'primary-alt',
			'text'  => 'base',
		)
	);
}

/**
 * Introducción editorial de página (contacto, quiénes somos, blog…).
 *
 * @param array $o etiqueta, titulo (vacío = título de la página), titulo_bloque (marcado
 *                 de bloque para el H1, p. ej. el título de archivo), lead, extra, migas, nombre.
 */
function intro_pagina( array $o ) {
	if ( ! empty( $o['titulo_bloque'] ) ) {
		$title = $o['titulo_bloque'];
	} elseif ( ! empty( $o['titulo'] ) ) {
		$title = heading( esc_html( $o['titulo'] ), 1, 'ca-intro__titulo' );
	} else {
		$title = post_title( 1, 'ca-intro__titulo' );
	}

	$crumbs = ( $o['migas'] ?? true ) ? breadcrumbs_block() : '';
	$lead   = empty( $o['lead'] ) ? '' : para( $o['lead'], 'ca-intro__lead' );

	return group(
		box(
			$crumbs
			. box( etiqueta( $o['etiqueta'] ) . $title, 'ca-intro__main' )
			. box(
				$lead
				. ( $o['extra'] ?? '' )
				. para( sprintf( 'Llámanos: <a href="%s">%s</a>', esc_attr( phone_href() ), esc_html( business()['phone_display'] ) ), 'ca-intro__telefono' ),
				'ca-intro__aparte'
			),
			'ca-intro__grid',
			array( 'align' => 'wide' )
		),
		array(
			'tag'   => 'section',
			'name'  => $o['nombre'] ?? 'Introducción',
			'align' => 'full',
			'class' => 'ca-intro ca-intro--pagina',
			'bg'    => 'tertiary',
			'text'  => 'main',
		)
	);
}

/**
 * ¿Te suena alguno de estos problemas?
 *
 * @param array $c Contenido (ver content_problemas_*()).
 */
function problemas( array $c ) {
	$items = array();
	foreach ( $c['items'] as $item ) {
		$items[] = '<strong>' . esc_html( $item[0] ) . '</strong> ' . esc_html( $item[1] );
	}

	return section(
		box(
			section_head( $c['etiqueta'], $c['titulo'], esc_html( $c['intro'] ) )
			. para( $c['cierre'], 'ca-problemas__cierre' ),
			'ca-problemas__cabecera'
		)
		. items_list( $items, 'is-style-ca-numerada ca-problemas__lista', true ),
		array(
			'name'        => 'Problemas',
			'class'       => 'ca-problemas is-style-ca-corte',
			'bg'          => 'tertiary',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Servicios: índice escalonado (cada fila desplazada como los dientes de una llave).
 */
function servicios() {
	$rows = '';
	$n    = 0;

	foreach ( services() as $slug => $service ) {
		++$n;
		$rows .= box(
			para( sprintf( '%02d', $n ), 'ca-servicio__num' )
			. heading( service_link( $slug ), 3, 'ca-servicio__titulo' )
			. para( esc_html( $service['description'] ), 'ca-servicio__texto' ),
			'ca-servicio'
		);
	}

	return section(
		section_head( 'Servicios', 'Lo que hacemos por tu puerta', 'Cada servicio tiene su página con los detalles. Si no sabes cuál necesitas, llámanos al ' . phone_link() . ' y lo vemos juntos.' )
		. box( $rows, 'ca-servicios__lista' ),
		array(
			'name'  => 'Servicios',
			'class' => 'ca-servicios',
			'bg'    => 'base',
			'text'  => 'main',
		)
	);
}

/**
 * ¿Cómo trabajamos? Pasos con pitones que se alinean en la línea de corte.
 *
 * @param string $corte Estilo de transición (is-style-ca-corte | is-style-ca-corte-derecha).
 */
function como_trabajamos( $corte = 'is-style-ca-corte-derecha' ) {
	$c     = content_metodo();
	$steps = '';
	$n     = 0;

	foreach ( $c['pasos'] as $paso ) {
		++$n;
		$steps .= box(
			para( sprintf( 'Paso %02d', $n ), 'ca-paso__num' )
			. heading( esc_html( $paso[0] ), 3, 'ca-paso__titulo' )
			. para( esc_html( $paso[1] ), 'ca-paso__texto' ),
			'ca-paso'
		);
	}

	return section(
		section_head( $c['etiqueta'], $c['titulo'], esc_html( $c['intro'] ) )
		. box( $steps, 'ca-pasos' )
		. para( $c['cierre'], 'ca-metodo__cierre' ),
		array(
			'name'  => 'Cómo trabajamos',
			'class' => classes( 'ca-metodo', $corte ),
			'bg'    => 'primary-alt',
			'text'  => 'base',
		)
	);
}

/**
 * ¿Qué te ha pasado? Situaciones con desplegables nativos (sin JavaScript).
 *
 * @param array $c Contenido (ver content_situaciones_*()).
 */
function situaciones( array $c ) {
	$list = '';

	foreach ( $c['items'] as $item ) {
		$inner = para( esc_html( $item[1] ) );
		$inner .= $item[2]
			? para( service_link( $item[2], 'Ver: ' . services()[ $item[2] ]['title'] ), 'ca-situacion__enlace' )
			: para( 'Llámanos: ' . phone_link(), 'ca-situacion__enlace' );

		$list .= details( esc_html( $item[0] ), $inner, 'ca-situacion' );
	}

	return section(
		section_head( $c['etiqueta'], $c['titulo'], esc_html( $c['intro'] ) )
		. box( $list, 'ca-situaciones__lista' ),
		array(
			'name'        => 'Qué te ha pasado',
			'class'       => 'ca-situaciones',
			'bg'          => 'base',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Por qué elegirnos: manifiesto + ficha técnica.
 */
function por_que_elegirnos() {
	$c     = content_razones();
	$filas = '';

	foreach ( $c['filas'] as $fila ) {
		$filas .= box(
			para( esc_html( $fila[0] ), 'ca-ficha__clave' )
			. para( $fila[1], 'ca-ficha__valor' ),
			'ca-ficha__fila'
		);
	}

	return section(
		box(
			etiqueta( $c['etiqueta'] )
			. heading( esc_html( $c['titulo'] ), 2, 'ca-razones__manifiesto' )
			. para( esc_html( $c['intro'] ), 'ca-entradilla' ),
			'ca-razones__texto'
		)
		. box( $filas, 'ca-ficha' ),
		array(
			'name'        => 'Por qué elegirnos',
			'class'       => 'ca-razones',
			'bg'          => 'tertiary',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Ventajas: cintas rotuladas.
 *
 * @param array $c Contenido (ver content_ventajas_*()).
 */
function ventajas( array $c ) {
	$items = '';

	foreach ( $c['items'] as $item ) {
		$items .= box(
			heading( esc_html( $item[0] ), 3, 'is-style-ca-cinta' )
			. para( $item[1] ),
			'ca-ventaja'
		);
	}

	return section(
		section_head( $c['etiqueta'], $c['titulo'] )
		. box( $items, 'ca-ventajas__lista' ),
		array(
			'name'  => 'Ventajas',
			'class' => 'ca-ventajas is-style-ca-plano',
			'bg'    => 'tertiary',
			'text'  => 'main',
		)
	);
}

/**
 * Confianza: datos reales y verificables en una placa de acero.
 */
function confianza() {
	$c = content_confianza();
	$b = business();

	$texto = etiqueta( $c['etiqueta'] ) . heading( esc_html( $c['titulo'] ), 2, 'ca-titulo-seccion' );
	foreach ( $c['parrafos'] as $i => $parrafo ) {
		$texto .= para( esc_html( $parrafo ), 0 === $i ? 'ca-entradilla' : 'ca-confianza__consejo' );
	}

	$placa = group(
		para( esc_html( $b['name'] ), 'ca-placa__nombre' )
		. para( esc_html( $b['street'] ) . '<br>' . esc_html( $b['postal_code'] . ' ' . $b['locality'] . ', ' . $b['region'] ), 'ca-placa__direccion' )
		. para( phone_link(), 'ca-placa__telefono' )
		. buttons( button( 'Ver en Google Maps', $b['maps_url'], 'is-style-ca-contorno', true ) ),
		array(
			'class'  => 'is-style-ca-placa-acero ca-placa',
			'layout' => array( 'type' => 'default' ),
		)
	);

	return section(
		box( $texto, 'ca-confianza__texto' ) . $placa,
		array(
			'name'        => 'Confianza',
			'class'       => 'ca-confianza is-style-ca-corte',
			'bg'          => 'primary-alt-accent',
			'text'        => 'base',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Llamada a la acción grande: placa de cobre.
 *
 * @param array $o titulo, texto.
 */
function cta_telefono( array $o = array() ) {
	$b = business();

	$placa = group(
		box(
			etiqueta( 'Llámanos' )
			. heading( esc_html( $o['titulo'] ?? '¿Puerta que no abre, llave rota o cierre atascado?' ), 2, 'ca-cta-placa__titulo' )
			. para( esc_html( $o['texto'] ?? 'Cuéntanoslo por teléfono y te decimos cómo lo resolvemos.' ), 'ca-cta-placa__texto' ),
			'ca-cta-placa__texto-grupo'
		)
		. box(
			call_button( 'is-style-ca-llamada' )
			. para( esc_html( $b['name'] . ' · ' . $b['street'] . ', ' . $b['locality'] ), 'ca-cta-placa__pie' ),
			'ca-cta-placa__accion'
		),
		array(
			'align'  => 'wide',
			'class'  => 'ca-cta-placa',
			'bg'     => 'primary',
			'text'   => 'main-accent',
			'layout' => array( 'type' => 'default' ),
		)
	);

	return group(
		$placa,
		array(
			'tag'   => 'section',
			'name'  => 'Llamada a la acción',
			'align' => 'full',
			'class' => 'ca-seccion ca-cta',
			'bg'    => 'base',
		)
	);
}

/**
 * Llamada a la acción estrecha: franja con regla.
 *
 * @param string $texto Texto de la franja.
 */
function cta_franja( $texto = '¿Dudas con tu cerradura? Te lo explicamos por teléfono.' ) {
	return group(
		box(
			para( esc_html( $texto ), 'ca-franja__texto' )
			. call_button( 'is-style-ca-llamada' ),
			'ca-franja__interior',
			array( 'align' => 'wide' )
		),
		array(
			'tag'   => 'section',
			'name'  => 'Franja de llamada',
			'align' => 'full',
			'class' => 'ca-franja',
			'bg'    => 'primary-alt',
			'text'  => 'base',
		)
	);
}

/**
 * Zonas donde trabajamos. Solo Arroyomolinos: no se inventan otras zonas.
 */
function zonas() {
	$b = business();

	$sitios = array(
		'Pisos y chalets',
		'Portales y zonas comunes',
		'Locales comerciales',
		'Garajes y trasteros',
	);

	return section(
		box(
			para( esc_html( $b['postal_code'] ), 'ca-zonas__cp' )
			. etiqueta( $b['locality'] . ' · ' . $b['region'] ),
			'ca-zonas__marca'
		)
		. box(
			etiqueta( 'Zona de trabajo' )
			. heading( 'Zonas donde trabajamos', 2, 'ca-titulo-seccion' )
			. para( sprintf( 'Trabajamos en %1$s (%2$s). Nuestra base está en %3$s, dentro del propio municipio.', esc_html( $b['locality'] ), esc_html( $b['region'] ), esc_html( $b['street'] ) ), 'ca-entradilla' )
			. items_list( array_map( 'esc_html', $sitios ), 'ca-zonas__lista' )
			. para( '¿Estás fuera de Arroyomolinos? Llámanos al ' . phone_link() . ' y te decimos si podemos ayudarte.', 'ca-zonas__nota' )
			. buttons( button( 'Ver ubicación en Google Maps', $b['maps_url'], 'is-style-ca-contorno', true ) ),
			'ca-zonas__texto'
		),
		array(
			'name'        => 'Zonas donde trabajamos',
			'class'       => 'ca-zonas is-style-ca-plano',
			'bg'          => 'base',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Texto + imagen.
 *
 * @param array  $c    Contenido (ver content_texto_*()).
 * @param string $lado derecha (texto izq., imagen dcha.) | izquierda (imagen izq., texto dcha.).
 */
function texto_imagen( array $c, $lado = 'derecha' ) {
	$texto = etiqueta( $c['etiqueta'] ) . heading( esc_html( $c['titulo'] ), 2, 'ca-titulo-seccion' );
	foreach ( $c['parrafos'] as $i => $parrafo ) {
		$texto .= para( esc_html( $parrafo ), 0 === $i ? 'ca-entradilla' : '' );
	}

	$texto  = box( $texto, 'ca-texto-imagen__texto' );
	$figura = box( image( $c['imagen'], $c['alt'], 'is-style-ca-marco', $c['pie'] ), 'ca-texto-imagen__figura' );

	return section(
		'izquierda' === $lado ? $figura . $texto : $texto . $figura,
		array(
			'name'        => 'izquierda' === $lado ? 'Imagen a la izquierda y texto' : 'Texto e imagen a la derecha',
			'class'       => 'ca-texto-imagen ca-texto-imagen--' . $lado,
			'bg'          => 'izquierda' === $lado ? 'tertiary' : 'base',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Texto centrado de estilo editorial.
 *
 * @param array $c Contenido (ver content_centrado_*()).
 */
function texto_centrado( array $c ) {
	return group(
		etiqueta( $c['etiqueta'], '', array( 'align' => 'center' ) )
		. heading( esc_html( $c['titulo'] ), 2, 'ca-centrado__titulo', array( 'align' => 'center' ) )
		. para( esc_html( $c['lead'] ), 'ca-centrado__lead', array( 'align' => 'center' ) )
		. para( $c['texto'], 'ca-centrado__texto', array( 'align' => 'center' ) ),
		array(
			'tag'   => 'section',
			'name'  => 'Texto centrado',
			'align' => 'full',
			'class' => 'ca-seccion ca-centrado',
			'bg'    => 'base',
			'text'  => 'main',
		)
	);
}

/**
 * Preguntas frecuentes con microdatos FAQPage (ver inc/faq-microdata.php).
 *
 * @param array $c Contenido (ver content_faq_*()).
 */
function faq( array $c ) {
	$items = '';

	foreach ( $c['items'] as $item ) {
		$items .= box(
			heading( esc_html( $item[0] ), 3, 'ca-faq__pregunta' )
			. para( esc_html( $item[1] ), 'ca-faq__respuesta' ),
			'ca-faq__item'
		);
	}

	return section(
		section_head( $c['etiqueta'], $c['titulo'], $c['intro'], 'ca-preguntas__cabecera' )
		. box( $items, 'ca-preguntas__lista' ),
		array(
			'name'        => 'Preguntas frecuentes',
			'class'       => 'ca-faq ca-preguntas',
			'bg'          => 'tertiary',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}

/**
 * Enlaces a los otros servicios (enlazado interno).
 *
 * @param string $exclude Slug del servicio actual.
 */
function otros_servicios( $exclude = '' ) {
	$links = array();

	foreach ( services() as $slug => $service ) {
		if ( $slug !== $exclude ) {
			$links[] = service_link( $slug );
		}
	}
	$links[] = sprintf( '<a href="%s">Contacto y ubicación</a>', esc_url( page_url( 'contacto' ) ) );

	return section(
		etiqueta( 'Otros servicios' )
		. items_list( $links, 'ca-otros__lista' ),
		array(
			'name'  => 'Otros servicios',
			'class' => 'ca-otros',
			'bg'    => 'base',
			'text'  => 'main',
		)
	);
}

/**
 * Contacto: el teléfono como protagonista.
 */
function contacto_telefono() {
	$b = business();

	return section(
		etiqueta( 'Teléfono' )
		. heading( 'Llámanos', 2, 'ca-titulo-seccion' )
		. para( sprintf( '<a href="%s">%s</a>', esc_attr( phone_href() ), esc_html( $b['phone_display'] ) ), 'ca-telefono__numero' )
		. para( 'Es la forma más rápida de contarnos qué pasa. Si puedes, ten a mano el tipo de puerta y de cerradura: nos ayuda a orientarte desde la primera llamada.', 'ca-entradilla' ),
		array(
			'name'  => 'Teléfono',
			'class' => 'ca-telefono',
			'bg'    => 'base',
			'text'  => 'main',
		)
	);
}

/**
 * Contacto: dirección y qué contarnos al llamar.
 */
function ubicacion() {
	$b = business();

	return section(
		box(
			etiqueta( 'Dirección' )
			. heading( 'Dónde estamos', 2, 'ca-titulo-seccion' )
			. para( '<strong>' . esc_html( $b['name'] ) . '</strong><br>' . esc_html( $b['street'] ) . '<br>' . esc_html( $b['postal_code'] . ' ' . $b['locality'] . ', ' . $b['region'] ), 'ca-ubicacion__direccion' )
			. buttons( button( 'Abrir en Google Maps', $b['maps_url'], 'is-style-ca-contorno', true ) ),
			'ca-ubicacion__texto'
		)
		. box(
			etiqueta( 'Cuando llames' )
			. heading( 'Qué nos ayuda saber', 3, 'ca-ubicacion__subtitulo' )
			. items_list(
				array(
					'<strong>Qué ha pasado.</strong> La llave no gira, se ha partido, te has quedado fuera, el cierre no sube…',
					'<strong>Qué puerta es.</strong> Vivienda, portal, trastero, local o garaje.',
					'<strong>Dónde estás.</strong> La dirección en Arroyomolinos.',
				),
				'is-style-ca-numerada ca-ubicacion__lista',
				true
			),
			'ca-ubicacion__checklist'
		),
		array(
			'name'        => 'Ubicación',
			'class'       => 'ca-ubicacion is-style-ca-corte',
			'bg'          => 'tertiary',
			'text'        => 'main',
			'inner_class' => 'ca-dos-columnas',
		)
	);
}
