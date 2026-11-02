<?php
/**
 * Title: Introducción: portada
 * Slug: cerrajeros-arroyomolinos/hero-portada
 * Categories: cerrajeros-arroyomolinos-intro, banner
 * Keywords: hero, portada, h1, teléfono
 * Description: Primera pantalla con el H1, la dirección, el teléfono y el índice de servicios. Solo para la portada.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\hero_portada(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
