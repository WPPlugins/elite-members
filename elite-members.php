<?php	 	 
 /*
   Plugin Name: Elite Members
   Plugin URI: http://b4ucode.com
   Description: Elite Members - A WordPress plugin for the listing of users from Subscribers to Admin. Display users in a dynamic  list.
   Version: 1.0.3
   Author: B4uCode
   Author URI: http://b4ucode.com
   License: GPL2
   */

/*
* 	Initial Release
*/
include('admin/em-settings-page.php');
include('admin/em-user-fields.php');
include('admin/em-widgets.php');
include('em-post.php');
//Register Shortcode

//Get Users
function em_get_users($atts)
{
	extract( shortcode_atts( array(
		'role' => null,
		'period' => '',
		'duration' => '1',
		'exclude' => '',
		'orderby' => 'count',
		'bio' => 'true',
		'social' => 'true',
		'limit' => '10',
		'text' => 150,
		'theme' => 'list',
		'type' => '"post"',
		'size' => 50,
	), $atts ) );
	$order_options = array('name','count');
	if(!in_array($orderby,$order_options))
	{
		$orderby = 'count';
	}
	//Set Up Arguments for themes
	$args = array('size'=>$size,'social'=>$social,'text'=>$text);
	//
	global $wpdb;
 	$querystr="";
	$querystr.="SELECT 
				DISTINCT p.post_author,u.ID AS user_id, u.display_name AS name, COUNT(p.ID) AS count
				FROM $wpdb->posts AS p 
				LEFT JOIN $wpdb->users AS u ON p.post_author=u.ID";
	if($role){
	$querystr.=" INNER JOIN $wpdb->usermeta	ON u.ID = ".$wpdb->usermeta.".user_id ";	
	}
	$querystr.=" WHERE  p.post_type IN (".$type.") ";  
	
	switch($period){
	case 'day': //Today
		$querystr.=" AND p.post_date > DATE_SUB(NOW(), INTERVAL $duration DAY)";
	break;
	case 'week': //This Week
		$querystr.=" AND p.post_date > DATE_SUB(NOW(), INTERVAL $duration WEEK)";
	break;
	case 'month': //This Month
		$querystr.=" AND p.post_date > DATE_SUB(NOW(), INTERVAL $duration MONTH)";
	break;
	case 'year': //This Year
		$querystr.=" AND p.post_date > DATE_SUB(NOW(), INTERVAL $duration YEAR)";
	break;
	case 'old_month': //This Year
		$querystr.=" AND p.post_date BETWEEN date_format(NOW() - INTERVAL $duration MONTH, '%Y-%m-01') AND last_day(NOW() - INTERVAL 1 MONTH)";
	case 'old_week': //This Year
		//$querystr.=" p.post_date BETWEEN date_format(NOW() - INTERVAL -2 WEEK)";
	break;
	case 'today': //Today
		$querystr.=" AND p.post_date >= CURDATE()";
	break;
	default:
		//$querystr.=" p.post_date > DATE_SUB(NOW(), INTERVAL  $duration MONTH)";
	}
	if($role){
		$querystr.=" AND ".$wpdb->usermeta.".meta_key = '".$wpdb->prefix."capabilities'
			AND $wpdb->usermeta.meta_value LIKE '%$role%'";
	}
	if(!empty($exclude)){
		//$querystr.=" AND p.ID ";
	}
	$querystr.=" AND p.post_status =  'publish' GROUP BY p.post_author ORDER BY ".$orderby." DESC LIMIT 0, $limit";
	//echo $querystr;
	$results = $wpdb->get_results($querystr, OBJECT);
	$output ='';
	switch($theme){
	case 'grid': //Day
		$output.=em_template_grid($results,$args);
	break;
	case 'list': //Day
		$output.=em_template_list($results,$args);
	break;
	case 'mini': //Day
		$output.=em_template_mini_grid($results,$args);
	break;
	case 'minimal': //Day
		$output.=em_template_minimal($results,$args);
	break;
	default:
		$output.=em_template_list($results,$args);
	}
	
	return $output;
}
function em_template_list($items,$args=array())
{
	$em_def_msg		=	get_option(  'em_def_msg' );
	$size = $args['size'];
	$social = $args['social'];
	$text = $args['text'];
	$output ='';
	$output.='<div class="em_list_layout" id="em_list_layout">';
	foreach($items as $item)
	{
		$link = get_author_posts_url($item->user_id);
		$description = get_user_meta( $item->user_id, 'description', true );
		$em_fb_id = get_user_meta( $item->user_id, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $item->user_id, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $item->user_id, 'em_tw_id', true );
		$em_li_id = get_user_meta( $item->user_id, 'em_li_id', true );
		if(empty($description)){
			$description = $em_def_msg;
		}
		$description = substr($description,0,$text).' <a href="'.$link.'" class="em-read-more">'.__('Read More','elite-members').'</a>';
		$rss_link= get_author_feed_link($item->user_id);
		
		$output.= '<div class="em_auth_row">';
		$output.='<div class="em_author"><a href="'.get_author_posts_url($item->user_id).'">'.$item->name.'</a></div>';
		$output.='<div class="em_count"><span>'.$item->count.'</span> post(s)<!--<div class="em_count_inner">'.$item->count.'</div>--></div>';
		$output.='<div class="em_clr"></div>';
		$output.= '<div class="em_avatar">';
		if(function_exists('get_avatar')){
		$output.= get_avatar( $item->post_author, 65 );
		}else{
		
		}
		$output.='</div>';
		$output.= '<div class="em_auth_desc">';
		$output.= $description;
		$output.='</div>';
		
		$output.='<div class="em_clr"></div>';
		$output.= '<div class="em_auth_desc">';
		//Add Socila
		if($social){
		$output.= '<div class="em_social">';
		if($em_fb_id){
		$output.= '<a href="'.$em_fb_id.'" class="fb" alt="Facebook" target="_blank"></a>';
		}
		if($em_tw_id){
		$output.= '<a href="'.$em_tw_id.'" class="tw" alt="Twitter" target="_blank"></a>';
		}
		if($em_gp_id){
		$output.= '<a href="'.$em_gp_id.'" class="gp" alt="Google +" target="_blank"></a>';
		}
		if($em_li_id){
		$output.= '<a href="'.$em_li_id.'" class="li" alt="LinkedIn" target="_blank"></a>';
		}
		
		$output.= '<a href="'.$rss_link.'" class="rs"></a>';
		$output.='<div class="em_clr"></div>';
		}
		//End Social
		$output.='</div>';
		$output.='</div>';
		$output.='</div>';
	}
	$output.='</div>';
	return $output;
}
function em_template_grid($items,$args=array())
{
	$size = $args['size'];
	$social = $args['social'];
	$text = $args['text'];
	$output ='';
	$output.='<div class="em_grid_layout" id="em_grid_layout">';
	foreach($items as $item)
	{
		$link = get_author_posts_url($item->user_id);
		$rss_link= get_author_feed_link($item->user_id);
		$description = get_user_meta( $item->user_id, 'description', true );
		$description = substr($description,0,$text).' <a href="'.$link.'" class="em-read-more">'.__('Read More','elite-members').'</a>';
		$em_fb_id = get_user_meta( $item->user_id, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $item->user_id, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $item->user_id, 'em_tw_id', true );
		$em_li_id = get_user_meta( $item->user_id, 'em_li_id', true );
		$output.= '<div class="em_auth_row">';
		$output.= '<div class="em_avatar">';
		if(function_exists('get_avatar')){
		$output.= get_avatar( $item->post_author, 200 );
		}else{
		
		}
		
		$output.='<div class="em_author"><h2><a href="'.get_author_posts_url($item->user_id).'">'.$item->name.'</a></h2></div>';
		$output.='<div class="em_count" xx-user-id="'.$item->user_id.'"><div class="em_count_inner">'.$item->count.' post(s)</div></div>';
		$output.='';
		$output.='</div>';
		$output.='<div class="em_clr"></div>';
		$output.= '<div class="em_auth_desc">';
		//Social
		if($social){
		$output.= '<div class="em_social">';
		if($em_fb_id){
		$output.= '<a href="'.$em_fb_id.'" class="fb" alt="Facebook" target="_blank"></a>';
		}
		if($em_tw_id){
		$output.= '<a href="'.$em_tw_id.'" class="tw" alt="Twitter" target="_blank"></a>';
		}
		if($em_gp_id){
		$output.= '<a href="'.$em_gp_id.'" class="gp" alt="Google +" target="_blank"></a>';
		}
		if($em_li_id){
		$output.= '<a href="'.$em_li_id.'" class="li" alt="LinkedIn" target="_blank"></a>';
		}
		
		$output.= '<a href="'.$rss_link.'" class="rs"></a>';
		$output.='<div class="em_clr"></div>';
		$output.='</div>';
		}
		$output.='</div>';
		$output.='</div>';
	}
	$output.='<div class="em_clr"></div>';
	$output.='</div>';
	return $output;
}
function em_template_mini_grid($items,$args=array())
{

	$size = $args['size'];
	$social = $args['social'];
	$text = $args['text'];

	$output ='';
	$output.='<div class="em_mini_layout" id="em_mini_layout">';
	foreach($items as $item)
	{
		$link = get_author_posts_url($item->user_id);
		$rss_link= get_author_feed_link($item->user_id);
		$description = get_user_meta( $item->user_id, 'description', true );
		$description = substr($description,0,$text).' <a href="'.$link.'" class="em-read-more">'.__('Read More','elite-members').'</a>';
		$em_fb_id = get_user_meta( $item->user_id, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $item->user_id, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $item->user_id, 'em_tw_id', true );
		$em_li_id = get_user_meta( $item->user_id, 'em_li_id', true );
		$output.= '<div class="em_auth_row">';
		$output.= '<div class="em_avatar"><a href="'.get_author_posts_url($item->user_id).'" class="em_title" original-title="'.$item->name.'&nbsp;&nbsp;'.$item->count.' post(s)">';
		if(function_exists('get_avatar')){
		$output.= get_avatar( $item->post_author, $size );
		}
		$output.='<a>';
		$output.='</div>';
		$output.='<div class="em_clr"></div>';
		$output.= '<div class="em_auth_desc">';
		if($social){
		$output.= '<div class="em_social">';
		if($em_fb_id){
		$output.= '<a href="'.$em_fb_id.'" class="fb" alt="Facebook" target="_blank"></a>';
		}
		if($em_tw_id){
		$output.= '<a href="'.$em_tw_id.'" class="tw" alt="Twitter" target="_blank"></a>';
		}
		if($em_gp_id){
		$output.= '<a href="'.$em_gp_id.'" class="gp" alt="Google +" target="_blank"></a>';
		}
		if($em_li_id){
		$output.= '<a href="'.$em_li_id.'" class="li" alt="LinkedIn" target="_blank"></a>';
		}
		
		$output.= '<a href="'.$rss_link.'" class="rs"></a>';
		$output.='<div class="em_clr"></div>';
		$output.='</div>';
		}
		$output.='</div>';
		$output.='</div>';
	}
	$output.='<div class="em_clr"></div>';
	$output.='</div>';
	return $output;
}
function em_template_minimal($items,$args=array())
{
	$size = $args['size'];
	$social = $args['social'];
	$output ='';
	$output.='<div class="em_minimal_layout" id="em_minimal_layout">';
	foreach($items as $item)
	{	
		$link = get_author_posts_url($item->user_id);
		$rss_link= get_author_feed_link($item->user_id);
		$em_fb_id = get_user_meta( $item->user_id, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $item->user_id, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $item->user_id, 'em_tw_id', true );
		$em_li_id = get_user_meta( $item->user_id, 'em_li_id', true );
		$output.= '<div class="em_auth_row">';
		$output.='<div class="em_author"><a href="'.get_author_posts_url($item->user_id).'">'.$item->name.'</a></div>';
		$output.='<div class="em_count"><span>'.$item->count.'</span> post(s)<!--<div class="em_count_inner">'.$item->count.'</div>--></div>';
		$output.='<div class="em_clr"></div>';
		//Social
		if($social == true){
		$output.= '<div class="em_social">';
		if($em_fb_id){
		$output.= '<a href="'.$em_fb_id.'" class="fb" alt="Facebook" target="_blank"></a>';
		}
		if($em_tw_id){
		$output.= '<a href="'.$em_tw_id.'" class="tw" alt="Twitter" target="_blank"></a>';
		}
		if($em_gp_id){
		$output.= '<a href="'.$em_gp_id.'" class="gp" alt="Google +" target="_blank"></a>';
		}
		if($em_li_id){
		$output.= '<a href="'.$em_li_id.'" class="li" alt="LinkedIn" target="_blank"></a>';
		}
		
		$output.= '<a href="'.$rss_link.'" class="rs"></a>';
		$output.='<div class="em_clr"></div>';
		$output.='</div>';
		}
		$output.='</div>';
	}
	$output.='</div>';
	return $output;
}
add_shortcode( 'emembers', 'em_get_users' );


function em_add_js()
{
	
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'em-tipsy', plugins_url( '/js/jquery.tipsy.js', __FILE__ ) );
	wp_enqueue_script( 'em-tipsy' );
	
	wp_register_script( 'em-scripts', plugins_url( '/js/em-scripts.js', __FILE__ ) );
	wp_enqueue_script( 'em-scripts' );
	
	wp_register_style( 'em-grid-css', plugins_url( '/css/grid.css', __FILE__ ), array(), '20120208', 'all' );
	wp_enqueue_style( 'em-grid-css' );

}

add_action( 'wp_enqueue_scripts', 'em_add_js' );
