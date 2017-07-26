<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// [deemlyuser iserid"" deemlyid=""]
function dmly_shortcode_show_user_widget( $atts, $content = null ) {
	$a = shortcode_atts( array(
			'userid'   => '',
			'deemlyid' => ''
		),
		$atts
	);
    ob_start();
    $userid   = $a['userid'];
    $deemlyid = $a['deemlyid'];
	
	if( $userid != ''){
		dmly_show_user_score_widget_large( $userid );
	}else{
		dmly_show_deemly_user_score_widget_large( $deemlyid );
	}

	return ob_get_clean();
}
add_shortcode( 'deemlyuser', 'dmly_shortcode_show_user_widget' );