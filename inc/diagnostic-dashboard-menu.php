<?php
/**
 * Tabbed Submenu on index.php
 */


add_action( 'init', 'diagnostic_dashboard_admin_init' );
add_action( 'admin_menu', 'diagnostic_dashboard_settings', 13 );
function diagnostic_dashboard_admin_init() {
	$settings = get_option( 'diagnostic_dashboard_tabbed_settings' );
	if ( empty( $settings ) ) {
		$settings = array(
			'diagnostic_dashboard_textarea'     => 'Some intro textarea text for the home page',
			'diagnostic_dashboard_tag_class' => false,
			'diagnostic_dashboard_whatever'  => false,
			'diagnostic_dashboard_text'     => 'Some text for the input',
		);
		add_option( 'diagnostic_dashboard_tabbed_settings', $settings, '', 'yes' );
	}
}

function diagnostic_dashboard_settings() {
	$plugin_data = get_diagnostic_dashboard_setup_data();

	$slug          = preg_replace( '/_+/', '-', __FUNCTION__ );
	$label         = ucwords( preg_replace( '/_+/', ' ', __FUNCTION__ ) );
	$settings_page = add_dashboard_page( __( $label, 'diagnostic-dashboard-menu' ), __( $label, 'diagnostic-dashboard-menu' ), 'manage_options', $slug . '.php', 'diagnostic_dashboard_settings_page' );
	add_action( "load-{$settings_page}", 'diagnostic_dashboard_load_settings_page' );
}

function diagnostic_dashboard_load_settings_page() {
	if ( isset( $_POST['diagnostic-dashboard-settings-submit'] ) && $_POST['diagnostic-dashboard-settings-submit'] === 'Y' ) {
		check_admin_referer( 'diagnostic-dashboard-settings-page' );
		diagnostic_dashboard_save_tabbed_settings();
		$url_parameters = isset( $_GET['tab'] ) ? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
		wp_redirect( admin_url( 'index.php?page=diagnostic-dashboard-settings.php&' . $url_parameters ) );
		exit;
	}
}

function diagnostic_dashboard_save_tabbed_settings() {
	global $pagenow;
	$settings = get_option( 'diagnostic_dashboard_tabbed_settings' );

	if ( $pagenow == 'index.php' && 'diagnostic-dashboard-settings.php' === $_GET['page'] ) {
		if ( isset( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'textarea';
		}

		switch ( $tab ) {
			case 'front_tab':
				$settings['diagnostic_dashboard_tag_class'] = $_POST['diagnostic_dashboard_tag_class'];
				break;
			case 'checkbox':
				$settings['diagnostic_dashboard_tag_class'] = $_POST['diagnostic_dashboard_tag_class'];
				break;
			case 'text_input':
				$settings['diagnostic_dashboard_text'] = $_POST['diagnostic_dashboard_text'];
				break;
			case 'textarea':
				$settings['diagnostic_dashboard_textarea'] = $_POST['diagnostic_dashboard_textarea'];
				break;
		}
	}
	if ( ! current_user_can( 'unfiltered_html' ) ) {
		if ( $settings['diagnostic_dashboard_text'] ) {
			$settings['diagnostic_dashboard_text'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['diagnostic_dashboard_text'] ) ) );
		}
		if ( $settings['diagnostic_dashboard_textarea'] ) {
			$settings['diagnostic_dashboard_textarea'] = stripslashes( esc_textarea( wp_filter_post_kses( $settings['diagnostic_dashboard_textarea'] ) ) );
		}
	}

	$updated = update_option( 'diagnostic_dashboard_tabbed_settings', $settings );
}

function diagnostic_dashboard_admin_tabs( $current = 'front_tab' ) {
	$tabs  = array(
		'front_tab'  => __( 'Home', 'diagnostic-dashboard' ),
		'textarea'   => __( 'Textarea', 'diagnostic-dashboard' ),
		'checkbox'   => __( 'Checkbox', 'diagnostic-dashboard' ),
		'text_input' => __( 'Text Input', 'diagnostic-dashboard' ),
	);
	$links = array();
	echo '<div id="icon-themes" class="icon32"><br></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach ( $tabs as $tab => $name ) {
		$class = ( $tab === $current ) ? ' nav-tab-active' : '';
		echo "<a class='nav-tab$class' href='?page=diagnostic-dashboard-settings.php&tab=$tab'>$name</a>";
	}
	echo '</h2>';
}

