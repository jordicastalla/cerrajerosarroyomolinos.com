# Cerrajeros Arroyomolinos — tema hijo de Ollie

Tema hijo (Full Site Editing) para **Cerrajeros Arroyomolinos**
C. de Cartagena, 8-66 · 28939 Arroyomolinos (Madrid) · **+34 919 931 713**

Objetivo único de conversión: que el visitante **llame**. No hay formularios,
WhatsApp, chats ni precios.

---

## Instalación

1. Instala y deja disponible el tema padre **Ollie** (probado con Ollie 1.6.5). No hace falta activarlo ni modificarlo.
2. Sube la carpeta `cerrajeros-arroyomolinos/` a `wp-content/themes/` y activa **Cerrajeros Arroyomolinos**.
3. En el escritorio aparecerá un aviso: **«Crear las páginas que faltan»**. Crea (solo si no existen) estas páginas con su slug y, si la portada aún muestra las últimas entradas, configura *Inicio* como portada y *Blog* como página de entradas:

   | Página | Slug | Plantilla que se aplica sola |
   |---|---|---|
   | Inicio | `inicio` | `front-page.html` |
   | Blog | `blog` | `home.html` |
   | Cambio de cerradura y bombín | `cambio-de-cerradura-y-bombin` | `page-cambio-de-cerradura-y-bombin.html` |
   | Instalación de cerrojos de seguridad | `instalacion-de-cerrojos-de-seguridad` | `page-instalacion-de-cerrojos-de-seguridad.html` |
   | Reparación de cierres metálicos | `reparacion-de-cierres-metalicos` | `page-reparacion-de-cierres-metalicos.html` |
   | Quiénes somos | `quienes-somos` | `page-quienes-somos.html` |
   | Contacto | `contacto` | `page-contacto.html` |

   Las plantillas de servicio, contacto y quiénes somos también se pueden elegir a mano en el panel *Plantilla* de cualquier página.
4. **Ajustes → Generales → Idioma del sitio: Español.** Así el `<html lang>`, las fechas y los textos de WordPress salen en castellano.
5. (Opcional) Añade Cabinet Grotesk: ver `assets/fonts/cabinet-grotesk/LEEME.md`.

No se crean páginas de aviso legal, privacidad ni cookies: las gestiona el plugin que ya usáis.

---

## Dirección de arte

La identidad parte de lo que hay dentro de una cerradura, no de iconos genéricos:

- **Corte de llave**: las transiciones entre secciones dibujan el perfil dentado de una llave (estilos de grupo *Corte de llave* y *Corte de llave (a la derecha)*). Solo `clip-path`, sin imágenes.
- **Placa de cobre**: el teléfono principal es una placa de cobre cepillado con cuatro tornillos, hecha con gradientes CSS.
- **Línea de corte**: en *¿Cómo trabajamos?* cada paso es un pitón; al hacer scroll se alinean en la línea de corte, como cuando la llave correcta abre el bombín.
- **Plano técnico**: cuadrículas, reglas de medida, cruces de registro y etiquetas monoespaciadas; ilustraciones técnicas propias en SVG (bombín, cerrojo y cierre metálico) en lugar de fotos de stock.
- **Índice escalonado** de servicios, **etiquetas de llavero** desplegables para *¿Qué te ha pasado?*, **cintas rotuladas** para las ventajas y una **placa de acero** con los datos verificables del negocio.
- Paleta: Azul petróleo `#0B2545`, Cobre oculto `#C86D51`, Grafito `#2D3142`, Gris hielo `#EEF4F8`, más tres variantes calculadas para cumplir contraste AA (cobre claro sobre oscuro, cobre profundo sobre claro y tinta sobre cobre).

### Primera pantalla
El H1 **«Cerrajeros Arroyomolinos»** y el botón de llamada se pintan sin imágenes, animaciones ni JavaScript. El tamaño del H1 se calcula con unidades de contenedor para que «Arroyomolinos» ocupe todo el ancho sin desbordar, y su alto de línea es fijo, así que el cambio de fuente al cargar no mueve nada (CLS 0). Las dos fuentes de la primera pantalla se precargan.

### Movimiento
Las apariciones al hacer scroll y los pitones usan *scroll-driven animations* de CSS: **cero JavaScript propio en el front**. En navegadores sin soporte, o con `prefers-reduced-motion`, todo se muestra directamente.

