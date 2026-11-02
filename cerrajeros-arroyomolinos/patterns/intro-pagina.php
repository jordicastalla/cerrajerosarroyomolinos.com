<?php
/**
 * Title: Introducción: página editorial
 * Slug: cerrajeros-arroyomolinos/intro-pagina
 * Categories: cerrajeros-arroyomolinos-intro, banner
 * Keywords: hero, página, introducción
 * Description: Introducción sobria con migas de pan y el título de la página como H1.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\intro_pagina( array( 'etiqueta' => 'Cerrajeros Arroyomolinos', 'lead' => 'Escribe aquí una entradilla breve que explique de qué trata esta página.' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
