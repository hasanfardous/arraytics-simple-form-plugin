<?php

if ( ! class_exists( "WP_List_Table" ) ) {
    require_once( ABSPATH . "wp-admin/includes/class-wp-list-table.php" );
}

class ASAF_All_Reports extends WP_List_Table {
    function __construct( $data ) {
        parent::__construct();
        $this->items = $data;
    }   
    
    function get_columns() {
        return [
            'cb'            => '<input type="checkbox">',
            'buyer'         => __( 'Buyer', 'arraytics-simple-form-plugin' ),
            'amount'        => __( 'Amount', 'arraytics-simple-form-plugin' ),
            'receipt_id'    => __( 'Receipt Id', 'arraytics-simple-form-plugin' ),
            'items'         => __( 'Items', 'arraytics-simple-form-plugin' ),
            'buyer_email'   => __( 'Email', 'arraytics-simple-form-plugin' ),
            'buyer_ip'      => __( 'Buyer IP', 'arraytics-simple-form-plugin' ),
            // 'note'          => __( 'Note', 'arraytics-simple-form-plugin' ),
            'city'          => __( 'City', 'arraytics-simple-form-plugin' ),
            'phone'         => __( 'Mobile', 'arraytics-simple-form-plugin' ),
            // 'hash_key'      => __( 'Hash Key', 'arraytics-simple-form-plugin' ),
            'entry_at'      => __( 'Entry At', 'arraytics-simple-form-plugin' ),
            // 'entry_by'      => __( 'Entry By', 'arraytics-simple-form-plugin' ),
        ];
    }

    function column_cb( $item ) {
        $item_id = $item['id'];
        return "<input type='checkbox' value='{$item_id}'>";
    }

    function column_buyer( $item ) {
        $item_id    = $item['id'];
        $buyer      = $item['buyer'];
        $nonce      = wp_create_nonce( 'asaf_delete_submission' );
        $actions    = [
            'delete' => sprintf( "<a href='?page=asaf_all_reports&id=%s&action=%s&nonce=%s' onclick='return confirm(\"Do you really want to delete the record?\")'>%s</a>", $item_id, 'delete', $nonce, __( 'Delete', 'arraytics-simple-form-plugin' ) )
        ];
        return sprintf( "%s %s", $buyer, $this->row_actions( $actions ) );
    }

    function get_shortable_columns() {
        return [
            'id' => [ 'id', true ]
        ];
    }
    
    function column_default( $item, $column_name ) {
        return $item[$column_name];
    }
    
    function prepare_items() {
        $this->_column_headers = array( $this->get_columns(), [], $this->get_shortable_columns() );
    }
}