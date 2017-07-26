<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Get an option
 *
 * Looks to see if the specified setting exists, returns default if not
 *
 * @since 0.1
 * @return mixed
 */

function dmly_get_option( $key = '', $default = false ) {
	global $dmly_options;
	$value = ! empty( $dmly_options[ $key ] ) ? $dmly_options[ $key ] : $default;
	$value = apply_filters( 'dmly_get_option', $value, $key, $default );
	return apply_filters( 'dmly_get_option_' . $key, $value, $key, $default );
}

/**
 * Get Settings
 *
 * Retrieves all plugin settings
 *
 * @since 1.0
 * @return array dmly settings
 */
function dmly_get_settings() {

	$settings = get_option( 'dmly_settings' );
	if( empty( $settings ) ) {
		// Update old settings with new single option
		$general_settings = is_array( get_option( 'dmly_settings_general' ) )    ? get_option( 'dmly_settings_general' ) : array();
		$email_settings = is_array( get_option( 'dmly_settings_email' ) )   ? get_option( 'dmly_settings_email' ) 	: array();
		
		$settings = array_merge( $general_settings, $email_settings);

		update_option( 'dmly_settings', $settings );

	}	
	return $settings;
}


function dmly_settings() {
	  // Let's introduce a section to be rendered on the new options page
	  add_settings_section(
	    'dmly_settings',   		// The ID to use for this section in attribute tags
	    __('deemly API settings','demly'), 	// The title of the section rendered to the screen
	    'dmly_options_display',   			// The function used to render the options for this section
	    'deemly-settings'              		// The ID of the page on which this section is rendered
	  );

	  add_settings_field( 
	    'dmly_site_app_key',               // The ID (or the name) of the field
	    __('deemly site APP key','dmly'),  // The text used to label the field
	    'render_dmly_site_app_key',        // The callback function used to render the field
	    'deemly-settings',                 // The page on which we'll be rendering this field
	    'dmly_settings'         // The section to which we're adding the setting
	  );
	  register_setting(
	    'dmly_settings',         // The name of the group of settings
	    'dmly_site_app_key'                 // The name of the actual option (or setting)
	  );

	  add_settings_field( 
	    'dmly_site_secret_key',               // The ID (or the name) of the field
	    __('deemly site secret key','dmly'),  // The text used to label the field
	    'render_dmly_site_secret_key',        // The callback function used to render the field
	    'deemly-settings',                 	// The page on which we'll be rendering this field
	    'dmly_settings'         				// The section to which we're adding the setting
	  );
	  register_setting(
	    'dmly_settings',         // The name of the group of settings
	    'dmly_site_secret_key'                 // The name of the actual option (or setting)
	  );

	  add_settings_section(
	    'dmly_settings',   				// The ID to use for this section in attribute tags
	    __('BuddyPress settings','dmly'), 	// The title of the section rendered to the screen
	    'dmly_bp_options_display',   		// The function used to render the options for this section
	    'deemly-settings'              		// The ID of the page on which this section is rendered
	  );

	  add_settings_field( 
	    'dmly_display_bp_members_page',               	// The ID (or the name) of the field
	    __('Show the deemly widget on the BuddyPress member page','dmly'),  // The text used to label the field
	    'render_dmly_display_bp_members_page',        	// The callback function used to render the field
	    'deemly-settings',                 				// The page on which we'll be rendering this field
	    'dmly_settings'  							// The section to which we're adding the setting
	  );
	  register_setting(
	    'dmly_settings',         					// The name of the group of settings
	    'dmly_display_bp_members_page'          		// The name of the actual option (or setting)
	  );

	  add_settings_field( 
	    'dmly_display_bp_activity_feed',               	// The ID (or the name) of the field
	    __('Show the deemly widget in the BuddyPress activity feed','dmly'),  // The text used to label the field
	    'render_dmly_display_bp_activity_feed',        	// The callback function used to render the field
	    'deemly-settings',                 				// The page on which we'll be rendering this field
	    'dmly_settings'         						// The section to which we're adding the setting
	  );
	  register_setting(
	    'dmly_settings',         					// The name of the group of settings
	    'dmly_display_bp_activity_feed'          		// The name of the actual option (or setting)
	  );
}

add_action( 'admin_init', 'dmly_settings' );

function render_dmly_site_app_key(){
	// Read the options for the button image link
	$options = (array)get_option( 'dmly_site_app_key' );
	$dmly_app_key = $options['dmly_site_app_key'];
	echo '<input type="text" name="dmly_site_app_key[dmly_site_app_key]" id="dmly_site_app_key[value]" value="' . $dmly_app_key . '" class="regular-text" />'; 
}

function render_dmly_site_secret_key(){
	// Read the options for the button image link
	$options = (array)get_option( 'dmly_site_secret_key' );
	$dmly_secret_key = $options['dmly_site_secret_key'];
	echo '<input type="text" name="dmly_site_secret_key[dmly_site_secret_key]" id="dmly_site_secret_key[value]" value="' . $dmly_secret_key . '" class="regular-text" />'; 
}

function render_dmly_display_bp_members_page(){
	$options = get_option( 'dmly_display_bp_members_page' );
    echo '<input type="checkbox" id="dmly_display_bp_members_page" name="dmly_display_bp_members_page[dmly_display_bp_members_page]" value="1"' . checked( 1, $options['dmly_display_bp_members_page'], false ) . '/>';
}

function render_dmly_display_bp_activity_feed(){
	$options = get_option( 'dmly_display_bp_activity_feed' );
    echo '<input type="checkbox" id="dmly_display_bp_activity_feed" name="dmly_display_bp_activity_feed[dmly_display_bp_activity_feed]" value="1"' . checked( 1, $options['dmly_display_bp_activity_feed'], false ) . '/>';
}

function dmly_options_display(){
	echo '<p>'.__('Please enter your deemly app settings. You can find your keys under the settings page on each site.','dmly').'</p>';
}

function dmly_bp_options_display(){
	echo '<p>'.__('Settings for BuddyPress.','dmly').'</p>';
}