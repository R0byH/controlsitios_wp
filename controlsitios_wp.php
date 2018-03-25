<?php
/*
 * PlugIn de tipo de cambio para mostrar 
 * 
 *
 * @link              	https://github.com/RobyH/uasb_controlsitios_wp_plugin
 * @since             	1.0.0
 * @package           	controlsitios
 * Plugin Name:			Control de sitios
 * Description:       	Trabajo final para el modulo de gestion de contenido Maestria Desarrollo WEB UASB
 * Plugin URI:        	http://localhost:8089/wordpress/controlsitios
 * Author:            	Cesar Roberto Herbas Delgadillo
 * Version:     		1.0
 * License:     		GPLv2 or later
 * License URI: 		https://www.gnu.org/licenses/gpl-2.0.txt
*/
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// carga los textos
function myplugin_textdomain_load() { //myplugin_load_textdomain
	load_plugin_textdomain( 'controlsitios_wp', false, plugin_dir_path( __FILE__ ) . 'languages/' );
}

// se incluyen las dependencias para el administrador
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
}

// se incluyen las dependencias p�blicas
require_once plugin_dir_path( __FILE__ ) . 'admin/controlsitios.php';

