<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * deemly score widget
 *
 * Displays the deemly score widget for a user with a deemly profile
 *
 * @since 0.1
 * @return mixed
 */

function dmly_show_user_score_widget( $user_id ) {
	// Get the users deemly ID
	$dmly_current_user_deemly_id = get_user_meta( $user_id, 'dmly_user_deemly_id', TRUE ); 
	if( $dmly_current_user_deemly_id != ''){

		// Do we have this information in our transients already?
        $transient = get_transient( $user_id );
		
		if( ! empty( $transient ) ) {
            // The function will return here every time after the first time it is run, until the transient expires.
            $user = $transient;
        // Nope!  We gotta make a call.
        } else {
            $user = json_decode( getdeemlyuserdata( $dmly_current_user_deemly_id ) );
        }
		// Check if we have a user at all.
		if( isset( $user )){
			ob_start();
			?>
			<div class="deemly-container">
				<img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/dmly-score-widget-logo.png' ) ?>" alt="deemly">
				<?php if( isset( $user->responseData->scoreViewModel ) ){
				if( $user->responseData->scoreViewModel->score != ''){ ?>
				    <span class="deemly-score"><?php echo $user->responseData->scoreViewModel->score; ?></span>
				  <?php }else{ ?>
				    <img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/deemly-verified.png' ) ?>" alt="<?php _e('Verified by deemly', 'dmly'); ?>">
				  <?php }
				}else{ ?>
				    <img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/deemly-verified.png' ) ?>" alt="<?php _e('Verified by deemly', 'dmly'); ?>">
				<?php } ?>
				<div class="deemly-user">
					<a href="//deemly.co/about" title="Read more about deemly" target="_blank" class="deemly-show-about">i</a>
					<img src="<?php echo $user->responseData->profilePictureUrl; ?>" alt="<?php echo $user->responseData->name; ?>" class="deemly-user__image" />
					<h2 class="deemly-user__name"><?php echo $user->responseData->name; ?></h2>
					<a href="<?php echo $user->responseData->profilePageUrl; ?>" class="deemly-user__link" title="See full profile" target="_blank">See full profile</a>
					<?php if( isset( $user->responseData->scoreViewModel) && $user->responseData->scoreViewModel->totalNumberOfRatings > 0 ){ ?>
						<p class="deemly-user__description">Based on <?php echo $user->responseData->scoreViewModel->totalNumberOfRatings; ?> reviews from <?php echo $user->responseData->scoreViewModel->numberOfSites; ?> platforms</p>
					<?php } ?>
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}
	}
}


// Get deemly user from WordPress user ID
function dmly_show_user_score_widget_large( $user_id ) {
	// Get the users deemly ID
	$dmly_current_user_deemly_id = get_user_meta( $user_id, 'dmly_user_deemly_id', TRUE ); 
	if( $dmly_current_user_deemly_id != ''){

		// Do we have this information in our transients already?
        $transient = get_transient( $user_id );
		
		if( ! empty( $transient ) ) {
            // The function will return here every time after the first time it is run, until the transient expires.
            $user = $transient;
        // Nope!  We gotta make a call.
        } else {
            $user = json_decode( getdeemlyuserdata( $dmly_current_user_deemly_id ) );
        }
		// Check if we have a user at all.
		if( isset( $user ) && is_object( $user ) ){
			ob_start();
			?>
			<div class="deemly-container--large">
				<header class="deemly-container--large_header" style="background-image:url(<?php echo $user->responseData->covelPictureUrl; ?>);"></header>
				<div class="deemly-user">
					<img src="<?php echo $user->responseData->profilePictureUrl; ?>" alt="<?php echo $user->responseData->name; ?>" class="deemly-user__image" />
					<h2 class="deemly-user__name"><?php echo $user->responseData->name; ?></h2>
					<?php if( isset( $user->responseData->scoreViewModel ) ){
						if( $user->responseData->scoreViewModel->score != ''){ ?>
							deemly
					    	<span class="deemly-score"><?php echo $user->responseData->scoreViewModel->score; ?></span>
					    	score
					  	<?php }else{ ?>
					    	<img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/deemly-verified.png' ) ?>" alt="<?php _e('Verified by deemly','dmly'); ?>">
					  	<?php }
					}else{ ?>
				    	<img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/deemly-verified.png' ) ?>" alt="<?php _e('Verified by deemly','dmly'); ?>">
				  	<?php } ?>
					<?php if( isset( $user->responseData->scoreViewModel) && $user->responseData->scoreViewModel->totalNumberOfRatings > 0 ){ ?>
						<p class="deemly-user__description">Based on <?php echo $user->responseData->scoreViewModel->totalNumberOfRatings; ?> reviews from <?php echo $user->responseData->scoreViewModel->numberOfSites; ?> platforms</p>
					<?php } ?>
					<div>
						<a href="<?php echo $user->responseData->profilePageUrl; ?>" class="deemly-user__link" title="<?php _e('See full profile', 'dmly'); ?>" target="_blank"><?php _e('See full profile', 'dmly'); ?></a>
					</div>
					<img class="dmly-widget-branding" src="<?php echo plugins_url( 'deemly/assets/img/dmly-score-widget-logo.png' ) ?>" alt="deemly" />
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}else{
			echo "We couldn't find a deemly profile, Sorry :,(";
		}
	}
}

