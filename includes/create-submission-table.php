<?php
// Create the DB table to store user data
if ( ! function_exists( 'asfp_create_db_table' ) ) {
	function asfp_create_db_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}asfp_report_tbl` (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		amount int(10) NOT NULL,
		buyer varchar(255) NOT NULL,
		receipt_id varchar(20) NOT NULL,
		items varchar(255) NOT NULL,
		buyer_email varchar(50) NOT NULL,
		buyer_ip varchar(20) NOT NULL,
		note text NOT NULL,
		city varchar(20) NOT NULL,
		phone varchar(20) NOT NULL,
		hash_key varchar(255) NOT NULL,
		entry_at date DEFAULT '0000-00-00' NOT NULL,
		entry_by int(10) NOT NULL,
		PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
	}
}