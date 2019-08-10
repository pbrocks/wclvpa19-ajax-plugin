<?php
/**
 * Plugin Name: Unsplash AJAX
 * Author: pbrocks
 * Description: Test plugin for Register Helper fields
 */

add_shortcode( 'unsplash-ajax', 'setup_unsplash_ajax_shortcode' );
add_action( 'admin_enqueue_scripts', 'initialize_unsplash_ajax_scripts' );
add_action( 'wp_enqueue_scripts', 'initialize_unsplash_ajax_scripts' );
add_action( 'wp_ajax_unsplash_ajax_request', 'run_unsplash_ajax_function' );
add_action( 'wp_ajax_nopriv_unsplash_ajax_request', 'run_unsplash_ajax_function' );

/**
 * unsplash ajax requests with [unsplash-ajax].
 */
function setup_unsplash_ajax_shortcode() {
	$return = '<form><input id="unsplash-ajax" type="submit" value="Click to Trigger" /></form><div id="return-unsplash"></div>';
	return $return;
}
/**
 * unsplash ajax requests.
 */
function initialize_unsplash_ajax_scripts() {
	wp_register_script( 'unsplash-ajax', plugins_url( 'js/unsplash-ajax.js', __FILE__ ), array( 'jquery' ), time(), true );
	wp_localize_script(
		'unsplash-ajax',
		'unsplash_ajax_object',
		array(
			'unsplash_ajaxurl' => admin_url( 'admin-ajax.php' ),
			'random_number'   => time(),
			'unsplash_nonce'   => wp_create_nonce( 'unsplash-nonce' ),
		)
	);
	wp_enqueue_script( 'unsplash-ajax' );
}

function run_unsplash_ajax_function() {
	$return_data = $_POST;
	echo '<pre>$return_data ';
	print_r( $return_data );
	echo '</pre>';
	exit();
}