function dmly_show_user_reviews( $user_id ){
	$dmly_user_data = json_decode( dmly_get_user_ratings_review( $user_id ) );
    $dmly_user_data = $dmly_user_data->list;
    print_r($dmly_user_data);
    ob_start(); ?>
    <div class="dmly-reviews-container">
    <?php if( is_array( $dmly_user_data ) && count( $dmly_user_data ) > 0 ){
		foreach( $dmly_user_data as $dmly_user_reviews){ ?>
			<div class="dmly-review">
        	<?php foreach( $dmly_user_reviews->userRatings as $dmly_user_review ) { ?>
        		<div id="deemly-raing-container-<?php echo $dmly_user_reviews->id; ?>" class="deemly-rating-container">
					<h4 class="deemly-rating-container__category-name"><?php echo $dmly_user_review->ratingCategoryName; ?></h4>
					<div class="deemly-rating-container__ratings" style="color: #<?php echo $dmly_user_review->color; ?>;">
						<?php
			            $i = 0;
			              while( $i < $dmly_user_review->rating ) { ?>
			                &#9733;
			              <?php
			              $i++;
			            }
			            ?>
					</div>
				</div>
        	<?php } ?>
				<div class="dmly-review__text">
					<?php echo $dmly_user_reviews->reviewText; ?>
				</div>
				<div class="dmly-review__rater">
					<?php echo get_avatar( $dmly_user_reviews_reviews->userId, '40', '', get_the_author_meta( 'display_name', $dmly_user_reviews->userId ) ); ?>
					<span><?php echo get_the_author_meta( 'display_name', $dmly_user_reviews->userId ); ?></span>, 
					<time class="dmly-review__date">
					<?php 
						$dmly_time = strtotime( $dmly_user_reviews->dateCreated );
						$dmly_time = date('d. M Y', $dmly_time);
						echo $dmly_time;
					?>
					</time>
				</div>
        	</div>
      <?php }
  	}else{
      	echo '<p>' . __('No ratings and reviews yet','dmly') . '</p>';
    } ?>
	</div>
    <?php echo ob_get_clean();
}

