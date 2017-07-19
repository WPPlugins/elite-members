<?php

function em_profile_fields( $user ) {
if ( !current_user_can( 'edit_posts', $user->ID ) ){
			return false;
		}
 ?>
	<h3>Social Profiles</h3>
	<table class="form-table">
		<tr>
			<th><label for="twitter">Facebook Url</label></th>
			<td>
				<input type="text" name="em_fb_id" id="em_fb_id" value="<?php echo esc_attr( get_the_author_meta( 'em_fb_id', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"></span>
			</td>
		</tr>
        <tr>
			<th><label for="twitter">Google + Url</label></th>
			<td>
				<input type="text" name="em_gp_id" id="em_gp_id" value="<?php echo esc_attr( get_the_author_meta( 'em_gp_id', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"></span>
			</td>
		</tr>
         <tr>
			<th><label for="twitter">Twitter Url</label></th>
			<td>
				<input type="text" name="em_tw_id" id="em_tw_id" value="<?php echo esc_attr( get_the_author_meta( 'em_tw_id', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"></span>
			</td>
		</tr>
         <tr>
			<th><label for="twitter">LinkedIn Url</label></th>
			<td>
				<input type="text" name="em_li_id" id="em_li_id" value="<?php echo esc_attr( get_the_author_meta( 'em_li_id', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"></span>
			</td>
		</tr>
	</table>
<?php }
function em_save_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_posts', $user_id ) ){
			return false;
		}
		if(isset($_POST['em_fb_id'])){
		update_user_meta( $user_id, 'em_fb_id', esc_url($_POST['em_fb_id']) ); //
		}
		if(isset($_POST['em_gp_id'])){
		update_user_meta( $user_id, 'em_gp_id', esc_url($_POST['em_gp_id']) ); //
		}
		if(isset($_POST['em_tw_id'])){
		update_user_meta( $user_id, 'em_tw_id', esc_url($_POST['em_tw_id']) ); //
		}
		if(isset($_POST['em_li_id'])){
		update_user_meta( $user_id, 'em_li_id', esc_url($_POST['em_li_id']) ); //
		}
		
	}
	
add_action( 'show_user_profile', 'em_profile_fields' );
add_action( 'edit_user_profile', 'em_profile_fields' );
add_action( 'personal_options_update', 'em_save_profile_fields' );
add_action( 'edit_user_profile_update', 'em_save_profile_fields' );