<?php
// Fetch a deemly users data from a deemly user ID
function getdeemlyuserdata( $user_id ){
	
	// Get stuff stored from the DB
	$dmly_app_key = (array)get_option( 'dmly_site_app_key' );
	$dmly_app_key = $dmly_app_key['dmly_site_app_key'];
	
	$dmly_secret_key = (array)get_option( 'dmly_site_secret_key' );
	$dmly_secret_key = $dmly_secret_key['dmly_site_secret_key'];

	$app_key = $dmly_app_key;
	$secret_key = $dmly_secret_key;

	// Our salt
	$salt = 'rz8LuOtFBXphj9WQfvFh';
	$security = new SecurityManager($app_key, $salt, $secret_key);

	// We'ere still in beta
	$userAgent = 'PHP Test 0.1';
	// Yir, ticks in PHP...
	$ts = microtime(true);
    $ticks = intval($ts) * 10000000 + 621355968000000000;
	$message = $security->GenerateToken($app_key, $secret_key, $userAgent, $ticks);

    // Create a cURL handle
	$ch = curl_init();
    $headers = array(
    	'Accept: application/json',
    	'content-Type: application/json',
    	'Authorization: amx ' . $message
    );

    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt( $ch, CURLOPT_URL, "https://portal.deemly.co/api/deemly-score?userId=".$user_id);
	
    // Return the deemly user info in json
	return curl_exec( $ch);

	// Close handle
	curl_close($ch);
}

// Post a rating and review for a user
// $rated_user_id, $rating_user_id, $review, $rating
function dmly_post_review( $review_data ){
	// Get stuff stored from the DB
	$dmly_app_key = (array)get_option( 'dmly_site_app_key' );
	$dmly_app_key = $dmly_app_key['dmly_site_app_key'];
	
	$dmly_secret_key = (array)get_option( 'dmly_site_secret_key' );
	$dmly_secret_key = $dmly_secret_key['dmly_site_secret_key'];

	$app_key = $dmly_app_key;
	$secret_key = $dmly_secret_key;

	// Our salt
	$salt = 'rz8LuOtFBXphj9WQfvFh';
	$security = new SecurityManager($app_key, $salt, $secret_key);

	// We'ere still in beta
	$userAgent = 'PHP Test 0.1';
	// Yir, ticks in PHP...
	$ts = microtime(true);
    $ticks = intval($ts) * 10000000 + 621355968000000000;
	$message = $security->GenerateToken($app_key, $secret_key, $userAgent, $ticks);

    // Create a cURL handle
	$ch = curl_init();
    
    $headers = array(
    	'Accept: application/json',
    	'content-Type: application/json',
    	'Authorization: amx ' . $message
    );

	// set post fields
	$dmly_review = json_encode( $review_data );

	/* Data array shoudl ne as follow
	array(
	    'ratedUserId' 	=> '1',
	    'ratingUserId' 	=> '13123217',
	    'reviewText'   	=> 'What a nice dude',
	    'value' 		=>  5
	) 
	*/

	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_VERBOSE, 1);
	//curl_setopt( $ch, CURLOPT_HEADER, 1);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS,  $dmly_review );
	curl_setopt( $ch, CURLOPT_URL, "https://portal.deemly.co/api/rate-user");

	// execute!
	$response = curl_exec( $ch );

	// do anything you want with your response
	return $response;

	// close the connection, release resources used
	curl_close( $ch );
}



// PGet users reviews and ratings
// $rated_user_id, $app_id
function dmly_get_user_ratings_review( $user_id ){
	// Get stuff stored from the DB
	$dmly_app_key = (array)get_option( 'dmly_site_app_key' );
	$dmly_app_key = $dmly_app_key['dmly_site_app_key'];
	
	$dmly_secret_key = (array)get_option( 'dmly_site_secret_key' );
	$dmly_secret_key = $dmly_secret_key['dmly_site_secret_key'];

	$app_key = $dmly_app_key;
	$secret_key = $dmly_secret_key;

	// Our salt
	$salt = 'rz8LuOtFBXphj9WQfvFh';
	$security = new SecurityManager($app_key, $salt, $secret_key);

	// We'ere still in beta
	$userAgent = 'PHP Test 0.1';
	// Yir, ticks in PHP...
	$ts = microtime(true);
    $ticks = intval($ts) * 10000000 + 621355968000000000;
	$message = $security->GenerateToken($app_key, $secret_key, $userAgent, $ticks);

    // Create a cURL handle
	$ch = curl_init();

    $headers = array(
    	'Accept: application/json',
    	'content-Type: application/json',
    	'Authorization: amx ' . $message
    );

    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt( $ch, CURLOPT_URL, "https://portal.deemly.co/api/user-ratings-reviews?UserId=".$user_id."&AppId=".$dmly_app_key
);
	
    // Return the deemly user info in json
	return curl_exec( $ch);

	// Close handle
	curl_close($ch);
}

function getdeemlyratingcategories(){
	
	// Get stuff stored from the DB
	$dmly_app_key = (array)get_option( 'dmly_site_app_key' );
	$dmly_app_key = $dmly_app_key['dmly_site_app_key'];
	
	$dmly_secret_key = (array)get_option( 'dmly_site_secret_key' );
	$dmly_secret_key = $dmly_secret_key['dmly_site_secret_key'];

	$app_key = $dmly_app_key;
	$secret_key = $dmly_secret_key;

	// Our salt
	$salt = 'rz8LuOtFBXphj9WQfvFh';
	$security = new SecurityManager($app_key, $salt, $secret_key);

	// We'ere still in beta
	$userAgent = 'PHP Test 0.1';
	// Yir, ticks in PHP...
	$ts = microtime(true);
    $ticks = intval($ts) * 10000000 + 621355968000000000;
	$message = $security->GenerateToken($app_key, $secret_key, $userAgent, $ticks);

    // Create a cURL handle
	$ch = curl_init();
    $headers = array(
    	'Accept: application/json',
    	'content-Type: application/json',
    	'Authorization: amx ' . $message
    );

    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt( $ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt( $ch, CURLOPT_URL, "https://portal.deemly.co/api/rating-categories");
	
    // Return the deemly user info in json
	return curl_exec( $ch);

	// Close handle
	curl_close($ch);
}