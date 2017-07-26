<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class dmly_user_profile_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'dmly_user_profile', 

		// Widget name will appear in UI
		__('deemly user profile', 'dmly'), 

		// Widget description
		array( 'description' => __( 'This widget will display the users deemly profile', 'dmly' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title']; 
		if( is_single() ){
			$user_id = get_the_author_meta('id');
			dmly_show_user_score_widget_large( $user_id );
		}
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) { ?>
	<p>Shows the deemly user profile based on post author.</p>
	<?php 
	}
} // Class dmly_user_profile_widget ends here

// Register and load the widget
function dmly_load_user_profile_widget() {
	register_widget( 'dmly_user_profile_widget' );
}
add_action( 'widgets_init', 'dmly_load_user_profile_widget' );