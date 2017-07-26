<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates the admin submenu
 *
 * @since 0.1
 * @return void
 */


function register_dmly_menu_page(){
    add_menu_page(
      'deemly settings',  		  // The text to be displayed in the title tags of the page when the menu is selected
      'deemly',           		  // The on-screen name text for the menu
      'manage_options',   		  // The capability required for this menu to be displayed to the user.
      'deemly-settings',  		  // The slug name to refer to this menu by (should be unique for this menu).
      'render_dmly_front_page', // The function that displays the page content for the menu page.
      'dashicons-star-filled'	  // The icon TDOD: make own
      ); 
}
add_action( 'admin_menu', 'register_dmly_menu_page' );


function register_dmly_help_page() {
  add_submenu_page(
        'deemly-settings',        // The slug name for the parent menu 
        'Help',                   // The text to be displayed in the title tags of the page when the menu is selected
        'Help',                   // The text to be used for the menu
        'manage_options',         // The capability required for this menu to be displayed to the user.
        'dmly-help',              // The slug name to refer to this menu by (should be unique for this menu).
        'dmly_help_page',         // The function that displays the page content for the menu page.
        'dashicons-star-filled'   // The icon TDOD: make own
    );
}
add_action('admin_menu', 'register_dmly_help_page');

function render_dmly_front_page(){
	ob_start();
	?>
	<div class="wrap dmly-container clearfix">
    <div class="dmly-settings">
			<form method="post" action="options.php" class="dmly-settings-form">
        <?php do_settings_sections( 'deemly-settings' ); ?>
				<?php settings_fields( 'dmly_settings' );  ?>
				<?php submit_button(); ?>
        <h2><?php _e('Your rating categories:', 'dmly'); ?></h2>
        <p><?php _e( 'The parameters users can rate each other on.' ,'dmly'); ?></p>
			</form>
      <div>
        <form method="post" class="dmly-rating-categories-form">
            <input type="hidden" value="update" name="update_rating_categories" />
            <?php if( isset( $_POST['update_rating_categories'] ) ){
                dmly_update_ratings_categories();
            } ?>
            <ul class="dmly-rating-categories-list">
            <?php
              $dmly_rating_categories = get_option('dmly_rating_categories');
              foreach( $dmly_rating_categories as $dmly_rating_category) { ?>
                <li>
                  <?php echo $dmly_rating_category->name; ?>
                  <ul>
                  <?php foreach( $dmly_rating_category->children as $dmly_rating_category_children) { ?>
                    <li><?php echo $dmly_rating_category_children->name; ?></li>
                  <?php } ?>
                  </ul>
                </li>
              <?php } ?>
             </ul>
             <input type="submit" Value="<?php _e('Update', 'dmly'); ?>" class="button button-primary">
           </form>
        </div>
    </div>

		<div class="dmly-branding-container">
			<img src="<?php echo plugins_url( 'deemly/assets/img/dmly-logo.png' ) ?>"  alt="deemly logo" />
      <!-- Begin MailChimp Signup Form -->
      <div id="mc_embed_signup">
        <p>Be the first to know about upcoming news from deemly, sign up today!</p>
      <form action="//deemly.us11.list-manage.com/subscribe/post?u=688cd3405b568e7b37dd94ee3&amp;id=fcfb945364" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
          <div id="mc_embed_signup_scroll">
        
      <div class="mc-field-group">
        <label for="mce-EMAIL">Email Address</label>
        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
      </div>
      <div class="mc-field-group">
        <label for="mce-FNAME">First Name</label>
        <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
      </div>
      <div class="mc-field-group">
        <label for="mce-LNAME">Last Name</label>
        <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
      </div>
      <div class="mc-field-group">
        <label for="mce-MMERGE3">Company</label>
        <input type="text" value="" name="MMERGE3" class="" id="mce-MMERGE3">
      </div>
        <div id="mce-responses" class="clear">
          <div class="response" id="mce-error-response" style="display:none"></div>
          <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
          <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_688cd3405b568e7b37dd94ee3_fcfb945364" tabindex="-1" value=""></div>
          <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="dmly-btn dmly-btn--cta"></div>
          </div>
      </form>
      </div>
        <!--End mc_embed_signup-->
			</div>
		</div><!-- #tab_container-->
	</div><!-- .wrap -->
	<?php
	echo ob_get_clean();
}

function dmly_help_page(){
  ob_start();
  ?>
  <div class="wrap dmly-container clearfix">
      <h2><?php _e('How to use', 'dmly'); ?></h2>
        <p>Let's look at how we can use the deemly plugin</p>
        <h3>Short codes</h3>
        <p>Display the deemly user widget by either passing in a users deemly ID or a users WordPress ID, if they have saved their deemly ID on their user.</p>
        <code>
          [deemlyuser deemlyid="" userid=""]
        </code>
        <h3>Template functions</h3>
        <h4>User deemly score</h4>
        <p>Just pass the users WordPress ID and we'll do the rest.</p>
        <code>
          dmly_show_user_score_widget( get_the_author_meta( 'ID' ) );
        </code>
        <h4>User ratings and reviews</h4>
        <p>If you're using the deemly Ratings & Reviews system, you can pull and display all of a users ratings and reviews with this function:</p>
        <p>Again you just have to pass the users WordPress ID.</p>
        <code>
          dmly_show_user_reviews( get_the_author_meta( 'ID' )  );
        </code>
        <h4>Submit rating & review form</h4>
        <p>Let your users rate and reviews each other with the deemly Ratings & Review system.</p>
        <code>
          dmly_post_review_form( 'Rated user ID', 'Rating user ID');
        </code>
  </div><!-- .wrap -->
  <?php
  echo ob_get_clean();
}