function get_diagnostic_dashboard_setup_data() {
	$plugin_data['Name'] = 'Diagnostic Dashboard';
	return $plugin_data;
}
function diagnostic_dashboard_settings_page() {
							global $pagenow;
	$settings    = get_option( 'diagnostic_dashboard_tabbed_settings' );
	$plugin_data = get_diagnostic_dashboard_setup_data();
	?>
	
	<div class="wrap">
		<h2><?php echo __( $plugin_data['Name'] . ' Settings', 'diagnostic-dashboard' ); ?></h2>
		<style type="text/css">
		h1, p {
			margin: 0 0 1em 0;
		}

		/**
		 * no grid support? 
		 */
		.sidebar {
			float: left;
		}

		.content {
			float: right;
		}

		/**
		 * make a grid 
		 */
		.grid-wrapper {
			margin: 0 auto;
			display: grid;
			grid-template-columns: 1fr 4fr;
			grid-gap: .5rem;
		}

		.grid-wrapper > * {
			background-color: mintcream;
			color: maroon;
			border-radius: .2rem;
			padding: 1rem;
			font-size: 150%;
			/* needed for the floated layout*/
			margin-bottom: .5rem;
		}
		h4 {
			margin: 0 0 1rem;
		}
		.header, .footer {
			grid-column: 1 / -1;
			/* needed for the floated layout */
			clear: both;
		}

		input.wide {
			width: 77%;
			line-height: 2;
		}
/*      input:not(.button-primary),
		input:not(input[type=checkbox]) {
			width: 77%;
			line-height: 2;
		}*/
		
		/**
		 * We need to set the widths used on floated items back to auto, and remove the bottom margin as when we have grid we have gaps.
		 * @param  {[type]} display: grid          [description]
		 * @return {[type]}          [description]
		 */
		@supports (display: grid) {
			.grid-wrapper > * {
				width: auto;
				margin: 0;
			}
		}
	</style>
	<?php
	if ( isset( $_GET['updated'] ) && 'true' === esc_attr( $_GET['updated'] ) ) {
		echo '<div class="updated" ><p>' . __( 'Settings updated.', 'diagnostic-dashboard' ) . '</p></div>';
	}

	if ( isset( $_GET['tab'] ) ) {
		diagnostic_dashboard_admin_tabs( $_GET['tab'] );
	} else {
		diagnostic_dashboard_admin_tabs( 'front_tab' );
	}
	?>

	<div id="poststuff">
			<form method="post" action="<?php admin_url( 'index.php?page=diagnostic-dashboard-settings.php' ); ?>">
		<div class="grid-wrapper">
			<header class="header"><?php echo __( 'The header area', 'diagnostic-dashboard' ); ?> | <?php echo ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'front_tab' ); ?></header>
				<?php
				wp_nonce_field( 'diagnostic-dashboard-settings-page' );

				if ( $pagenow == 'index.php' && 'diagnostic-dashboard-settings.php' === $_GET['page'] ) {
					if ( isset( $_GET['tab'] ) ) {
						$tab = $_GET['tab'];
					} else {
						$tab = 'textarea';
					}

					echo '<table class="form-table">';
					switch ( $tab ) {
						case 'checkbox':
							?>
						<aside class="sidebar"><?php echo __( 'Sidebar', 'diagnostic-dashboard' ); ?></aside>
						<article class="content">
							<h4>
								<label for="diagnostic_dashboard_textarea">
								<?php echo __( 'Checkbox Settings', 'diagnostic-dashboard' ); ?>
								</label>
							</h4>
							<p>
								<input id="diagnostic_dashboard_tag_class" name="diagnostic_dashboard_tag_class" type="checkbox" 
								<?php
								if ( $settings['diagnostic_dashboard_tag_class'] ) {
									echo 'checked="checked"';
								}
								?>
									value="true" /> 
									<span class="description">Output each post tag with a specific CSS class using its slug.</span>
								</p>
							</article>
							<?php
							break;
						case 'text_input':
							?>
							<aside class="sidebar"><?php echo __( 'Sidebar', 'diagnostic-dashboard' ); ?></aside>                       
							<article class="content">
								<h4><label for="diagnostic_dashboard_text">Text Input settings</label></h4>
								<p>
									<input class="wide" placeholder="diagnostic_dashboard_text" id="diagnostic_dashboard_text" name="diagnostic_dashboard_text" value="<?php echo esc_html( stripslashes( $settings['diagnostic_dashboard_text'] ) ); ?>" /><br>
									<span class="description">Enter your Google tracking code:</span>
								</p>
							</article>
							<?php
							break;
						case 'textarea':
							?>
							<aside class="sidebar"><?php echo __( 'Sidebar', 'diagnostic-dashboard' ); ?></aside>
							<article class="content">
								<h4><label for="diagnostic_dashboard_text">Textarea settings</label></h4>
								<p>
									<textarea id="diagnostic_dashboard_textarea" name="diagnostic_dashboard_textarea" cols="60" rows="5" ><?php echo esc_html( stripslashes( $settings['diagnostic_dashboard_textarea'] ) ); ?></textarea><br/>
									<span class="description">Enter the introductory text for the home page:</span>
								</p>
							</article>
							<?php
							break;
						case 'front_tab':
							?>
							<aside class="sidebar"><?php echo __( 'Sidebar', 'diagnostic-dashboard' ); ?></aside>                       
							<article class="content">
								<h4>
									<label for="diagnostic_dashboard_textarea">
										<?php echo __( 'Current Settings', 'diagnostic-dashboard' ); ?>
									</label>
								</h4>
								<p>
									<?php
										$saved_settings = get_option( 'diagnostic_dashboard_tabbed_settings' );
										echo '<pre>$saved_settings ';
										print_r( $saved_settings );
										echo '</pre>';
									?>
								</p>
							</article>
							<?php
							break;
					}
						echo '</table>';
				}
				?>
					<footer class="footer"><?php echo __( 'The Footer Area', 'diagnostic-dashboard' ); ?>
						<?php if ( isset( $_GET['tab'] ) && 'front_tab' !== $_GET['tab'] ) { ?>
						<p class="submit" style="clear: both;">
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="diagnostic-dashboard-settings-submit" value="Y" />
						</p>
						<p>
							<?php
								$saved_settings = get_option( 'diagnostic_dashboard_tabbed_settings' );
								echo '<pre>$saved_settings ';
								print_r( $saved_settings );
								echo '</pre>';
							?>
						</p>
						<?php } ?>
					</footer>
				</div>
			</form>
		</div>
	</div>
	<?php
}
