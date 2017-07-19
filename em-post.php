<?php

function em_template_compact()
{	
	$em_text_limit	=	get_option(  'em_text_limit' );
	if(empty($em_text_limit))
	{
		$em_text_limit = "150";
	}
	$em_bg_color	=	get_option(	 'em_bg_color' );
	$em_text_color	=	get_option(  'em_text_color' );
	$em_t_color		=	get_option(  'em_t_color' );
	$em_th_color	=	get_option(  'em_th_color' );
	$em_def_msg		=	get_option(  'em_def_msg' );
	$em_avatar_style=	get_option(  'em_avatar_style' );
	$em_avatar_size=	get_option(  'em_avatar_size' );
	$em_box_title		=		get_option(  'em_box_title' );
	$style= '';
	if($em_avatar_style == 'circle')
	{
		$style="
		-moz-border-radius: 74px;
		-webkit-border-radius: 74px;
		border-radius: 74px;";
	}
	
	if(empty($em_avatar_size))
	{
		$em_avatar_size = 100;
	}
	
			if(empty($em_text_color))
			{
				$em_text_color = "dddddd";
			}
			if(empty($em_th_color))
			{
				$em_th_color = "FFF838";
			}
			if(empty($em_bg_color))
			{
				$em_bg_color = "333333";
			}
			if(empty($em_t_color))
			{
				$em_t_color = "FFFFFF";
			}
		$author = get_the_author_meta('ID');
		$name	= get_the_author_meta('display_name');
		$link	= get_author_posts_url($author);
		$em_fb_id = get_user_meta( $author, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $author, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $author, 'em_tw_id', true );
		$em_li_id = get_user_meta( $author, 'em_li_id', true );
		$description = get_user_meta( $author, 'description', true );
		if(empty($description)){
			$description = $em_def_msg;
		}
		$description = substr($description,0,$em_text_limit).' <a href="'.$link.'" class="em-read-more">'.__('Read More','elite-members').'</a>';
		
	$output	='';
	$output.='<style type="text/css">';
	$output.='
	.em_compact .em_avatar img{border:#f5f5f5 solid 5px; '.$style.'}
	.em_compact .em_box{background:#'.$em_bg_color.';color:#'.$em_text_color.';}
	.em_compact .em_box h2{color:#'.$em_text_color.' !important;}
	.em_compact .em_box a{color:#'.$em_t_color.';}
	.em_compact .em_box a:hover{color:#'.$em_th_color.';}
	';
	
	$output.='</style>';
	$output.='<div class="em_compact">';
	$output.='<div class="em_social">';
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
		
	$output.='</div>';
	$output.='<div class="em_box">';
	$output.= '<div class="em_avatar">';
		if(function_exists('get_avatar')){
		$output.= get_avatar( $author, $em_avatar_size );
		}
		$output.='</div>';
	$output.='<div class="em_info">';
	$output.='<h2>'.$em_box_title.'&nbsp;<a href="'.$link.'">'.$name.'</a></h2>';
	$output.= $description;
	$output.='</div>';
	$output.='<div class="em_clr"></div>';
	$output.='</div>';
	$output.='<div class="em_clr"></div>';
	$output.='</div>';
	return $output;
}

function em_template_standard()
{	
	$em_text_limit	=	get_option(  'em_text_limit' );
	if(empty($em_text_limit))
	{
		$em_text_limit = "150";
	}
	$em_bg_color	=	get_option(	 'em_bg_color' );
	$em_text_color	=	get_option(  'em_text_color' );
	$em_t_color		=	get_option(  'em_t_color' );
	$em_th_color	=	get_option(  'em_th_color' );
	$em_def_msg		=	get_option(  'em_def_msg' );
	$em_avatar_style=	get_option(  'em_avatar_style' );
	$em_avatar_size=	get_option(  'em_avatar_size' );
	$em_box_title		=		get_option(  'em_box_title' );
	$style= '';
	if($em_avatar_style == 'circle')
	{
		$style="
		-moz-border-radius: 74px;
		-webkit-border-radius: 74px;
		border-radius: 74px;";
	}
	if(empty($em_avatar_size))
	{
		$em_avatar_size = 129;
	}
			if(empty($em_text_color))
			{
				$em_text_color = "dddddd";
			}
			if(empty($em_th_color))
			{
				$em_th_color = "FFF838";
			}
			if(empty($em_bg_color))
			{
				$em_bg_color = "333333";
			}
			if(empty($em_t_color))
			{
				$em_t_color = "FFFFFF";
			}
		$author = get_the_author_meta('ID');
		$name	= get_the_author_meta('display_name');
		$link	= get_author_posts_url($author);
		$rss_link= get_author_feed_link($author);
		$em_fb_id = get_user_meta( $author, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $author, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $author, 'em_tw_id', true );
		$em_li_id = get_user_meta( $author, 'em_li_id', true );
		$description = get_user_meta( $author, 'description', true );
		if(empty($description)){
			$description = $em_def_msg;
		}
		$description = substr($description,0,$em_text_limit).' <a href="'.$link.'" class="em-read-more">'.__('Read More','elite-members').'</a>';
		
	$output	='';
	$output.='<style type="text/css">';
	$output.='
	.em_standard .em_avatar img{border:#f5f5f5 solid 10px; '.$style.'}
	';
	
	$output.='</style>';
	$output.='<div class="em_standard">';
		$output.= '<div class="em_avatar">';
		if(function_exists('get_avatar')){
		$output.= get_avatar( $author, $em_avatar_size );
		}
		$output.='</div>';
	$output.='<div class="em_box">';
	$output.='<div class="em_social">';
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
	
	$output.='<div class="em_info">';
	$output.= '<h2>'.$em_box_title.'&nbsp;<a href="'.$link.'">'.$name.'</a></h2>';
	$output.= $description;
	$output.='</div>';
	
	$output.='</div>';
	$output.='<div class="em_clr"></div>';
	$output.='</div>';
	return $output;
}
function em_template_gosocial()
{	
	$em_text_limit	=	get_option(  'em_text_limit' );
	if(empty($em_text_limit))
	{
		$em_text_limit = "150";
	}
	$em_bg_color	=	get_option(	 'em_bg_color' );
	$em_text_color	=	get_option(  'em_text_color' );
	$em_t_color		=	get_option(  'em_t_color' );
	$em_th_color	=	get_option(  'em_th_color' );
	$em_def_msg		=	get_option(  'em_def_msg' );
	$em_avatar_style=	get_option(  'em_avatar_style' );
	$em_avatar_size=	get_option(  'em_avatar_size' );
	$em_box_title		=		get_option(  'em_box_title' );
	$style= '';
	if($em_avatar_style == 'circle')
	{
		$style="
		-moz-border-radius: 74px;
		-webkit-border-radius: 74px;
		border-radius: 74px;";
	}
	if(empty($em_avatar_size))
	{
		$em_avatar_size = 129;
	}
			if(empty($em_text_color))
			{
				$em_text_color = "dddddd";
			}
			if(empty($em_th_color))
			{
				$em_th_color = "FFF838";
			}
			if(empty($em_bg_color))
			{
				$em_bg_color = "333333";
			}
			if(empty($em_t_color))
			{
				$em_t_color = "FFFFFF";
			}
		$author = get_the_author_meta('ID');
		$name	= get_the_author_meta('display_name');
		$link	= get_author_posts_url($author);
		$rss_link= get_author_feed_link($author);
		$em_fb_id = get_user_meta( $author, 'em_fb_id', true );
		$em_gp_id = get_user_meta( $author, 'em_gp_id', true );
		$em_tw_id = get_user_meta( $author, 'em_tw_id', true );
		$em_li_id = get_user_meta( $author, 'em_li_id', true );
		$description = get_user_meta( $author, 'description', true );
		if(empty($description)){
			$description = $em_def_msg;
		}
		$description = substr($description,0,$em_text_limit).' <a href="'.$link.'">'.__('Read More','elite-members').'</a>';
		
	$output	='';
	$output.='<style type="text/css">';
	$output.='
	.em_gosocial .em_avatar img{border:#f5f5f5 solid 10px; '.$style.'}
	.em_gosocial .em_social a{'.$style.'}
	';
	
	$output.='</style>';
	$output.='<div class="em_gosocial">';
		$output.= '<div class="em_avatar">';
		if(function_exists('get_avatar')){
		$output.= get_avatar( $author, $em_avatar_size );
		}
		$output.='</div>';
	$output.='<div class="em_box">';
	$output.='<div class="em_social">';
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
		
		//$output.= '<a href="'.$rss_link.'" class="rs"></a>';
		$output.='<div class="em_clr"></div>';
	$output.='</div>';
	
	$output.='<div class="em_info">';
	$output.= '<h2>'.$em_box_title.'&nbsp;<a href="'.$link.'">'.$name.'</a></h2>';
	$output.= $description;
	$output.='</div>';
	
	$output.='</div>';
	$output.='<div class="em_clr"></div>';
	$output.='</div>';
	return $output;
}
function em_list_posttypes()
	{
		$options = array();
		$options = get_option('em_posttypes');
		$post_types = array();
		foreach($options as $key=>$value)
		{
			array_push($post_types, $key);
		}
		return $post_types;
	}
	
add_filter( 'the_content', 'em_add_to_post', 20 );
add_shortcode( 'em_compact', 'em_template_compact' );
add_shortcode( 'em_standard', 'em_template_standard' );
add_shortcode( 'em_social', 'em_template_gosocial' );
function em_add_to_post( $content ) {
   $em_auto_insert=	get_option(  'em_auto_insert' );
   
   if( $em_auto_insert == 1){
   		$options = em_list_posttypes();
		$style	= 	get_option(  'em_display_types' );
		if ( is_singular($options) ){	
			switch($style){
			case 'compact':
			$content = $content.em_template_compact();
			break;
			case 'standard':
			$content = $content.em_template_standard();
			break;
			case 'go_social':
			$content = $content.em_template_gosocial();
			break;
			case 'disabled':
			$content = $content;
			break;
			default:			
			$content = $content.em_template_standard();
			}
			
		}
	}
    return $content;
}