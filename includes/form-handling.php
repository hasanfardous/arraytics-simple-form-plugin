<?php
// WP_Ajax Action
add_action('wp_ajax_asfp_form', 'asfp_applicant_form_datas');
add_action('wp_ajax_nopriv_asfp_form', 'asfp_applicant_form_datas');

// Get user IP Addreess
function asfp_get_user_IP() {
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		//ip pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

// Applicant form data handling
if ( ! function_exists( 'asfp_applicant_form_datas' ) ) {
	function asfp_applicant_form_datas() {
		// Check the nonce first
		check_ajax_referer( 'asfp_form_nonce', 'nonce' );
		
		// Catch our datas and sanitize them
		$asfp_amount		= isset( $_POST['asfp_amount'] ) ? (int) $_POST['asfp_amount'] : '';
		$asfp_buyer			= isset( $_POST['asfp_buyer'] ) ? sanitize_text_field( $_POST['asfp_buyer'] ) : '';
		$asfp_receipt_id 	= isset( $_POST['asfp_receipt_id'] ) ? sanitize_text_field ($_POST['asfp_receipt_id']) : '';
		$asfp_items			= isset( $_POST['asfp_items'] ) ? sanitize_text_field( $_POST['asfp_items'] ) : '';
		$asfp_buyer_email	= isset( $_POST['asfp_buyer_email'] ) ? sanitize_email( $_POST['asfp_buyer_email'] ) : '';
		$asfp_city			= isset( $_POST['asfp_city'] ) ? sanitize_text_field( $_POST['asfp_city'] ) : '';
		$asfp_phone			= isset( $_POST['asfp_phone'] ) ? sanitize_text_field( $_POST['asfp_phone'] ) : '';
		$asfp_entry_by		= isset( $_POST['asfp_entry_by'] ) ? (int) $_POST['asfp_entry_by'] : '';
		$asfp_note			= isset( $_POST['asfp_note'] ) ? sanitize_text_field( $_POST['asfp_note'] ) : '';
		$response 	 		= [];

		// Error handling then storing data
		if ( $asfp_amount == '' || $asfp_buyer == '' || $asfp_receipt_id == '' || $asfp_items == '' || $asfp_buyer_email == '' || $asfp_city == '' || $asfp_phone == '' || $asfp_entry_by == '' || $asfp_note == '' ) {
			$response['response'] 	= 'error';
			$response['message']  	= __( 'Sorry, Empty field not allowed!', 'arraytics-simple-form-plugin' );
		} else {
			// Setting Default Timezone 
			date_default_timezone_set('Asia/Dhaka');
			$asfp_submission_date 	= date("Y-m-d");
			$asfp_user_ip 			= asfp_get_user_IP();
			$asfp_hash_key 			= hash('sha512', $asfp_receipt_id);

			// Inserting to DB
			global $wpdb;
			$table_name = $wpdb->base_prefix.'asfp_report_tbl';
			$submission_insert = $wpdb->insert( 
				$table_name, 
				array( 
					'amount' 		=> $asfp_amount, 
					'buyer' 		=> $asfp_buyer, 
					'receipt_id' 	=> $asfp_receipt_id, 
					'items' 		=> $asfp_items, 
					'buyer_email'	=> $asfp_buyer_email, 
					'buyer_ip' 		=> $asfp_user_ip, 
					'note' 			=> $asfp_note, 
					'city' 			=> $asfp_city,
					'phone' 		=> $asfp_phone, 
					'hash_key' 		=> $asfp_hash_key, 
					'entry_at'		=> $asfp_submission_date, 
					'entry_by' 		=> $asfp_entry_by,
				), 
				array( 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
					'%s', 
				) 
			);

			if ( $submission_insert ) {
				$response['response'] = 'success';
				$response['message'] = __( 'Success! Your Submission has been received.', 'arraytics-simple-form-plugin' );
			} else {
				$response['response'] = 'error';
				$response['message'] = __( 'Sorry! Something went wrong, please try again.', 'arraytics-simple-form-plugin' );
			}
		}
		
		// Return response
		echo json_encode( $response );
		exit();
	}
}