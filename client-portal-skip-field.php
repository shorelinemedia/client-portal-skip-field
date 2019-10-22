<?php
/*
Plugin Name: Client Portal Skip Form Conversions
Plugin URI: https://github.com/shorelinemedia/client-portal-skip-field
Description: This plugin adds a hidden input field <code>&lt;input type=&quot;hidden&quot; name=&quot;is_skip&quot; id=&quot;is_skip&quot; value=&quot;true&quot;&gt;</code> to Wordpress forms that aren't true conversions, to skip sending lead data to the client portal. <a href="https://" target="_blank" rel="noopener">View the README on Github</a>
Author: Shoreline Media
Version: 1.0
Author URI: https://shoreline.media
GitHub Plugin URI: https://github.com/shorelinemedia/client-portal-skip-field
*/


/**
 * Return skip field for Client Portal Forms to skip tracking a form as a conversion
 */
function sl9_get_client_portal_skip_field() {
	return apply_filters( 'sl9_skip_field_input', '<input type="hidden" name="is_skip" id="is_skip" value="true">' );
}

/**
 * Ignore Search Forms for Client Portal Form Tracking
 *
 * Should work with most filters applied to form HTML like the search form
 */

function sl9_client_portal_filter_hidden_skip_field( $form ) {
	// Add a hidden field befor the submit button
	$hidden_field = sl9_get_client_portal_skip_field();
  $pattern = apply_filters( 'sl9_skip_field_pattern', '/((?:<(?:input|button) type="submit")|\[slp_search_element button="submit")/i' );
  // Regex expression test: https://regex101.com/r/3KdT1v/2
	return preg_replace( $pattern, $hidden_field . "\n" . '$1', $form );
}
// Main Wordpress search form
add_filter( 'get_search_form', 'sl9_client_portal_filter_hidden_skip_field' );
// Store locator location search form
add_filter( 'slp_searchlayout', 'sl9_client_portal_filter_hidden_skip_field' );

/**
 * Add hidden 'is_skip' input through hooks
 */

function sl9_client_portal_insert_hidden_skip_field() {
	echo sl9_get_client_portal_skip_field();
}
// Add to single product cart form
add_action( 'woocommerce_after_add_to_cart_button', 'sl9_client_portal_insert_hidden_skip_field' );
// Add to the cart form
add_action( 'woocommerce_cart_actions', 'sl9_client_portal_insert_hidden_skip_field' );
// Add to GEO MY WP search forms
add_action( 'gmw_search_form_end', 'sl9_client_portal_insert_hidden_skip_field' );
// Add to KLEO login modal
add_action( 'fb_popup_button', 'sl9_client_portal_insert_hidden_skip_field' );
// Add to KLEO register modal
add_action( 'fb_popup_register_button', 'sl9_client_portal_insert_hidden_skip_field' );
