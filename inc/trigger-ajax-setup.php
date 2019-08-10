<?php
/**
 * Plugin Name: Trigger AJAX
 * Author: pbrocks
 * Description: Test plugin for Register Helper fields
 */

add_shortcode( 'trigger-ajax', 'setup_trigger_ajax_shortcode' );
add_action( 'admin_enqueue_scripts', 'initialize_trigger_ajax_scripts' );
add_action( 'wp_enqueue_scripts', 'initialize_trigger_ajax_scripts' );
add_action( 'wp_ajax_trigger_ajax_request', 'run_trigger_ajax_function' );
add_action( 'wp_ajax_nopriv_trigger_ajax_request', 'run_trigger_ajax_function' );

/**
 * [setup_trigger_ajax_shortcode]
 *
 * Create a button that can trigger ajax requests. Deploy with a shortcode -> [trigger-ajax].
 *
 * @return [type] [description]
 */
function setup_trigger_ajax_shortcode() {
	$return = '
	<form>
	<input id="input1-ajax" type="text" value="this is the value" />
	<input id="hidden-input" type="hidden" value="this is a hidden value" />
	<input id="trigger-ajax-button" type="submit" value="Click to Trigger" class="button-primary" />
	</form>

	<div id="return-trigger"></div>';
	return $return;
}
/**
 * [initialize_trigger_ajax_scripts]
 *
 * @return [type] [description]
 */
function initialize_trigger_ajax_scripts() {
	wp_register_script( 'trigger-ajax', plugins_url( 'js/trigger-ajax.js', __FILE__ ), array( 'jquery' ), time(), true );
	wp_localize_script(
		'trigger-ajax',
		'trigger_ajax_object',
		array(
			'trigger_ajaxurl' => admin_url( 'admin-ajax.php' ),
			'random_number'   => time(),
			'trigger_nonce'   => wp_create_nonce( 'trigger-nonce' ),
			'explanation_one' => 'Set up anything from the PHP side here in this function (' . __FUNCTION__ . '). Add the variable to the JS file.',
		)
	);
	wp_enqueue_script( 'trigger-ajax' );
}

function run_trigger_ajax_function() {
	$return_data                      = $_POST;
	$return_data['explanation_three'] = 'You can also add data here in this function (' . __FUNCTION__ . ') if you need javascript to help you calculate first.';
	echo '<pre>$return_data ';
	print_r( $return_data );
	// echo json_encode( $return_data );
	echo '</pre>';
	exit();
}
