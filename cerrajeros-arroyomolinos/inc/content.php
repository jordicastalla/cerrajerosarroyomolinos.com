<?php
/**
 * Textos por defecto de las secciones.
 *
 * Estos textos se insertan al usar los patrones y las plantillas. Una vez en
 * el editor, se cambian directamente desde WordPress; este archivo solo define
 * el punto de partida.
 *
 * Criterio: no se afirma nada que el cliente no haya facilitado (años de
 * experiencia, horarios, tiempos de llegada, precios, valoraciones). Las
 * frases sobre la forma de trabajar ("te lo explicamos antes de empezar")
 * conviene que el cliente las revise y confirme.
 *
 * @package cerrajeros-arroyomolinos
 */

namespace CerrajerosArroyomolinos;

defined( 'ABSPATH' ) || exit;

/**
 * Enlace de teléfono para usar dentro de un texto.
 */
function phone_link() {
	return sprintf( '<a href="%s">%s</a>', esc_attr( phone_href() ), esc_html( business()['phone_display'] ) );
}

/**
 * Enlace a una página de servicio.
 *
 * @param string $slug  Slug de la página.
 * @param string $label Texto del enlace (por defecto, el título del servicio).
 */
function service_link( $slug, $label = '' ) {
	$services = services();
	$label    = $label ? $label : ( $services[ $slug ]['title'] ?? $slug );

	return sprintf( '<a href="%s">%s</a>', esc_url( page_url( $slug ) ), esc_html( $label ) );
}

/* -------------------------------------------------------------------------
 * Problemas
 * ---------------------------------------------------------------------- */

function content_problemas_general() {
	return array(
		'etiqueta' => 'Diagnóstico rápido',
		'titulo'   => '¿Te suena alguno de estos problemas?',
		'intro'    => 'Una cerradura rara vez falla de golpe: antes avisa. Si te reconoces en alguno de estos casos, mejor resolverlo ahora que con la puerta cerrada.',
		'items'    => array(
			array( 'La llave gira en falso o no entra.', 'Suele ser desgaste del bombín o una pieza rota por dentro. Forzarla solo lo empeora.' ),
			array( 'Se ha partido la llave dentro.', 'No intentes sacarla con pinzas ni pegamento: es fácil empujar el trozo más adentro.' ),
			array( 'Te has quedado fuera.', 'Llaves dentro, perdidas o una puerta que se ha cerrado de golpe.' ),
			array( 'No sabes quién tiene copia de tus llaves.', 'Después de una mudanza, una pérdida o un robo, lo prudente es cambiar el bombín.' ),
			array( 'Han intentado forzar la puerta.', 'Marcas en el escudo, un bombín tocado o una cerradura que ya no cierra igual.' ),
			array( 'El cierre metálico del local no sube.', 'Lamas que rozan, guías deformadas o una cerradura atascada por la calle.' ),
		),
		'cierre'   => '¿Te ha pasado algo parecido? Llámanos al ' . phone_link() . ' y cuéntanoslo.',
	);
}

function content_problemas_bombin() {
	return array(
		'etiqueta' => 'Señales de aviso',
		'titulo'   => '¿Te suena alguno de estos problemas?',
		'intro'    => 'Son señales de que el bombín o la cerradura necesitan atención. Cuanto antes se revisen, más fácil es la solución.',
		'items'    => array(
			array( 'La llave entra pero no gira.', 'Desgaste, suciedad o una pieza interna rota. Si la fuerzas, puede partirse.' ),
			array( 'La llave se ha partido dentro.', 'No uses pegamento ni pinzas: el trozo puede quedar más adentro y dañar el bombín.' ),
			array( 'Has perdido las llaves.', 'Si no sabes quién puede tenerlas, cambiar el bombín hace que dejen de servir.' ),
			array( 'Acabas de mudarte.', 'Nunca sabes cuántas copias de la llave andan por ahí.' ),
			array( 'Han intentado forzar la cerradura.', 'Aunque la puerta cierre, el bombín puede haber quedado tocado.' ),
			array( 'Tu bombín tiene muchos años.', 'Los modelos antiguos suelen ofrecer menos resistencia que los actuales.' ),
		),
		'cierre'   => 'Si alguno te suena, llámanos al ' . phone_link() . ' y lo revisamos.',
	);
}

