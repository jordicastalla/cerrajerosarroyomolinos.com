<?php
/**
 * Title: ¿Te suena alguno de estos problemas?
 * Slug: cerrajeros-arroyomolinos/problemas
 * Categories: cerrajeros-arroyomolinos
 * Keywords: problemas, diagnóstico, averías
 * Description: Lista numerada de problemas con transición en forma de corte de llave.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\problemas( CA\content_problemas_general() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