### Barra de llamada en móvil
Barra fija inferior (solo < 782 px) que aparece al bajar unos tres cuartos de pantalla, cuando el teléfono de la primera pantalla ya ha quedado atrás. En navegadores sin *scroll-driven animations* (o con movimiento reducido) está siempre visible. Reserva su hueco al final del pie para no tapar contenido.

---

## Estructura

```
cerrajeros-arroyomolinos/
├── style.css            Cabecera del tema + todo el CSS (comentado por secciones)
├── theme.json           Paleta, tipografía, tamaños, estilos de elementos y plantillas personalizadas
├── functions.php        Solo carga los módulos de /inc
├── inc/
│   ├── business.php     Nombre, dirección, teléfono, mapa y servicios (única fuente de verdad)
│   ├── setup.php        Estilos, fuentes (Cabinet opcional), estilos de bloque, categorías, ajustes de imágenes
│   ├── branding.php     Logo y favicon de reserva (los del cliente, en assets/images)
│   ├── breadcrumbs.php  Rastro de migas de pan (lo usan el bloque y el JSON-LD)
│   ├── faq-microdata.php Microdatos FAQPage/Question/Answer
│   ├── seo.php          Meta description, canonical y título (solo sin plugin SEO)
│   ├── schema.php       JSON-LD
│   ├── content.php      Textos por defecto de las secciones (castellano)
│   ├── patterns.php     Generadores de marcado de bloques nativos para patrones y plantillas
│   └── page-setup.php   Asistente opcional de páginas
├── blocks/breadcrumbs/  Bloque dinámico «Migas de pan» (sin compilación)
├── parts/               header.html, footer.html
├── templates/           front-page, home, single, page, archive, search, 404, index y una por página clave
├── patterns/            20 patrones de sección + cabecera + pie + 13 composiciones de plantilla
└── assets/              fuentes, logo, favicon e ilustraciones SVG
```

### Patrones (insertador → categorías «Cerrajeros …»)

| Patrón | Archivo |
|---|---|
| FAQ con microdatos | `patterns/faq.php` |
| Llamada a la acción: placa de cobre / franja | `cta-telefono.php`, `cta-franja.php` |
| Servicios (índice escalonado) | `servicios.php` |
| Ventajas (cintas rotuladas) | `ventajas.php` |
| Confianza (placa de datos) | `confianza.php` |
| Texto + imagen derecha / imagen izquierda + texto | `texto-imagen-derecha.php`, `texto-imagen-izquierda.php` |
| Texto centrado editorial | `texto-centrado.php` |
| Por qué elegirnos | `por-que-elegirnos.php` |
| ¿Te suena alguno de estos problemas? | `problemas.php` |
| ¿Qué te ha pasado? | `que-te-ha-pasado.php` |
| ¿Cómo trabajamos? | `como-trabajamos.php` |
| Zonas donde trabajamos | `zonas.php` |
| Introducciones: portada, servicio, página editorial | `hero-portada.php`, `intro-servicio.php`, `intro-pagina.php` |
| Extra: otros servicios, teléfono destacado, ubicación | `otros-servicios.php`, `contacto-telefono.php`, `ubicacion.php` |

Todos son bloques nativos (Grupo, Título, Párrafo, Lista, Botones, Imagen, Detalles…). Los patrones PHP llaman a `inc/patterns.php` para que la FAQ de la portada y la de un servicio, por ejemplo, compartan exactamente el mismo marcado. Cada página de servicio combina las secciones en un orden distinto.

### Estilos de bloque propios
Botón: *Llamada*, *Placa de cobre*, *Contorno* · Grupo: *Corte de llave*, *Corte de llave (a la derecha)*, *Plano técnico*, *Placa de acero* · Párrafo: *Etiqueta técnica* · Título: *Cinta rotulada* · Lista: *Lista numerada técnica* · Imagen: *Marco de plano técnico* · Separador: *Regla*, *Remaches*.

---

## SEO y datos estructurados