/* -------------------------------------------------------------------------
 * ¿Qué te ha pasado?
 * ---------------------------------------------------------------------- */

function content_situaciones_general() {
	return array(
		'etiqueta' => 'Tu caso',
		'titulo'   => '¿Qué te ha pasado?',
		'intro'    => 'Elige lo que más se parezca a tu situación y te contamos qué hacemos.',
		'items'    => array(
			array(
				'Me he quedado fuera de casa',
				'Llámanos y dinos qué puerta y qué cerradura tienes, si lo sabes. Si después conviene cambiar el bombín, te lo explicamos.',
				'cambio-de-cerradura-y-bombin',
			),
			array(
				'He perdido las llaves',
				'Si no sabes dónde han acabado, lo prudente es cambiar el bombín para que esas llaves dejen de abrir tu puerta.',
				'cambio-de-cerradura-y-bombin',
			),
			array(
				'Han intentado entrar en casa',
				'Revisamos la puerta y la cerradura, cambiamos lo que haya quedado dañado y te proponemos cómo reforzarla.',
				'instalacion-de-cerrojos-de-seguridad',
			),
			array(
				'La llave no gira o se ha roto',
				'No la fuerces ni intentes sacarla con herramientas. Llámanos y te decimos cómo actuar mientras llegamos.',
				'cambio-de-cerradura-y-bombin',
			),
			array(
				'El cierre del local no sube o no baja',
				'Revisamos cerradura, lamas, guías y mecanismo para que el cierre vuelva a funcionar sin forzarlo.',
				'reparacion-de-cierres-metalicos',
			),
			array(
				'Quiero más seguridad en mi puerta',
				'Un cerrojo de seguridad añade un segundo punto de cierre independiente de la cerradura principal.',
				'instalacion-de-cerrojos-de-seguridad',
			),
		),
	);
}

function content_situaciones_cierres() {
	return array(
		'etiqueta' => 'Averías habituales',
		'titulo'   => '¿Qué te ha pasado?',
		'intro'    => 'Estas son las averías típicas de un cierre metálico. Si no ves la tuya, llámanos igualmente.',
		'items'    => array(
			array(
				'El cierre no sube o se queda a medias',
				'Puede deberse a lamas que rozan, a guías deformadas o al mecanismo de compensación. Mejor no forzarlo: llámanos y lo revisamos.',
				'',
			),
			array(
				'La cerradura del cierre no gira',
				'La suciedad y la humedad de la calle castigan mucho estas cerraduras. A veces basta con repararla; si no, se cambia.',
				'',
			),
			array(
				'Han intentado forzarlo',
				'Revisamos cerradura, zócalo y lamas, y te proponemos cómo reforzar el cierre.',
				'',
			),
			array(
				'Una lama se ha doblado o se ha salido',
				'Las lamas dañadas hacen que el cierre roce y se desgaste más deprisa. Se pueden enderezar o sustituir.',
				'',
			),
			array(
				'Hace ruido o cuesta mucho subirlo',
				'Es una señal de que el mecanismo necesita un ajuste antes de que falle del todo.',
				'',
			),
		),
	);
}

/* -------------------------------------------------------------------------
 * Cómo trabajamos
 * ---------------------------------------------------------------------- */

function content_metodo() {
	return array(
		'etiqueta' => 'Método',
		'titulo'   => '¿Cómo trabajamos?',
		'intro'    => 'En un bombín, la puerta solo se abre cuando todas las piezas quedan a la altura justa. Nosotros trabajamos igual: paso a paso y sin saltarnos ninguno.',
		'pasos'    => array(
			array( 'Nos llamas', 'Nos cuentas qué ha pasado, qué tipo de puerta es y dónde estás en Arroyomolinos.' ),
			array( 'Te orientamos', 'Por teléfono te explicamos qué puede estar fallando y qué opciones hay.' ),
			array( 'Revisamos en el sitio', 'Comprobamos puerta, cerradura o cierre y te decimos qué hay que hacer antes de empezar.' ),
			array( 'Lo dejamos funcionando', 'Terminamos el trabajo y probamos contigo que abre y cierra como debe.' ),
		),
		'cierre'   => 'Todo empieza con una llamada: ' . phone_link(),
	);
}

