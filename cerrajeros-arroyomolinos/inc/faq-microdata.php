<?php
/**
 * Microdatos Schema.org para el patrón FAQ (FAQPage → Question → Answer).
 *
 * Por qué se añaden al renderizar y no escritos en el patrón:
 * los bloques nativos (Grupo, Título, Párrafo) regeneran su HTML a partir de
 * sus atributos. Si el patrón llevara itemscope/itemprop escritos a mano, el
 * editor marcaría esos bloques como "contenido no válido" al abrirlos. Por eso
 * el patrón solo usa clases CSS y este filtro convierte esas clases en
 * microdatos en el HTML final que reciben visitantes y buscadores:
 *
 *   .ca-faq            → itemscope itemtype="https://schema.org/FAQPage"
 *   .ca-faq__item      → itemprop="mainEntity" itemscope itemtype="https://schema.org/Question"
 *   .ca-faq__pregunta  → itemprop="name"
 *   .ca-faq__respuesta → envuelto en itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer"
 *                        y el párrafo recibe itemprop="text"
 *
 * Las preguntas y respuestas son siempre visibles: no se oculta nada.
 * Cada respuesta es un párrafo (usa Mayús + Intro para saltos de línea).
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Añade los microdatos según la clase del bloque.
 *
 * @param string $block_content HTML del bloque.
 * @param array  $block         Bloque analizado.
 * @return string
 */
function faq_microdata( $block_content, $block ) {
	$class_name = $block['attrs']['className'] ?? '';

	if ( '' === $class_name || false === strpos( $class_name, 'ca-faq' ) || '' === trim( $block_content ) ) {
		return $block_content;
	}

	$classes = preg_split( '/\s+/', trim( $class_name ) );
	$tags    = new \WP_HTML_Tag_Processor( $block_content );

	if ( ! $tags->next_tag() ) {
		return $block_content;
	}

	if ( in_array( 'ca-faq', $classes, true ) ) {
		$tags->set_attribute( 'itemscope', true );
		$tags->set_attribute( 'itemtype', 'https://schema.org/FAQPage' );
		return $tags->get_updated_html();
	}

	if ( in_array( 'ca-faq__item', $classes, true ) ) {
		$tags->set_attribute( 'itemprop', 'mainEntity' );
		$tags->set_attribute( 'itemscope', true );
		$tags->set_attribute( 'itemtype', 'https://schema.org/Question' );
		return $tags->get_updated_html();
	}

	if ( in_array( 'ca-faq__pregunta', $classes, true ) ) {
		$tags->set_attribute( 'itemprop', 'name' );
		return $tags->get_updated_html();
	}

	if ( in_array( 'ca-faq__respuesta', $classes, true ) ) {
		$tags->set_attribute( 'itemprop', 'text' );
		return '<div class="ca-faq__answer" itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">'
			. $tags->get_updated_html()
			. '</div>';
	}

	return $block_content;
}
add_filter( 'render_block', __NAMESPACE__ . '\faq_microdata', 10, 2 );
