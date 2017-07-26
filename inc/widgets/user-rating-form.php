<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class dmly_user_rating_form_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'dmly_user_rating_form', 

		// Widget name will appear in UI
		__('deemly user rating form', 'dmly'), 

		// Widget description
		array( 'description' => __( 'This widget will display the form for submitting a rating and review', 'dmly' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title']; 
		if( is_single() ){
			echo '<h3>' . __('Submit a review', 'dmly') . '</h3>';
			dmly_post_review_form( get_the_author_meta( 'ID' ), get_current_user_id() );
		}
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) { ?>
	<p>Shows the form</p>
	<?php 
	}
} // Class dmly_user_rating_form_widget ends here

// Register and load the widget
function dmly_load_user_rating_form_widget() {
	register_widget( 'dmly_user_rating_form_widget' );
}
add_action( 'widgets_init', 'dmly_load_user_rating_form_widget' );