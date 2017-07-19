<?php
class EliteMembers_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
		'elitemembers_widget', // Base ID
		'Elite Members', // Name
		array(
			'description' => __( 'Display a list of Authors', 'elite-members' )
		)
	);
	}
	public function form( $instance ) {
		//Array of Display Types
	$box_styles = array('grid'=>'Grid','list'=>'List','mini'=>'Mini','minimal'=>'Minimal');
	$period = array('day'=>'Day','week'=>'Week','month'=>'Month','year'=>'Year');
	//Array of Display Types
	$avatar_styles = array('circle'=>'Circle','square'=>'Square');
	
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Top Contributors', 'elite-members' );
		}
		if ( isset( $instance[ 'em_theme' ] ) ) {
			$theme = $instance[ 'em_theme' ];
		}else{
			$theme = 'list';
		}
		if ( isset( $instance[ 'em_period' ] ) ) {
			$em_period = $instance[ 'em_period' ];
		}else{
			$em_period = 'week';
		}
		if ( isset( $instance[ 'em_duration' ] ) ) {
			$duration = $instance[ 'em_duration' ];
		}else{
			$duration = '1';
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}else{
			$count = 10;
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}
		if ( isset( $instance[ 'em_post_types' ] ) ) {
			$em_post_types = $instance[ 'em_post_types' ];
		}
		if ( isset( $instance[ 'em_avatar_style' ] ) ) {
			$em_avatar_style = $instance[ 'em_avatar_style' ];
		}
		?>
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <br />
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'em_theme' ); ?>"><?php _e( 'Theme:' ); ?></label> 
		 <select id="<?php echo $this->get_field_id( 'em_theme' ); ?>" name="<?php echo $this->get_field_name( 'em_theme' ); ?>">
                <?php foreach($box_styles as $key => $value) { 	?>
					<option value="<?php echo $key; ?>" <?php if( $key == $theme){ echo $selected = 'selected="selected"';} ?>><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
		<label for="<?php echo $this->get_field_id( 'em_period' ); ?>"><?php _e( 'Theme:' ); ?></label> 
		 <select id="<?php echo $this->get_field_id( 'em_period' ); ?>" name="<?php echo $this->get_field_name( 'em_period' ); ?>">
                <?php foreach($period as $key => $value) { 	?>
					<option value="<?php echo $key; ?>" <?php if( $key == $em_period){ echo $selected = 'selected="selected"';} ?>><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </p>
         <p>
        <label for="<?php echo $this->get_field_id( 'em_duration' ); ?>"><?php _e( 'Duration:' ); ?></label> 
        <input  size="5" id="<?php echo $this->get_field_id( 'em_duration' ); ?>" name="<?php echo $this->get_field_name( 'em_duration' ); ?>" type="text" value="<?php echo esc_attr( $duration ); ?>" />
		</p>
         <p>
        <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:' ); ?></label> 
        <input  size="5" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
         <p>
        <label for="<?php echo $this->get_field_id( 'em_post_types' ); ?>"><?php _e( 'Include Postst from:' ); ?></label> <br />

       	<?php $args=array(
				  'public'   => true
				); 
				$output = 'names'; // names or objects, note names is the default
				$operator = 'and'; // 'and' or 'or'
				$post_types=get_post_types($args,$output,$operator); 
				 $i = 0;
				  foreach ($post_types  as $post_type ) {
					if($post_type == 'attachment'){continue;}
					$typeobj = get_post_type_object( $post_type );
					
					if($em_post_types[$post_type] == 1)
									{
										$selected = 'selected="selected"';
									}else{
										$selected = 'selected="selected"';
									}
								?>
                                <input type="checkbox" name="<?php echo $this->get_field_name( 'em_post_types').'['. $post_type .']'; ?>" value="1" <?php checked($em_post_types[$post_type],1); ?> /> <?php echo $typeobj->labels->name; ?><br>
        		<?php $i++; ?>
                <?php } ?>
		</p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['em_theme'] = $new_instance['em_theme']; 
		$instance['em_period'] = $new_instance['em_period']; 
		$instance['em_duration'] = $new_instance['em_duration']; 
		$instance['em_avatar_style'] = $new_instance['em_avatar_style'];
		$instance['em_post_types'] = $new_instance['em_post_types'];
		$instance['count'] = (int)$new_instance['count'];
		return $instance;
	}
	public function widget( $args, $instance ) {
	 extract($args, EXTR_SKIP);
 
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title)){
      echo $before_title . $title . $after_title;
	  }
	  
	if ( isset( $instance[ 'em_theme' ] ) ) {
			$theme = $instance[ 'em_theme' ];
		}else{
			$theme = 'list';
		}
		if ( isset( $instance[ 'em_period' ] ) ) {
			$period = $instance[ 'em_period' ];
		}else{
			$period = 'week';
		}
		if ( isset( $instance[ 'em_duration' ] ) ) {
			$duration = $instance[ 'em_duration' ];
		}else{
			$duration = '1';
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}else{
			$count = 10;
		}

		if ( isset( $instance[ 'em_avatar_style' ] ) ) {
			$em_avatar_style = $instance[ 'em_avatar_style' ];
		}
		
		if ( isset( $instance[ 'em_post_types' ] ) ) {
			$em_post_types = $instance[ 'em_post_types' ];
			$em_post_types = "'".implode("', '",array_keys( $em_post_types))."'";
		}else{
			$em_post_types = 'post';
		}

	
	echo do_shortcode('[emembers theme="'.$theme.'" period="'.$period.'" duration="'.$duration.'"  limit="'.$count.'" type="'.$em_post_types.'"]');
	
	
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget( "elitemembers_widget" );' ) );