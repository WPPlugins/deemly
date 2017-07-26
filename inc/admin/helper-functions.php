<?php
// Function to update the stored rating categories
function dmly_update_ratings_categories(){
	$option_name = 'dmly_rating_categories';
	$new_value = json_decode( getdeemlyratingcategories() );
	$new_value = $new_value->responseData;

	if ( get_option( $option_name ) !== false ) {

	    // The option already exists, so we just update it.
	    update_option( $option_name, $new_value );

	} else {

	    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
	    $deprecated = null;
	    $autoload = 'no';
	    add_option( $option_name, $new_value, $deprecated, $autoload );
	}
}