/* -------------------------------------------------------------------------
 * Por qué elegirnos / Ventajas / Confianza
 * ---------------------------------------------------------------------- */

function content_razones() {
	return array(
		'etiqueta' => 'Por qué elegirnos',
		'titulo'   => 'Una cerradura bien puesta no se nota. Una mal puesta, sí.',
		'intro'    => 'La usas varias veces al día durante años. Por eso cuidamos también lo que no se ve: el ajuste, la fijación y que la puerta cierre con suavidad.',
		'filas'    => array(
			array( 'Cerca', 'Estamos en C. de Cartagena, 8-66, en el propio Arroyomolinos.' ),
			array( 'Claros', 'Antes de empezar te explicamos qué vamos a hacer y por qué.' ),
			array( 'Con criterio', 'Si basta con ajustar o reparar, te lo decimos. No cambiamos piezas que funcionan.' ),
			array( 'Cuidadosos', 'Respetamos la puerta, el marco y el acabado, y dejamos la zona recogida.' ),
			array( 'Directos', 'Un único teléfono para todo: ' . phone_link() . '.' ),
		),
	);
}

function content_ventajas_general() {
	return array(
		'etiqueta' => 'Ventajas',
		'titulo'   => 'Lo que ganas llamándonos',
		'items'    => array(
			array( 'Un solo número', 'Llamas al ' . phone_link() . ' y nos cuentas el problema sin pasar por formularios.' ),
			array( 'De Arroyomolinos', 'Estamos en el propio municipio, en C. de Cartagena.' ),
			array( 'Sin rodeos', 'Te decimos qué le pasa a tu cerradura con palabras claras.' ),
			array( 'A tu medida', 'Te recomendamos lo que encaja con tu puerta y con el uso que le das.' ),
		),
	);
}

function content_ventajas_cerrojos() {
	return array(
		'etiqueta' => 'Ventajas de un cerrojo',
		'titulo'   => 'Lo que aporta un cerrojo de seguridad',
		'items'    => array(
			array( 'Segundo cierre', 'Un punto de cierre más, además de la cerradura principal.' ),
			array( 'Independiente', 'Funciona por separado: si una falla, la otra sigue cerrando.' ),
			array( 'Disuasorio', 'Suele verse desde fuera, y eso ya hace la puerta menos atractiva para quien busca la fácil.' ),
			array( 'Para cada puerta', 'Vivienda, portal, trastero o local: se elige el modelo según la puerta.' ),
		),
	);
}

function content_confianza() {
	return array(
		'etiqueta' => 'Confianza',
		'titulo'   => 'Antes de abrirle la puerta a alguien, comprueba quién es',
		'parrafos' => array(
			'Cuando necesitas un cerrajero, lo normal es buscar con prisa y llamar al primero que aparece. Nosotros te lo ponemos fácil para comprobarlo: tenemos dirección en Arroyomolinos, un único teléfono y puedes encontrarnos en Google Maps.',
			'Un consejo que sirve con cualquier cerrajero: pregunta siempre el nombre de la empresa y su dirección antes de que vayan a tu casa.',
		),
	);
}

/* -------------------------------------------------------------------------
 * Texto + imagen y texto centrado
 * ---------------------------------------------------------------------- */

function content_texto_bombin() {
	return array(
		'etiqueta' => 'Por dentro',
		'titulo'   => 'Qué hay dentro de un bombín',
		'parrafos' => array(
			'El bombín es la pieza donde metes la llave. Dentro tiene una fila de pitones y muelles: con la llave correcta, todos quedan a la altura justa y el rotor puede girar. Cuando una pieza se desgasta o se rompe, la llave empieza a fallar.',
			'Por eso, al cambiar un bombín, medimos la puerta, elegimos uno adecuado y comprobamos que la llave entra y gira sin forzar.',
		),
		'imagen'   => 'assets/images/ilustracion-bombin.svg',
		'alt'      => 'Ilustración técnica de un bombín en sección: muelles, contrapitones y pitones alineados en la línea de corte al introducir la llave correcta.',
		'pie'      => 'Fig. 1 — Bombín de pitones en sección',
	);
}

