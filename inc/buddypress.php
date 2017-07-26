<?php

/********************************
BuddyPress
********************************/

// Add the deemly widget to member page
$dmly_bp_options_members_page = get_option( 'dmly_display_bp_members_page' );
if( $dmly_bp_options_members_page['dmly_display_bp_members_page'] ){
	add_action( 'bp_profile_header_meta', 'dmly_bp_header_display_deemly_score' );
	function dmly_bp_header_display_deemly_score(){	
	   	$user_id = bp_displayed_user_id();
		dmly_show_user_score_widget( $user_id );
	}
}

// Add deemly to activity feed
$dmly_bp_options_activity_feed = (array)get_option( 'dmly_display_bp_activity_feed' );
if( $dmly_bp_options_activity_feed['dmly_display_bp_activity_feed'] ){
	function dmly_show_widget_in_activity_feed( $action, $activity, $r) {
		$user_id = bp_get_activity_user_id();
		$dmly_widget = dmly_show_user_score_widget( $user_id );

	   return $action;
	}
	add_filter( 'bp_get_activity_action_pre_meta', 'dmly_show_widget_in_activity_feed', 1, 3 );
}

function dmly_display_bp_member_list(){
	$user_id = bp_get_member_user_id();
	dmly_show_user_score_widget( $user_id );
}

add_filter ( 'bp_directory_members_item', 'dmly_display_bp_member_list' ); 
