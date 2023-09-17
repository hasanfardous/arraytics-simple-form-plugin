<?php

// Initializing form shortcode
add_action( 'init', 'asfp_report_page_shortcode_callback' );

// Function to restrict access to the Reports page for non-Editor users
function asfp_restricted_reports_page_access() {
    // Check if the user is logged in
    if (is_user_logged_in()) {
        // Get the current user
        $current_user = wp_get_current_user();
        
		// Define an array of roles that can access the Reports page
		$allowed_roles = array('editor', 'administrator'); // Add more roles if needed
				
		// Check if the user has one of the allowed roles
		if (array_intersect($current_user->roles, $allowed_roles)) {
			// User has an allowed role, allow access to the Reports page
			return true;
		}
    }
}

 
// Form Shortcode
function asfp_report_page_shortcode_callback() {
    add_shortcode( 'arraytics-report-page', 'asfp_report_page_markup' );
}

// Report Page Markup
function asfp_report_page_markup() {
	ob_start();
	?>
	<div class="asfp-report-page-wrapper">
		<?php
			if ( asfp_restricted_reports_page_access() ) {
				// Get the report table
				require ARRAYTICS_PLUGIN_INC_DIR . 'report-table.php';
			} else {
				?>
				<h1><?php _e( 'Sorry, You are not authorised!', 'arraytics-simple-form-plugin' )?></h1>
				<?php
			}
		?>
	</div>
	<?php
	$html = ob_get_clean();
	return $html;
}