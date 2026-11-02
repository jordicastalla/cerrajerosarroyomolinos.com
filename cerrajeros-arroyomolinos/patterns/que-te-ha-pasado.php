<?php
/**
 * Title: ¿Qué te ha pasado?
 * Slug: cerrajeros-arroyomolinos/que-te-ha-pasado
 * Categories: cerrajeros-arroyomolinos
 * Keywords: situación, qué te ha pasado, urgencia
 * Description: Situaciones del cliente en desplegables nativos con enlace al servicio adecuado.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\situaciones( CA\content_situaciones_general() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
