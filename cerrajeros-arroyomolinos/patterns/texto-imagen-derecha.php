<?php
/**
 * Title: Texto e imagen a la derecha
 * Slug: cerrajeros-arroyomolinos/texto-imagen-derecha
 * Categories: cerrajeros-arroyomolinos, media
 * Keywords: texto, imagen, columnas
 * Description: Texto a la izquierda e imagen a la derecha en marco de plano técnico.
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

echo CA\texto_imagen( CA\content_texto_bombin(), 'derecha' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques generado y escapado en inc/patterns.php.
