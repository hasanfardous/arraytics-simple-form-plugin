<?php

// Initializing form shortcode
add_action( 'init', 'asfp_form_shortcode_callback' );
 
// Form Shortcode
function asfp_form_shortcode_callback() {
    add_shortcode( 'arraytics-simple-form', 'asfp_form_markup' );
}

// Form Markup
function asfp_form_markup() {
	ob_start();
	?>
	<div class="asfp-form-wrapper">
		<form method="post" class="asfp-form-area">
			<?php wp_nonce_field( 'asfp_form_nonce' );?>
			<div class="asfp-form-inner">
				<div class="single-entry">
					<label for="asfp-amount"><?php _e( 'Amount', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="number" name="asfp-amount" id="asfp-amount">
				</div>
				<div class="single-entry">
					<label for="asfp-buyer"><?php _e( 'Buyer', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="text" name="asfp-buyer" id="asfp-buyer">
				</div>
				<div class="single-entry">
					<label for="asfp-receipt-id"><?php _e( 'Receipt Id', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="text" name="asfp-receipt-id" id="asfp-receipt-id">
				</div>
				<div class="single-entry">
					<label for="asfp-items"><?php _e( 'Items', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="text" name="asfp-items" id="asfp-items">
				</div>
				<div class="single-entry">
					<label for="asfp-buyer-email"><?php _e( 'Email', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="email" name="asfp-buyer-email" id="asfp-buyer-email">
				</div>
				<div class="single-entry">
					<label for="asfp-city"><?php _e( 'City', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="text" name="asfp-city" id="asfp-city">
				</div>
				<div class="single-entry">
					<label for="asfp-phone"><?php _e( 'Phone', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="text" name="asfp-phone" id="asfp-phone">
				</div>
				<div class="single-entry">
					<label for="asfp-entry-by"><?php _e( 'Entry By', 'arraytics-simple-form-plugin' ); ?></label>
					<input type="number" name="asfp-entry-by" id="asfp-entry-by">
				</div>
				<div class="single-entry asfp-note-entry">
					<label for="asfp-note"><?php _e( 'Note', 'arraytics-simple-form-plugin' ); ?></label>
					<textarea name="asfp-note" id="asfp-note"></textarea>
				</div>
				<div class="single-entry submitBtn">
					<input type="submit" name="submitBtn" id="submitBtn" value="<?php echo esc_attr('Submit Entry')?>">
				</div>
				<div class="asfp-confirmation-message"></div>
			</div>
		</form>
	</div>
	<?php
	$html = ob_get_clean();
	return $html;
}