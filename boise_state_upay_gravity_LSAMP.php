<?php
/*
Plugin Name: Boise State uPay Gravity Forms Extension for LSAMP
Description: Provides functions for use in uPay implementation for LSAMP.
Version: 2.0.4
Author: David Lentz, David Ferro
*/

defined( 'ABSPATH' ) or die( 'No hackers' );

if( ! class_exists( 'Boise_State_uPay_GF_LSAMP_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

$updater = new Boise_State_uPay_GF_LSAMP_Updater( __FILE__ );
$updater->set_username( 'OITWPsupport' );
$updater->set_repository( 'boise-state-uPay-Gravity-Forms-Extension-for-LSAMP' );
$updater->initialize();

	// This is triggered when the shortcode 'UPAYFORM' is added to a page in WordPress.
	// Writes a form full of hidden fields and auto-submits it (via javascript).
	// If javascript isn't available, displays the form in the browser with a submit 
	// button so the user can click to continue.
	function createForm_LSAMP( $atts ) {
	
		// Parse the parameters sent in the shortcode (if any). Allows us to set values 
		// in WordPress rather than here in the code.
		$attributes = shortcode_atts( array(
			'upay_site_id' => -1, 
			'passed_amount_validation_key' => '', 
			'upay_url' => 'https://secure.touchnet.com/C20444_upay/web/index.jsp'
		), $atts );

		// Need to calculate amount based on what was submitted. This may change 
		// with each implementation.
		// CHANGE: the name of the element in the $_GET array will changed depending on 
		// how the GravityForm was created. Look there for the correct field ID and change
		// here as necessary.
		$amt = 0;
		if ($_GET['CC']=='checked'){
			$amt += 200;
		}
		if ($_GET['ACN']=='checked'){
			$amt += 20;
		}

		$EXT_TRANS_ID = createEXT_TRANS_ID();
		$VALIDATION_KEY = createValidationKey( $attributes[ 'passed_amount_validation_key' ], $EXT_TRANS_ID, $amt );

		$formString = '<form id="upay" name="upay" action="' . $attributes[ 'upay_url' ] . '" method="post">';
		$formString .= '<input type="hidden" name="UPAY_SITE_ID" VALUE="' . $attributes[ 'upay_site_id' ] . '" />';
		$formString .= '<input type="hidden" name="EXT_TRANS_ID" VALUE="'. $EXT_TRANS_ID .'" />';
		$formString .= '<input type="hidden" name="AMT" VALUE="'. $amt .'" />';
		$formString .= '<input type="hidden" name="VALIDATION_KEY" VALUE="'. $VALIDATION_KEY .'" />';
		$formString .= '<input type="submit" value="Click here to continue" />';
		$formString .= '</form>';
		$formString .= 'One moment please...';
		
		// Form will auto-submit. User should never see it, but will be forwarded to upay 
		// with all the data they've already posted.
//		$formString .= '<script type="text/javascript">document.forms["upay"].submit();</script>';
		
		echo $formString;

	}
	
	// This makes the shortcode available to WP users. When they put that string on a page, 
	// the form defined in createForm_LSAMP() appears there.
	add_shortcode('UPAYFORM', 'createForm_LSAMP');

	// Creates a transaction ID for use by upay. We'll store this value on our side AND 
	// post it to uPay.
	function createEXT_TRANS_ID () {
		// This value is not guaranteed to be unique, but is very very unlikely to be 
		// duplicated:
		$EXT_TRANS_ID = date('mdHis') . mt_rand();
		return $EXT_TRANS_ID;
	}
	
	// Populates hidden field in the GravityForm. This'll be the same value as we populate
	// in the EXT_TRANS_ID hidden field we submit to uPay. uPay will post this back upon 
	// successful payment so we can update the record on our side to show as PAID.
	function bsu_populate_transid($value){
		return createEXT_TRANS_ID();
	}

	// This hook is how we get the value created in createEXT_TRANS_ID into the "transid" 
	// field of the gravity form. (Note the string pattern gform_field_value_FIELDNAME.)
	// See https://www.gravityhelp.com/documentation/article/allow-field-to-be-populated-dynamically/
	add_filter('gform_field_value_transid', 'bsu_populate_transid');
	
	function createValidationKey ( $Passed_Amount_Validation_Key, $EXT_TRANS_ID, $amt ) {
		// $Passed_Amount_Validation_Key holds the "Passed Amount Validation Key" discussed in the Touchnet User's Guide. 
		// This value needs to be created (a unique alphanumeric string 30 characters or less).
		// Whatever value for $var is added here must be entered in uPay Site's Payment Settings page, 
		// "Passed Amount Validation Key" field.

		$VALIDATION_KEY = base64_encode(pack('H*',md5($Passed_Amount_Validation_Key.$EXT_TRANS_ID.$amt)));
		return $VALIDATION_KEY;
	}
	

?>