- Un único H1 por página, cerca del inicio; jerarquía H2/H3 sin saltos.
- Títulos descriptivos (`Página | Cerrajeros Arroyomolinos`; portada con descripción si no hay lema).
- Meta description: extracto de la página (las páginas admiten extracto) → texto por defecto de cada página clave → resumen automático.
- Canonical: WordPress lo imprime en entradas y páginas; el tema lo añade en el blog y en categorías/etiquetas.
- Migas de pan visibles (bloque propio) y `BreadcrumbList` con el mismo rastro.
- JSON-LD en un único `@graph`: **Locksmith** (nombre, teléfono, dirección, `hasMap`, `areaServed` = Arroyomolinos, catálogo de servicios), **WebSite**, **WebPage** (`ContactPage`, `AboutPage` o `CollectionPage` según la página), **Service** en cada servicio, **BlogPosting** en las entradas. No se inventa nada: sin horarios, valoraciones, precios ni coordenadas.
- **FAQ con microdatos** `FAQPage` / `Question` / `Answer`, con preguntas y respuestas siempre visibles. Los atributos `itemscope`/`itemprop` se añaden al renderizar a partir de clases CSS (`inc/faq-microdata.php`): si se escribieran en el patrón, el editor marcaría esos bloques nativos como «contenido no válido». En el HTML que reciben visitantes y buscadores los microdatos están completos. Cada respuesta es un párrafo (usa Mayús + Intro para saltos de línea). Usa una sola FAQ por página.
- **Plugins SEO**: si detecta Yoast, Rank Math, AIOSEO, SEOPress, The SEO Framework o Slim SEO, el tema deja de imprimir meta description, título propio, WebSite, WebPage, BreadcrumbList y BlogPosting, y solo mantiene Locksmith y Service. Revisa en el plugin que no genere también un LocalBusiness; si lo hace, desactiva el del tema:

  ```php
  add_filter( 'cerrajeros_arroyomolinos_schema', '__return_false' );
  ```

## Datos del negocio
Están en `inc/business.php` y se usan en patrones, pie y JSON-LD. Para cambiarlos sin tocar el tema: filtro `cerrajeros_arroyomolinos_business`. Los textos ya insertados en páginas o plantillas guardadas desde el editor se editan en el editor.

## Logo y favicon
Se usan los archivos facilitados (`logo.png` recortado a su contenido y exportado a WebP, y `cerrajeros-arroyomolinos.png` como favicon e icono de Apple), sin rediseñar. Si subes un logo en el bloque *Logo del sitio* o un *Icono del sitio*, prevalecen los de WordPress.

---

## Revisar antes de publicar

- **Textos**: están escritos en castellano para clientes de Arroyomolinos, sin cifras inventadas. Algunas frases describen la forma de trabajar («te explicamos qué vamos a hacer antes de empezar», «no cambiamos piezas que funcionan»): confirmad que se ajustan a la realidad.
- **Servicios**: la web gira en torno a los tres servicios con página propia. *¿Qué te ha pasado?* menciona quedarse fuera de casa; si no hacéis aperturas, cambiad ese texto.
- **Zona**: solo se indica Arroyomolinos. Si trabajáis en otros municipios, añadidlos vosotros (no se han inventado).
- **Mapa**: se enlaza a Google Maps en lugar de incrustarlo, por rendimiento y para no cargar cookies de terceros.
- **Variaciones de estilo de Ollie**: WordPress muestra también las de Ollie en *Estilos*; elegir una sustituye la paleta de la marca.
- Las secciones usan clases `ca-*` para su diseño: si cambias la estructura de un patrón en el editor, conserva el bloque y su clase.

## Comprobaciones realizadas
Probado en un WordPress 6.7 local con Ollie 1.6.5 (PHP 8.3):
- 35 patrones (1.156 bloques) validados con `@wordpress/blocks` y `@wordpress/block-library` 12: ningún bloque inválido.
- Sin desbordamiento horizontal de 320 a 1920 px en todas las plantillas.
- axe-core (WCAG 2.1 AA): sin incidencias en ninguna plantilla.
- Lighthouse móvil en portada y en una página de servicio (servidor de PHP local, sin gzip ni caché): Rendimiento 85–89, Accesibilidad 100, Prácticas recomendadas 96, SEO 100, CLS 0, TBT 0 ms. En un hosting con compresión y caché el peso de CSS baja de ~65 KB a ~14 KB.
- Sin avisos de PHP con `WP_DEBUG` activo.
