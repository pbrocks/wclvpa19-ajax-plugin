<?php
/**
 * wclvpa19_plugin
 */
/**
 * Add a page to the dashboard menu.
 *
 * @since 1.0.0
 *
 * @return array
 */
add_action( 'admin_menu', 'wclvpa19_plugin' );
function wclvpa19_plugin() {
	$slug  = preg_replace( '/_+/', '-', __FUNCTION__ );
	$label = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
	add_dashboard_page( __( $label, 'wclvpa19-ajax-plugin' ), __( $label, 'wclvpa19-ajax-plugin' ), 'manage_options', $slug . '.php', 'wclvpa19_plugin_page' );
}

/**
 * Debug Information
 *
 * @since 1.0.0
 *
 * @param bool $html Optional. Return as HTML or not
 *
 * @return string
 */
function wclvpa19_plugin_page() {
	echo '<div class="wrap">';
	echo '<h2>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h2>';
	echo '<div class="add-to-customizations-dash" style="background:aliceblue;border: 1rem solid #efefef;padding:1rem 2rem; position: relative; z-index: 222;">';
	do_action( 'add_to_customizations_dash' );
	echo '</div>';

	echo '<div class="add-to-customizations-bottom" style="background:#efefef;border:.21rem solid salmon; padding:0 1rem; position: fixed; bottom: 2rem; right: 10%;">';
	do_action( 'add_to_customizations_bottom' );
	echo '</div>';

	echo '</div>';
}

add_action( 'add_to_customizations_dash', 'adding_to_wclvpa19_plugin_page' );

/**
 * Debug Information
 *
 * @since 1.0.0
 *
 * @param bool $html Optional. Return as HTML or not
 *
 * @return string
 */
function adding_to_wclvpa19_plugin_page() {
	echo '<h3>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h3>';
	echo '<h3>Add more info here</h3>';
	echo do_shortcode( '[trigger-ajax]' );
}

add_action( 'add_to_customizations_bottom', 'adding_to_wclvpa19_plugin_bottom' );

/**
 * Debug Information
 *
 * @since 1.0.0
 *
 * @param bool $html Optional. Return as HTML or not
 *
 * @return string
 */
function adding_to_wclvpa19_plugin_bottom() {
	global $wpdb;
	echo '<pre><h3>' . ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) ) . '</h3>';
	$screen         = get_current_screen();
	$site_theme     = wp_get_theme();
	$site_prefix    = $wpdb->prefix;
	$prefix_message = '$site_prefix = ' . $site_prefix;
	if ( is_multisite() ) {
		$network_prefix  = $wpdb->base_prefix;
		$prefix_message .= '<br>$network_prefix = ' . $network_prefix;
	}

	$site_theme = wp_get_theme();
	echo '<h4>Theme is ' . sprintf(
		__( '%1$s and is version %2$s', 'text-domain' ),
		$site_theme->get( 'Name' ),
		$site_theme->get( 'Version' )
	) . '</h4>';
	echo '<h4>Templates found in ' . get_template_directory() . '</h4>';
	echo '<h4>Stylesheet found in ' . get_stylesheet_directory() . '</h4>';

	echo '<h4 style="color:rgba(250,128,114,.7);">Current Screen is <span style="color:rgba(250,128,114,1);">' . $screen->id . '</span></h4>';
	echo 'Your WordPress version is ' . get_bloginfo( 'version' );
	echo '<h4>DB Prefix is ' . $site_prefix . '</h4>';
	echo '<h4>Find this file at ' . __FILE__ . '<br>';
	echo 'The URL ' . plugins_url( '/', __FILE__ ) . '</h4></pre>';

}
