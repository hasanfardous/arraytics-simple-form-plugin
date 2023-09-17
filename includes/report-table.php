<?php
    global $wpdb;
    $table_name = "{$wpdb->base_prefix}asfp_report_tbl";
    $all_reports = $wpdb->get_results( "SELECT * FROM {$table_name}", ARRAY_A );
?>
<table class="la-abandoned-cart-table">
    <tr>
        <th scope="row"><?php _e( 'ID', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'Buyer', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'Amount', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'Receipt Id', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'Email', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'IP', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'Phone', 'arraytics-simple-form-plugin' ); ?></th>
        <th scope="row"><?php _e( 'Entry At', 'arraytics-simple-form-plugin' ); ?></th>
    </tr>
    <?php
        foreach ( $all_reports as $single_item ) {
        ?>
        <tr>
            <td>
                <?php echo esc_html($single_item['id']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['buyer']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['amount']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['receipt_id']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['buyer_email']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['buyer_ip']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['phone']);?>
            </td>
            <td>
                <?php echo esc_html($single_item['entry_at']);?>
            </td>
        </tr>
        <?php
        }
    ?>
</table>