// Get deemly user from deemly user ID
function dmly_show_deemly_user_score_widget_large( $deemly_user_id ) {
	// Get the users deemly ID
	if( $deemly_user_id != ''){

		// Do we have this information in our transients already?
        $transient = get_transient( $deemly_user_id );
		
		if( ! empty( $transient ) ) {
            // The function will return here every time after the first time it is run, until the transient expires.
            $user = $transient;
        // Nope!  We gotta make a call.
        } else {
            $user = json_decode( getdeemlyuserdata( $deemly_user_id ) );
        }
		// Check if we have a user at all.
		if( isset( $user )){
			ob_start();
			?>
			<div class="deemly-container--large">
				<header class="deemly-container--large_header" style="background-image:url(<?php echo $user->responseData->covelPictureUrl; ?>);"></header>
				<div class="deemly-user">
					<img src="<?php echo $user->responseData->profilePictureUrl; ?>" alt="<?php echo $user->responseData->name; ?>" class="deemly-user__image" />
					<h2 class="deemly-user__name"><?php echo $user->responseData->name; ?></h2>
					<?php if( isset( $user->responseData->scoreViewModel ) ){
						if( $user->responseData->scoreViewModel->score != ''){ ?>
							deemly
					    	<span class="deemly-score"><?php echo $user->responseData->scoreViewModel->score; ?></span>
					    	score
					  	<?php }else{ ?>
					    	<img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/deemly-verified.png' ) ?>" alt="<?php _e('verified by deemly','dmly'); ?>">
					  	<?php }
					}else{ ?>
					    	<img class="deemly-logo" src="<?php echo plugins_url( 'deemly/assets/img/deemly-verified.png' ) ?>" alt="<?php _e('verified by deemly','dmly'); ?>">
					  	<?php } ?>
					<?php if( isset( $user->responseData->scoreViewModel) && $user->responseData->scoreViewModel->totalNumberOfRatings > 0 ){ ?>
						<p class="deemly-user__description">Based on <?php echo $user->responseData->scoreViewModel->totalNumberOfRatings; ?> reviews from <?php echo $user->responseData->scoreViewModel->numberOfSites; ?> platforms</p>
					<?php } ?>
					<div>
						<a href="<?php echo $user->responseData->profilePageUrl; ?>" class="deemly-user__link" title="<?php _e('See full profile', 'dmly'); ?>" target="_blank"><?php _e('See full profile', 'dmly'); ?></a>
					</div>
				</div>
			</div>
			<?php
			echo ob_get_clean();
		}
	}
}

function dmly_post_review_form( $rated_user, $rating_user ){
	ob_start();
	if( is_user_logged_in() ){
		if( isset( $_POST["dmly_form_submit"]) && !empty($_POST["dmly_form_submit"]) ){

			$dmly_ratingcategories = json_decode( getdeemlyratingcategories() );
			$dmly_ratingcategories = $dmly_ratingcategories->responseData;
			$rateUserValues = array();

			foreach( $dmly_ratingcategories as $dmly_ratingcategory) {
				$rateUserValues[] = array(
					'ratingCategoryId' => $dmly_ratingcategory->id,
					'rating' => $_POST['deemly-rating-'.$dmly_ratingcategory->id]
				);
				foreach ($dmly_ratingcategory->children as $dmly_ratingcategorychildren) {
					$rateUserValues[] = array(
						'ratingCategoryId' => $dmly_ratingcategorychildren->id,
						'rating' => $_POST['deemly-rating-'.$dmly_ratingcategorychildren->id]
					);
				}
			}

			//foreach( $dmly_ratingcategories as $dmly_ratingcategory) {
			//	$dmly_ratingsdata .=  $dmly_ratingcategory->id . "=" . $_POST['deemly-rating-'.$dmly_ratingcategory->id]."&";
			//	foreach ($dmly_ratingcategory->children as $dmly_ratingcategorychildren) {
			//		$dmly_ratingsdata .= $dmly_ratingcategorychildren->id . "=" . $_POST['deemly-rating-'.$dmly_ratingcategorychildren->id]."&";
			//	}
			//}

			// Lets remove the leftover '&' from the loop.
			//$dmly_ratingsdata = rtrim($dmly_ratingsdata, "&");


			$review_data = array(
				'ratedUserId'  		=> $_POST["dmly-rated-user"],
				'ratingUserId' 		=> $_POST["dmly-rating-user"],
				'reviewText'    	=> $_POST["dmly-review-text"],
				'rateUserValues'    => $rateUserValues
			);
			echo '<pre>';
			print_r($review_data);
			echo '</pre>';
			if( !in_array(null, $review_data)) {
				$success = dmly_post_review( $review_data );
				$success_msg = $success->responseData;
				echo "<div class='deemly-info-box deemly-info-box--success'>".$success_msg."</div>";
			}else{
				echo "<div class='deemly-info-box deemly-info-box--error'>".__('All fields are required.','dmly')."</div>";
				dmly_render_form( $rated_user, $rating_user );
			}
		}else{
			dmly_render_form( $rated_user, $rating_user );
		}
	}else{ ?>
		<p><?php _e( 'You must be logged in to post a review.','dmly'); ?></p>
	<?php }
	echo ob_get_clean();
}


