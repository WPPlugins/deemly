<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class dmly_user_ratings_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'dmly_user_profile_ratings', 

		// Widget name will appear in UI
		__('deemly user ratings', 'dmly'), 

		// Widget description
		array( 'description' => __( 'This widget will display the users ratings and reviews', 'dmly' ), ) 
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
			echo '<h3>' . __('Other users say', 'dmly') . '</h3>';
			dmly_show_user_reviews( get_the_author_meta( 'ID') );			
		}
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) { ?>
	<p>List the authors ratings and reviews</p>
	<?php 
	}
} // Class dmly_user_ratings_widget ends here

// Register and load the widget
function dmly_load_user_ratings_widget() {
	register_widget( 'dmly_user_ratings_widget' );
}
add_action( 'widgets_init', 'dmly_load_user_ratings_widget' );