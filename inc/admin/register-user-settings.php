<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'show_user_profile', 'dmly_add_user_deemly_score_field' );
add_action( 'edit_user_profile', 'dmly_add_user_deemly_score_field' );


function dmly_add_user_deemly_score_field( $user ){ ?>
    <h3><?php _e('deemly ID', 'dmly'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="dmly_user_deemly_id"><?php _e( 'deemly ID' ,'dmly'); ?></label></th>
            <td><input type="text" name="dmly_user_deemly_id" value="<?php echo esc_attr(get_the_author_meta( 'dmly_user_deemly_id', $user->ID )); ?>" class="regular-text" />
            <span style="text-align: left;"><a href="https://beta.deemly.co/getloginid" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=500,height=580');return false;">Get your deemly id here</a></span>
            </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'dmly_save_user_deemly_score' );
add_action( 'edit_user_profile_update', 'dmly_save_user_deemly_score' );

function dmly_save_user_deemly_score( $user_id )
{
    update_user_meta(
    	$user_id,
    	'dmly_user_deemly_id',
    	sanitize_text_field( $_POST['dmly_user_deemly_id'] )
    );
}