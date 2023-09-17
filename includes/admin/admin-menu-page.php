<?php

// Admin menu page
add_action( 'admin_menu', 'asaf_adding_admin_menu_page' );
if ( ! function_exists( 'asaf_adding_admin_menu_page' ) ) {
	function asaf_adding_admin_menu_page() {
		add_menu_page(
			__( 'All Reports', 'arraytics-simple-form-plugin' ),
			__( 'All Reports', 'arraytics-simple-form-plugin' ),
			'manage_options',
			'asaf_all_reports',
			'asaf_all_submissions_page_callback',
			'dashicons-portfolio',
			6
		);
	}
}

// Admin notice function
if ( ! function_exists( 'asaf_show_admin_notice' ) ) {
	function asaf_show_admin_notice( $message, $type )  {
		echo "
			<div class='notice notice-{$type} is-dismissible'>
				<p>" . __("{$message}", 'arraytics-simple-form-plugin') . "</p>
			</div>
		";
	}
}

// All submissioins page callback function
if ( ! function_exists( 'asaf_all_submissions_page_callback' ) ) {
	function asaf_all_submissions_page_callback() {
		?>
		<div class="asaf-submissions-wrapper">
			<div class="asaf-section-header">
				<h1><?php _e( 'All Submissions', 'arraytics-simple-form-plugin' ); ?></h1>
			</div>
			<div class="asaf-section-content">
				<?php
					global $wpdb;

					// Delete a submission
					if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' ) {
						if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'asaf_delete_submission' ) ) {
							asaf_show_admin_notice( 'Sorry! You are not Authorized!', 'error' );
						} else {
							// Delete query
							$delete_id = absint( $_GET['id'] );
							$wpdb->delete( "{$wpdb->base_prefix}asfp_report_tbl", [ 'id' => $delete_id ] );
							asaf_show_admin_notice( 'Success! The item has been deleted.', 'success' );
						}
					}

					// Search function
					if ( ! function_exists( 'asaf_search_filter' ) ) {
						function asaf_search_filter( $item ){
							$buyer_email	= strtolower($item['buyer_email']);
							$phone  		= strtolower($item['phone']);
							$search_query 	= sanitize_text_field($_REQUEST['s']);
							if ( strpos( $buyer_email, $search_query ) !== false || strpos( $phone, $search_query ) !== false ) {
								return true;
							} else {
								return false;
							}
						}
					}

					// Display all submissions
					$all_submissions = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}asfp_report_tbl", ARRAY_A );

					// When searched
					if ( isset( $_REQUEST['s'] ) ) {
						$all_submissions = array_filter( $all_submissions, 'asaf_search_filter' );
					}

					// When sorting
					if ( isset( $_REQUEST['order'] ) ) {
						$orderby = sanitize_key($_REQUEST['orderby']) ?? '';
						$order   = sanitize_key($_REQUEST['order']) ?? '';
						if ( 'id' == $orderby ) {
							if ( 'asc' == $order ) {
								usort( $all_submissions, function( $item1, $item2 ){
									return $item1['id'] <=> $item2['id'];
								});
							} else {
								usort( $all_submissions, function( $item1, $item2 ){
									return $item2['id'] <=> $item1['id'];
								});
							}
						}
					}
					$table = new ASAF_All_Reports( $all_submissions );
					$table->prepare_items();
				?>

				<div class="wrap">
					<form method="GET">
						<?php
							$table->search_box( 'Search', 'search_id' );
							$table->display();
						?>
						<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']);?>">
					</form>
				</div>
			</div>
		</div>

		<?php
	}
}