function content_texto_cerrojo() {
	return array(
		'etiqueta' => 'Refuerzo',
		'titulo'   => 'Cómo es un cerrojo de seguridad',
		'parrafos' => array(
			'Un cerrojo se fija a la hoja de la puerta y su pasador entra en un cerradero anclado al marco. Esa fijación al marco es tan importante como el propio cerrojo: si el marco cede, el cerrojo pierde su sentido.',
			'Por eso revisamos el estado de la puerta y del marco antes de recomendarte un modelo.',
		),
		'imagen'   => 'assets/images/ilustracion-cerrojo.svg',
		'alt'      => 'Esquema de un cerrojo de seguridad instalado: cuerpo del cerrojo con su bombín y el pasador entrando en el cerradero del marco.',
		'pie'      => 'Fig. 2 — Cerrojo de seguridad y cerradero',
	);
}

function content_texto_cierre() {
	return array(
		'etiqueta' => 'Anatomía',
		'titulo'   => 'Las partes de un cierre metálico',
		'parrafos' => array(
			'Un cierre metálico tiene más piezas de las que parece: el eje con sus muelles, las lamas, las guías laterales, el zócalo y la cerradura. Cuando una falla, las demás trabajan forzadas.',
			'Por eso no nos quedamos solo en la pieza rota: revisamos el conjunto para que el cierre vuelva a subir y bajar con suavidad.',
		),
		'imagen'   => 'assets/images/ilustracion-cierre-metalico.svg',
		'alt'      => 'Esquema de un cierre metálico de local: eje con muelles en la parte superior, lamas, guías laterales, zócalo y cerradura.',
		'pie'      => 'Fig. 3 — Partes de un cierre metálico',
	);
}

function content_centrado_general() {
	return array(
		'etiqueta' => 'Nuestra forma de trabajar',
		'titulo'   => 'Hacer bien lo pequeño',
		'lead'     => 'Una cerradura que roza, una llave que hay que mover dos veces, un cierre que cuesta subir. Son detalles que acaban convirtiéndose en una avería. Nos gusta resolverlos antes.',
		'texto'    => 'Si tienes dudas sobre el estado de tu cerradura, llámanos al ' . phone_link() . ' y te orientamos.',
	);
}

function content_centrado_cerrojos() {
	return array(
		'etiqueta' => 'Por qué un cerrojo',
		'titulo'   => 'Dos cierres mejor que uno',
		'lead'     => 'Muchas puertas lo confían todo a una sola cerradura. Un cerrojo funciona por separado: aunque alguien consiguiera abrir una, todavía le quedaría la otra.',
		'texto'    => '¿No sabes si tu puerta admite un cerrojo? Llámanos al ' . phone_link() . ' y te lo decimos.',
	);
}

function content_centrado_quienes() {
	return array(
		'etiqueta' => 'Quiénes somos',
		'titulo'   => 'Una cerrajería de Arroyomolinos',
		'lead'     => 'Somos Cerrajeros Arroyomolinos y trabajamos desde C. de Cartagena, 8-66. Nuestro trabajo es que las puertas de casas, portales, locales y garajes del municipio abran cuando deben y cierren de verdad.',
		'texto'    => 'Cambiamos cerraduras y bombines, instalamos cerrojos de seguridad y reparamos cierres metálicos. Si tienes una duda, llámanos al ' . phone_link() . '.',
	);
}

/* -------------------------------------------------------------------------
 * Preguntas frecuentes
 * ---------------------------------------------------------------------- */

