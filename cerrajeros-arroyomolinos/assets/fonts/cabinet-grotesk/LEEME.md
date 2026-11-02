# Cabinet Grotesk (opcional)

El diseño usa **Cabinet Grotesk ExtraBold** para los títulos. No se incluye en el
repositorio porque se distribuye con la *ITF Free Font License* de Fontshare
(Indian Type Foundry) y no hemos podido confirmar que permita redistribuirla dentro
de un tema público.

## Cómo activarla

1. Descárgala desde <https://www.fontshare.com/fonts/cabinet-grotesk> y revisa su licencia.
2. Copia el archivo del peso ExtraBold en formato WOFF2 aquí, con este nombre exacto:

   `CabinetGrotesk-Extrabold.woff2`

3. Si la web usa caché de página u objeto, vacíala.

El tema lo detecta solo (`inc/setup.php` → `drop_missing_font_faces()`): declara
el `@font-face`, la precarga en el `<head>` y los títulos pasan a usarla.

Mientras el archivo no esté, los títulos usan **Cerrojo Display**
(`assets/fonts/cerrojo-display/`), una versión reducida de Mona Sans (licencia OFL)
y no se hace ninguna petición a un archivo inexistente.
