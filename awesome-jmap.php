<?php
/*
Plugin Name: j2goMap
Plugin URI: http://wordpress.greenlapok.com/plugins/j2gomap/
Description: an awesome google map generate with simple UI for users love to travel and adventures
Version: 2.0.1
Author: Johndy Dejito
Author URI: greenlapok.com
License: GPL2 or later
*/


/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	// Make sure we don't expose any info if called directly
	if ( !function_exists( 'add_action' ) ) {
	
		echo 'english ng kotse ay car';
		exit;
		
	}
	$option_name = 'wp_j2gomap_opts' ;
		$new_value = array("marker_api" => "",
							"post_type" => "post",
							"marker_icon" => plugin_dir_url( __FILE__ )."/img/marker.png",
							"zoom" => "12",
							"m_type" => "ROADMAP",
							"shortcode" => "yes") ;

		if ( get_option( $option_name ) !== true ) {

			$deprecated = '';
			$autoload = 'no';
			add_option( $option_name, $new_value, $deprecated, $autoload );

		}
	//call settings
	include_once dirname( __FILE__ ) . '/j2gomap-settings.php';
	
	//call functions
	include_once dirname( __FILE__ ) . '/j2gomap-functions.php';
	
	//add shortcode
	include_once dirname( __FILE__ ) . '/j2gomap-shortcode.php';
	
	if (!is_admin() && get_gapi() != null){	add_action("wp_enqueue_scripts", "j2gomap_script_enqueue", 11);	}
	function j2gomap_script_enqueue() {
	   wp_deregister_script('jquery');
	   wp_enqueue_script('jquery lib', plugins_url( '/js/jquery-1.10.2.min.js' , __FILE__ ));
	   wp_enqueue_script('jquery map', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://maps.googleapis.com/maps/api/js?key=".get_gapi()."&language=en", false, null);
	   wp_enqueue_script('jquery map3',plugins_url( '/js/gmap/gmap3.min.js' , __FILE__ ), false, null);
	
		wp_register_style( 'j2gomap-style', plugins_url( '/css/j2gomap-style.css' , __FILE__ ));
		wp_enqueue_style( 'j2gomap-style' );
	}
	
	function j2gomap_css_admin_scripts() {

	wp_register_style( 'j2gomap-css', plugins_url( '/css/j2gomap-admin.css' , __FILE__ ));
	wp_enqueue_style( 'j2gomap-css' );

	}
	add_action( 'admin_enqueue_scripts', 'j2gomap_css_admin_scripts' );
	
	function j2gomap_script() {
		wp_enqueue_script('jquery j2gomap',plugins_url( '/js/j2gomap-popup.js' , __FILE__ ), false, null);
	}
	add_action('wp_footer', 'j2gomap_script');

	/*
	* Add settings link on plugin list
	*/
	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

	function add_action_links ( $links ) {
	 $mylinks = array(
	 '<a href="' . admin_url( 'options-general.php?page=j2gomap-setting-admin' ) . '">Settings</a>',
	 );
	return array_merge( $links, $mylinks );
	}
?>