function content_faq_general() {
	return array(
		'etiqueta' => 'Preguntas frecuentes',
		'titulo'   => 'Lo que conviene saber',
		'intro'    => '¿Tienes otra duda? Llámanos al ' . phone_link() . '.',
		'items'    => array(
			array( '¿Cuándo basta con cambiar el bombín y no toda la cerradura?', 'Si la cerradura funciona bien y el problema está en la llave o en la seguridad del cilindro, normalmente basta con cambiar el bombín. Si la cerradura está dañada, forzada o muy gastada, conviene cambiarla entera. Te lo explicamos antes de empezar.' ),
			array( '¿Qué hago si se ha partido la llave dentro?', 'No intentes sacarla con pinzas, pegamento ni otra llave: es fácil empujar el trozo más adentro o dañar el bombín. Llámanos y te decimos cómo actuar.' ),
			array( '¿Merece la pena poner un cerrojo además de la cerradura?', 'Un cerrojo añade un segundo punto de cierre independiente. Es una mejora habitual en puertas de vivienda, portales, trasteros y locales, sobre todo cuando la cerradura principal es sencilla.' ),
			array( '¿Reparáis cierres metálicos de locales y garajes?', 'Sí. Revisamos cerradura, lamas, guías y mecanismo de cierres y persianas metálicas para que vuelvan a subir, bajar y cerrar con normalidad.' ),
			array( '¿Dónde trabajáis?', 'En Arroyomolinos (Madrid). Estamos en C. de Cartagena, 8-66. Si estás fuera del municipio, llámanos y te decimos si podemos ayudarte.' ),
			array( '¿Cómo os contacto?', 'Por teléfono, en el ' . business()['phone_display'] . '. Es la forma más rápida de explicarnos qué ocurre.' ),
		),
	);
}

function content_faq_bombin() {
	return array(
		'etiqueta' => 'Preguntas frecuentes',
		'titulo'   => 'Dudas sobre bombines y cerraduras',
		'intro'    => '¿No ves tu pregunta? Llámanos al ' . phone_link() . '.',
		'items'    => array(
			array( '¿Cambio el bombín o toda la cerradura?', 'Si la cerradura funciona bien y el problema está en la llave o en la seguridad del cilindro, normalmente basta con el bombín. Si está dañada, forzada o muy gastada, conviene cambiarla entera. Te lo explicamos antes de empezar.' ),
			array( '¿El bombín nuevo tiene que ser de la misma medida?', 'Sí. Tiene que encajar en la cerradura y no sobresalir demasiado de la puerta, porque un bombín que sobresale es más fácil de atacar. Medimos antes de cambiarlo.' ),
			array( '¿Qué hago si la llave se ha partido dentro?', 'No intentes sacarla con pinzas ni pegamento. Llámanos y te decimos cómo actuar para no dañar el bombín.' ),
			array( '¿Cuántas llaves vienen con el bombín nuevo?', 'Depende del modelo. Cuando te recomendemos uno, te decimos cuántas llaves incluye.' ),
		),
	);
}

function content_faq_cerrojos() {
	return array(
		'etiqueta' => 'Preguntas frecuentes',
		'titulo'   => 'Dudas sobre cerrojos de seguridad',
		'intro'    => '¿Tienes otra pregunta? Llámanos al ' . phone_link() . '.',
		'items'    => array(
			array( '¿Se puede poner un cerrojo en cualquier puerta?', 'En muchas puertas de madera y metálicas sí, pero depende del grosor de la hoja y del estado del marco. Lo revisamos antes de proponerte un modelo.' ),
			array( '¿El cerrojo abre con la misma llave que la cerradura?', 'Según el modelo, puede llevar una llave distinta o la misma que la cerradura principal. Coméntanoslo y te decimos qué opciones hay para tu puerta.' ),
			array( '¿Un cerrojo sustituye a la cerradura?', 'No, la complementa. La cerradura sigue siendo el cierre principal y el cerrojo añade un segundo punto independiente.' ),
			array( '¿También lo instaláis en portales y trasteros?', 'Sí. En portales de comunidad y trasteros, un cerrojo es una forma sencilla de reforzar el acceso.' ),
		),
	);
}

