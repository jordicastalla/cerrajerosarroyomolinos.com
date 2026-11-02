<?php
/**
 * Title: Texto centrado editorial
 * Slug: cerrajeros-arroyomolinos/texto-centrado
 * Categories: cerrajeros-arroyomolinos, text
 * Keywords: texto, centrado, editorial
 * Description: Bloque de texto centrado con plomada de cobre.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\texto_centrado( CA\content_centrado_general() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
