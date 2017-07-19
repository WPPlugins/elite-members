<?php
function ilc_admin_tabs( $current = 'author_box' ) {
    $tabs = array( 'author_box' => 'Author Box',  'help' => 'Help' );
    screen_icon(); echo "<h2>". __( 'Elite Members Settings', 'elite-members' ) . "</h2>"; 
	//echo '<div id="icon-themes" class="icon32"><br></div>';
	
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='#$tab'>$name</a>";

    }
    echo '</h2>';
}
function em_settings_page()
	{
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'em-settings' );
	wp_enqueue_script( 'jscolor' );
	
	wp_enqueue_style( 'em-admin-css' );
	
	//Array of Display Types
	$box_styles = array('compact'=>'Compact','standard'=>'Standard','go_social'=>'Go Social','disabled'=>'Disabled');
	
	//Array of Display Types
	$avatar_styles = array('circle'=>'Circle','square'=>'Square');
	$bool = array('1'=>'Yes','0'=>'No');
	//Get set color
			$em_box_title		=		get_option(  'em_box_title' );
		 	$em_posttypes	=		get_option(  'em_posttypes' );
			$em_display_types	= 	get_option(  'em_display_types' );
			$wpp_upload_image	= 	get_option(  'wpp_upload_image' );
			
			$em_bg_color	=	get_option(	 'em_bg_color' );
			$em_text_limit	=	get_option(  'em_text_limit' );
			$em_text_color	=	get_option(  'em_text_color' );
			$em_t_color		=	get_option(  'em_t_color' );
			$em_th_color	=	get_option(  'em_th_color' );
			$em_def_msg		=	get_option(  'em_def_msg' );
			$em_avatar_style=	get_option(  'em_avatar_style' );
			$em_avatar_size=	get_option(  'em_avatar_size' );
			$em_exclude_admin=	get_option(  'em_exclude_admin' );
			$em_auto_insert=	get_option(  'em_auto_insert' );
			//Set Default
			if(empty($em_avatar_size))
			{
				$em_avatar_size = "100";
			}
			if(empty($em_text_limit))
			{
				$em_text_limit = "150";
			}
			if(empty($em_box_title))
			{
				$em_box_title = "Written by:";
			}
			if(empty($em_text_color))
			{
				$em_text_color = "dddddd";
			}
			if(empty($em_th_color))
			{
				$em_th_color = "FFF838";
			}
			if(empty($em_t_color))
			{
				$em_t_color = "FFFFFF";
			}
			if(empty($em_bg_color))
			{
				$em_bg_color = "333333";
			}
			if(empty($em_def_msg))
			{
				$em_def_msg = "This user has not entered any information";
			}
			ilc_admin_tabs( $current = 'author_box' );
	?>
    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>  
    <div id="tabs">
   <div id="author_box">
     <h3>Update your settings for Author Box styling</h3>
     <table class="form-table">
            <tr valign="top">
            <th scope="row"><label for="em_title"><?php _e( 'Author Box Title' ); ?></label></th>
            <td>
            <input type="text" name="em_box_title" size="45" value="<?php echo $em_box_title; ?>" />
            <p class="description"><?php _e('Title to be displayed on author box', 'elite-members' ) ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row">
            <label for="em_auto_insert"><?php _e( 'Automatic Insert' ); ?></label></th>
            <td>
            <select id="em_auto_insert" name="em_auto_insert">
                <?php 
				foreach($bool as $key => $value) { 	?>
					<option value="<?php echo $key; ?>" <?php if( $key == $em_auto_insert){ echo $selected = 'selected="selected"';} ?>><?php echo $value; ?></option>
                <?php } ?>
            </select>
            <p class="description"><?php _e('Choose whether to automatically insert author box into posts.') ?></p>
            </td>
            </tr>
             <tr valign="top">
            <th scope="row">
            <label for="em_display_types"><?php _e( 'Display Type' ); ?></label></th>
            <td>
            <select id="em_display_types" name="em_display_types">
                <?php foreach($box_styles as $key => $value) { 	?>
					<option value="<?php echo $key; ?>" <?php if( $key == $em_display_types){ echo $selected = 'selected="selected"';} ?>><?php echo $value; ?></option>
                <?php } ?>
            </select>
            <p class="description"><?php _e('Choose the type of posts to be displayed.') ?></p>
            </td>
            </tr>
             <tr valign="top">
            <th scope="row">
            <label for="em_avatar_style"><?php _e( 'Avatar Shape' ); ?></label></th>
            <td>
            <select id="em_avatar_style" name="em_avatar_style">
                <?php foreach($avatar_styles as $key => $value) { 	?>
					<option value="<?php echo $key; ?>" <?php if( $key == $em_avatar_style){ echo $selected = 'selected="selected"';} ?>><?php echo $value; ?></option>
                <?php } ?>
            </select>
            <p class="description"><?php _e('Choose the avatar shape.') ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row">
            <label for="em_avatar_style"><?php _e( 'Avatar Shape' ); ?></label></th>
            <td>
           <input type="text" name="em_avatar_size" size="10" value="<?php echo $em_avatar_size; ?>" />
            <p class="description"><?php _e('Choose the avatar size. Example..100  .Leave blank for default ') ?></p>
            </td>
            </tr> 
            <tr valign="top">
            <th scope="row">
            <label for="em_avatar_style"><?php _e( 'Text Limit' ); ?></label></th>
            <td>
           <input type="text" name="em_text_limit" size="10" value="<?php echo $em_text_limit; ?>" />
            <p class="description"><?php _e('Choose the biography limit author box ') ?></p>
            </td>
            </tr>
          	<tr valign="top">
            <th scope="row"><label for="em_bg_color"><?php _e( 'Background Color' ); ?></label></th>
            <td>
            <input name="em_bg_color" class="color {pickerMode:'HSV'}" value="<?php echo $em_bg_color; ?>">
            <p class="description"><?php _e('Background color') ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row"><label for="em_text_color"><?php _e( 'Text color' ); ?></label></th>
            <td>
            <input name="em_text_color" class="color {pickerMode:'HSV'}" value="<?php echo $em_text_color; ?>">
            <p class="description"><?php _e('Text color') ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row"><label for="em_t_color"><?php _e( 'Title color' ); ?></label></th>
            <td>
            <input name="em_t_color" class="color {pickerMode:'HSV'}" value="<?php echo $em_t_color; ?>">
            <p class="description"><?php _e('Normal link color') ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row"><label for="em_th_color"><?php _e( 'Title Color: Hover' ); ?></label></th>
            <td>
            <input name="em_th_color" class="color {pickerMode:'HSV'}" value="<?php echo $em_th_color; ?>">
            <p class="description"><?php _e('Link color when mouse hover over it.') ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row"><label for="em_def_msg"><?php _e( 'Default Message' ); ?></label></th>
            <td>
            <textarea name="em_def_msg" id="em_def_msg" cols="60" rows="3">
            	<?php echo $em_def_msg; ?>
            </textarea>
            <p class="description"><?php _e('Default message to be displayed when author biography is empty') ?></p>
            </td>
            </tr>
            <tr valign="top">
            <th scope="row"><label for="em_posttypes"><?php _e( 'Include on Post Types' ); ?></label></th>
            <td>
			<?php $args=array(
				  'public'   => true
				); 
				$output = 'names'; // names or objects, note names is the default
				$operator = 'and'; // 'and' or 'or'
				$post_types=get_post_types($args,$output,$operator); 
				 $i = 0;
				  foreach ($post_types  as $post_type ) {
					$typeobj = get_post_type_object( $post_type );?>
                                <input type="checkbox" name="em_posttypes[<?php echo $post_type; ?>]" value="1" <?php 
								if(!empty($em_posttypes[$post_type])){
								checked($em_posttypes[$post_type],1);
								} ?>  /> <?php echo $typeobj->labels->name; ?><br>
        		<?php $i++; ?>
                <?php } ?>
             <p class="description"><?php _e('Choose the post types that the plugin should be displayed on.') ?></p>
            </td>
            </tr>
             <tr valign="top">
            <th scope="row"></th>
            <td>
          <input type="submit" name="Submit" value="Save Settings" />
            </td>
            </tr>
            </table>
   </div>
   <div id="list">
     <h3>This is a really simple tabbed interface</h3>
   </div>
   <div id="help">
     <h3>Use the help Tab as a reference to the plugin usage</h3>
      <h2>Shortcodes</h2>
      <p>There are several shortcodes used for author box and list, please see below:</p>
      <h3>Listing Shortcodes</h3>
      <h3>Default</h3>
      <pre>[emembers]</pre>
      <p>The shortcode <strong>emembers</strong> will create a list of authors, it comes with several options</p>
      <h4>Mini Style</h4>
      <pre>
      [emembers theme="mini"]
      </pre>
      <h4>List</h4>
      <pre>
      [emembers theme="list"]
      </pre>
      <h4>Minimal</h4>
      <pre>
      [emembers theme="minimal"]
      </pre>
      <h4>Grid</h4>
      <pre>
      [emembers theme="grid"]
      </pre>
      <h3>Additional options for shortcodes</h3>
      <p>With the plugin you can specify to get top authors for the previous day, week, month, year. To specify the option, use <strong>period</strong> in your shortcode</p>
      <pre>
      	[emembers theme="mini" period="month"]
        </pre>
       <p>By default, <strong>period</strong> is set to <strong>1</strong>. To search for top authors over a longer period, you can use <strong>duration</strong></p>
       <pre>
       [emembers theme="mini" period="month" duration="3"]
       </pre>
       <p>If you would like to limit the number of authors displayed, you can use the <strong>limit</strong> option in your shortcode</p>
        <pre>
       [emembers theme="mini" period="month" duration="3" limit="3"]
       </pre>
		<h3>Listing template tags</h3>
        <p>If you intend on implementing author list in templates, then you can use the following options for adding</p>
       <pre>
       
      	echo do_shortcode('[emembers theme="mini"]');
		echo do_shortcode('[emembers theme="list"]');
		echo do_shortcode('[emembers theme="minimal"]');
		echo do_shortcode('[emembers theme="grid"]');
    </pre>
    <p>The same additional options previously mentioned, also applied to the template tags.</p>
     <h2>Author Box</h2>
     <p>Authox boxes can be implemented into a site in a few ways. You can use shortcodes, template tags or automatic insertion from the Elite members settings panel.</p>
     <h3>Shortcodes</h3>
     <p>The following are some shortcodes that can be implemented to get an author box in your post.</p>
     <h4>Compact</h4>
     <pre>
     	[em_compact]
	</pre>
    <h4>Go Social</h4>
    <pre>
    [em_social]
    </pre>
    <h4>Standard</h4>
    <pre>
    [em_standard]
    </pre> 
    <h3>Template Tags</h3>
    <h4>Compact</h4>
     <pre>
     	if(function_exists('em_compact')) {
        	echo em_compact();
        }
	</pre>
    <h4>Go Social</h4>
    <pre>
     	if(function_exists('em_social')) {
        	echo em_social();
        }
	</pre>
    <h4>Standard</h4>
    <pre>
     	if(function_exists('em_standard')) {
        	echo em_standard();
        }
	</pre>
    <p>If your require any assistance with using this plugin or would like personal customization, you can email B4uCode from the profile on <a href="http://codecanyon.net/user/b4ucode" target="_blank">CodeCanyon</a>.</p>
    <p>If you have the time, please follow me on <a  title="B4uCode Facebook" href="http://www.facebook.com/b4ucode" target="_blank">Facebook</a>, <a title="B4uCode Twitter" href="https://twitter.com/b4ucode" target="_blank">Twitter @b4ucode</a>, <a title="B4uCode LinkedIn" href="http://www.linkedin.com/company/b4ucode" target="_blank">LinkedIn</a></p>
   </div>
 </div>


	<div class="wrap">
		<div class="wpp_content">
       
		
       
			<input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="em_display_types, em_bg_color, em_text_color, em_t_color, em_th_color,em_posttypes,em_def_msg,em_avatar_style,em_avatar_size,em_box_title,em_auto_insert,em_text_limit" />
		</form>
        </div>
        <div class="wpp_footer">
        	<div class="social">
            	<a class="facebook" title="B4uCode Facebook" href="http://www.facebook.com/b4ucode" target="_blank"></a>
                <a class="twitter" title="B4uCode Twitter" href="https://twitter.com/b4ucode" target="_blank"></a>
                <a class="linkedin" title="B4uCode LinkedIn" href="http://www.linkedin.com/company/b4ucode" target="_blank"></a>
                <a class="envato" title="B4uCode CodeCanyon" href="http://codecanyon.net/user/b4ucode" target="_blank"></a>
                 <div class="clr"></div>
            </div>
            <div class="owner"><a href="http://www.b4ucode.com" target="_blank">B4uCode</a></div>
            <div class="clr"></div>
        </div>
	</div>
<?php
}
	function em_setup_admin()
	{
		add_options_page('Elite Members', 'Elite Members', 'manage_options', 'em_settings_page','em_settings_page');
	}
	function em_add_admin_scrips()
	{
		wp_register_script( 'jscolor', plugins_url( '/js/jscolor.js', __FILE__ ) );
		wp_register_script( 'em-settings', plugins_url( '/js/settings.js', __FILE__ ) );
		
	}
	function em_add_admin_styles()
	{
		wp_register_style( 'em-admin-css', plugins_url( '/css/em-admin.css', __FILE__ ), array(), '20120208', 'all' );
		
	}
if ( is_admin() ){ 
  add_action( 'admin_menu', 'em_setup_admin' );
   add_action( 'admin_init', 'em_add_admin_styles' );
  add_action( "admin_print_scripts", 'em_add_admin_scrips' );
} 
