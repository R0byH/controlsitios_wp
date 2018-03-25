<?php // MyPlugin - Admin Menu

/*
	Añadiendo el menú y las configuraciones de página
*/

// añade top-level menu
function controlsitios_add_toplevel_menu() {

	add_menu_page(
		'Proyecto Final: Control de Sitios',
		'Control de Sitios',
		'manage_options',
		'control',
		'controlsitios_display_page',
		plugins_url('controlsitios_wp/images/icon-internet.png')
		
	);

}
add_action( 'admin_menu', 'controlsitios_add_toplevel_menu' );