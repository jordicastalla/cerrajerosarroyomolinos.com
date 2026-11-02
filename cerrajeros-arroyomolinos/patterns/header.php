<?php
/**
 * Title: Cabecera
 * Slug: cerrajeros-arroyomolinos/header
 * Categories: header
 * Keywords: cabecera, menú, logo, teléfono
 * Description: Cabecera compacta: logo, menú y botón de llamada. En móvil, el teléfono queda como icono junto al menú.
 * Block Types: core/template-part/header
 * Viewport Width: 1400
 * Inserter: true
 */

use CerrajerosArroyomolinos as CA;

$ca_nav_links = '';
foreach ( CA\services() as $ca_slug => $ca_service ) {
	$ca_nav_links .= CA\block(
		'navigation-link',
		array(
			'label'          => $ca_service['title'],
			'url'            => CA\page_url( $ca_slug ),
			'kind'           => 'custom',
			'isTopLevelLink' => false,
		)
	);
}

$ca_nav = CA\block(
	'navigation',
	array(
		'overlayMenu'            => 'mobile',
		'icon'                   => 'menu',
		'openSubmenusOnClick'    => true,
		'overlayBackgroundColor' => 'primary-alt-accent',
		'overlayTextColor'       => 'base',
		'className'              => 'ca-nav',
		'layout'                 => array(
			'type'           => 'flex',
			'justifyContent' => 'right',
			'flexWrap'       => 'nowrap',
		),
	),
	CA\block(
		'navigation-submenu',
		array(
			'label' => 'Servicios',
			'kind'  => 'custom',
		),
		$ca_nav_links
	)
	. CA\block( 'navigation-link', array( 'label' => 'Quiénes somos', 'url' => CA\page_url( 'quienes-somos' ), 'kind' => 'custom', 'isTopLevelLink' => true ) ) // phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing
	. CA\block( 'navigation-link', array( 'label' => 'Blog', 'url' => CA\blog_url(), 'kind' => 'custom', 'isTopLevelLink' => true ) ) // phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing
	. CA\block( 'navigation-link', array( 'label' => 'Contacto', 'url' => CA\page_url( 'contacto' ), 'kind' => 'custom', 'isTopLevelLink' => true ) ) // phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing
);

$ca_logo = CA\block(
	'site-logo',
	array(
		'width'          => 220,
		'shouldSyncIcon' => false,
		'className'      => 'ca-header__logo',
	)
);

$ca_actions = CA\group(
	$ca_nav . CA\call_button( 'is-style-ca-llamada ca-header__llamar' ),
	array(
		'class'  => 'ca-header__acciones',
		'layout' => array(
			'type'           => 'flex',
			'flexWrap'       => 'nowrap',
			'justifyContent' => 'right',
		),
	)
);

echo CA\group( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	CA\group(
		$ca_logo . $ca_actions,
		array(
			'align'  => 'wide',
			'class'  => 'ca-header__barra',
			'layout' => array(
				'type'           => 'flex',
				'flexWrap'       => 'nowrap',
				'justifyContent' => 'space-between',
			),
		)
	),
	array(
		'name'  => 'Cabecera',
		'align' => 'full',
		'class' => 'ca-header',
		'bg'    => 'primary-alt',
		'text'  => 'base',
	)
);
