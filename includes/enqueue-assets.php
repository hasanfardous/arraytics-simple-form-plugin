<?php
// Enqueue Front-end scripts
add_action( 'wp_enqueue_scripts', 'asfp_enqueue_scripts', 99 );
function asfp_enqueue_scripts() {
	wp_enqueue_style( 'asfp-styles', ARRAYTICS_PLUGIN_ASSETS_URL . 'css/styles.css' );
	wp_enqueue_script( 'asfp-cookie', ARRAYTICS_PLUGIN_ASSETS_URL . 'js/js.cookie.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'asfp-script', ARRAYTICS_PLUGIN_ASSETS_URL . 'js/asaf-scripts.js', array( 'jquery' ), '1.0', true );
	wp_localize_script(
		'asfp-script', 
		'asfp_data_obj', 
		array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		) 
	);
}