function content_faq_cierres() {
	return array(
		'etiqueta' => 'Preguntas frecuentes',
		'titulo'   => 'Dudas sobre cierres metálicos',
		'intro'    => '¿Tu caso es distinto? Llámanos al ' . phone_link() . '.',
		'items'    => array(
			array( '¿Reparáis cierres de garaje además de locales?', 'Sí, trabajamos con cierres y persianas metálicas tanto de locales comerciales como de garajes.' ),
			array( '¿Hay que cambiar todo el cierre si falla?', 'No necesariamente. Muchas averías se resuelven reparando o sustituyendo la pieza dañada: una lama, la cerradura o un ajuste del mecanismo.' ),
			array( '¿Qué hago si el cierre se ha quedado bloqueado a medias?', 'No lo fuerces ni lo dejes caer: puedes dañar las guías o el mecanismo. Llámanos y te indicamos cómo actuar.' ),
			array( '¿Podéis cambiar la cerradura del cierre?', 'Sí. Si está muy deteriorada o ha sufrido un intento de robo, la sustituimos por una nueva.' ),
		),
	);
}

function content_faq_contacto() {
	return array(
		'etiqueta' => 'Antes de llamar',
		'titulo'   => 'Preguntas sobre el contacto',
		'intro'    => 'Y si prefieres preguntarlo directamente: ' . phone_link() . '.',
		'items'    => array(
			array( '¿Cuál es la mejor forma de contactar?', 'Por teléfono, en el ' . business()['phone_display'] . '. Hablando es como mejor entendemos qué le pasa a tu puerta.' ),
			array( '¿Qué os tengo que contar cuando llame?', 'Qué ha pasado, qué tipo de puerta es (vivienda, portal, local o garaje) y la dirección en Arroyomolinos.' ),
			array( '¿Trabajáis fuera de Arroyomolinos?', 'Nuestra zona es Arroyomolinos. Si estás fuera, llámanos y te decimos si podemos ayudarte.' ),
		),
	);
}

/* -------------------------------------------------------------------------
 * Introducciones de servicio
 * ---------------------------------------------------------------------- */

function content_intro_servicio( $slug ) {
	$intros = array(
		'cambio-de-cerradura-y-bombin'         => array(
			'lead'     => 'Cambiamos el bombín o la cerradura completa cuando la llave falla, se parte dentro, la has perdido o simplemente quieres más seguridad en tu puerta.',
			'incluye'  => array(
				'Revisión de la cerradura y del bombín',
				'Bombín adecuado a la medida de tu puerta',
				'Cambio de cerradura completa si está dañada',
				'Prueba final con todas las llaves',
			),
			'imagen'   => 'assets/images/ilustracion-bombin.svg',
			'alt'      => 'Ilustración técnica de un bombín de pitones en sección.',
		),
		'instalacion-de-cerrojos-de-seguridad' => array(
			'lead'     => 'Un cerrojo de seguridad añade un segundo punto de cierre a tu puerta. Lo instalamos en viviendas, portales, trasteros y locales de Arroyomolinos.',
			'incluye'  => array(
				'Revisión de la puerta y del marco',
				'Propuesta del cerrojo adecuado',
				'Instalación y ajuste del cerradero',
				'Prueba de cierre con la puerta en uso',
			),
			'imagen'   => 'assets/images/ilustracion-cerrojo.svg',
			'alt'      => 'Esquema de un cerrojo de seguridad con su cerradero.',
		),
		'reparacion-de-cierres-metalicos'      => array(
			'lead'     => 'Reparamos cierres y persianas metálicas de locales y garajes en Arroyomolinos cuando no suben, no bajan, rozan o la cerradura se queda atascada.',
			'incluye'  => array(
				'Cerradura y bombín del cierre',
				'Lamas dobladas o desenganchadas',
				'Guías laterales y zócalo',
				'Eje y muelles de compensación',
			),
			'imagen'   => 'assets/images/ilustracion-cierre-metalico.svg',
			'alt'      => 'Esquema de un cierre metálico de local con sus partes.',
		),
	);

	return $intros[ $slug ];
}
