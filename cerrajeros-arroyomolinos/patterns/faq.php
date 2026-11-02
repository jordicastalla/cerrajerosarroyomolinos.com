<?php
/**
 * Title: Preguntas frecuentes (FAQ con microdatos)
 * Slug: cerrajeros-arroyomolinos/faq
 * Categories: cerrajeros-arroyomolinos, text
 * Keywords: faq, preguntas, dudas, schema
 * Description: Preguntas y respuestas visibles con microdatos Schema.org FAQPage, Question y Answer.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\faq( CA\content_faq_general() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