function dmly_render_form( $rated_user, $rating_user ){
	// Get our ratings categories
	$ratingcategories = json_decode( getdeemlyratingcategories() );
	$ratingcategories = $ratingcategories->responseData;
	?>
	<form action="" class="deemly-form-post-review" method="post">
		<?php foreach( $ratingcategories as $ratingcategory) { ?>
		<div class="deemly-rating deemly-rating-2">
			<span><?php echo $ratingcategory->name; ?>:</span>
			<input type="radio" id="deemly-rating-<?php echo $ratingcategory->id; ?>-star5" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategory->id; ?>" value="5" /><label class="full" for="deemly-rating-<?php echo $ratingcategory->id; ?>-star5" title="5 stars"></label>
		    <input type="radio" id="deemly-rating-<?php echo $ratingcategory->id; ?>-star4" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategory->id; ?>" value="4" /><label class="full" for="deemly-rating-<?php echo $ratingcategory->id; ?>-star4" title="4 stars"></label>
		    <input type="radio" id="deemly-rating-<?php echo $ratingcategory->id; ?>-star3" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategory->id; ?>" value="3" /><label class="full" for="deemly-rating-<?php echo $ratingcategory->id; ?>-star3" title="3 stars"></label>
		    <input type="radio" id="deemly-rating-<?php echo $ratingcategory->id; ?>-star2" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategory->id; ?>" value="2" /><label class="full" for="deemly-rating-<?php echo $ratingcategory->id; ?>-star2" title="2 stars"></label>
		    <input type="radio" id="deemly-rating-<?php echo $ratingcategory->id; ?>-star1" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategory->id; ?>" value="1" /><label class="full" for="deemly-rating-<?php echo $ratingcategory->id; ?>-star1" title="1 star"></label>
		</div>
			<?php foreach( $ratingcategory->children as $ratingcategorychildren) { ?>
			<div class="deemly-rating deemly-rating-<?php echo $ratingcategorychildren->id; ?>">
				<span><?php echo $ratingcategorychildren->name; ?>:</span>
				<input type="radio" id="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star5" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategorychildren->id; ?>" value="5" /><label class="full" for="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star5" title="5 stars"></label>
			    <input type="radio" id="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star4" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategorychildren->id; ?>" value="4" /><label class="full" for="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star4" title="4 stars"></label>
			    <input type="radio" id="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star3" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategorychildren->id; ?>" value="3" /><label class="full" for="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star3" title="3 stars"></label>
			    <input type="radio" id="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star2" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategorychildren->id; ?>" value="2" /><label class="full" for="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star2" title="2 stars"></label>
			    <input type="radio" id="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star1" class="deemly-rating" name="deemly-rating-<?php echo $ratingcategorychildren->id; ?>" value="1" /><label class="full" for="deemly-rating-<?php echo $ratingcategorychildren->id; ?>-star1" title="1 star"></label>
			</div>
			<?php } ?>
		<?php } ?>
		<input type="hidden" name="dmly-rated-user" id="dmly-rated-user" value="<?php echo $rated_user; ?>" />
		<input type="hidden" name="dmly-rating-user" id="dmly-rating-user" value="<?php echo $rating_user; ?>" />
		<textarea name="dmly-review-text" id="dmly-review-text"></textarea>
		<input type="hidden" name="dmly_form_submit" value="dmly_form_submit" />
		<input type="submit" value="<?php _e('Submit review','dmly'); ?>" class="btn btn--cta">
	</form>
	<?php
}