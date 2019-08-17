<?php
/**
 * Plugin Name: WCLVPA 2019 Plugin Sample
 * Plugin URL: https://github.com/pbrocks/wclvpa19-ajax-plugin
 * Author: pbrocks
 * Version: 1.1.3
 * Author URI: https://github.com/pbrocks
 * Text Domain: wclvpa19-ajax-plugin
 * Domain Path: /languages
 */

/**
 * Here we are checking that WordPress is loaded and denying browsers any direct access to the code. Functionality of this plugin's code and only be realized by running the plugin through WordPress.
 */
defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

// echo '<h2>' . __FILE__ . '</h2>';
if ( file_exists( __DIR__ . '/inc' ) && is_dir( __DIR__ . '/inc' ) ) {
	/**
	 * This line includes all php files located in the /inc folder. If there is a problem with the code in the file, you can comment this line out by placing two forward slashes '//' in front of the require statement which turns off all code in that directory.
	 */
	foreach ( glob( __DIR__ . '/inc/*.php' ) as $filename ) {
		require $filename;
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
