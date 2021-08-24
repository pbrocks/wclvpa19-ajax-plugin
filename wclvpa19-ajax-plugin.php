<?php
/**
 * Plugin Name: WCLVPA 2019 Plugin Sample
 * Plugin URL: https://github.com/pbrocks/wclvpa19-ajax-plugin
 * Author: pbrocks
 * Version: 1.1.4
 * Author URI: https://github.com/pbrocks
 * Text Domain: wclvpa19-ajax-plugin
 * Domain Path: /languages
 *
 * @package wclvpa19_ajax_plugin
 */

/**
 * Here we are checking that WordPress is loaded and denying browsers any direct access to the code. Functionality of this plugin's code and only be realized by running the plugin through WordPress.
 */
defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );


add_action( 'init', 'wclvpa19_ajax_plugin_load_php' );

/**
 * [wclvpa19_ajax_plugin_load_php]
 * Tell WordPress where to find the php files.
 *
 * @since 1.0
 *
 * @return void
 */
function wclvpa19_ajax_plugin_load_php() {
	if ( file_exists( __DIR__ . '/inc' ) && is_dir( __DIR__ . '/inc' ) ) {
		/**
		 * Include all php files in /inc directory.
		 */
		foreach ( glob( __DIR__ . '/inc/*.php' ) as $filename ) {
			require $filename;
		}
	}

	if ( file_exists( __DIR__ . '/classes' ) && is_dir( __DIR__ . '/classes' ) ) {
		/**
		 * Include all php files in /classes directory.
		 */
		foreach ( glob( __DIR__ . '/classes/*.php' ) as $filename ) {
			require $filename;
		}
	}
}


/**
 * Setup WordPress localization support
 *
 * @since 4.0
 */
function wclvpa19_ajax_plugin_load_textdomain() {
	load_plugin_textdomain( 'wclvpa19-ajax-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wclvpa19_ajax_plugin_load_textdomain' );
