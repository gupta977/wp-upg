<?php
function upg_product_content($post)
{
	$options = get_option('upg_settings');
	
	
	$text=wpautop( stripslashes ($post->post_content));
	
	require_once(upg_BASE_DIR."layout/media/header.php");
	$abc="";
	 $home = home_url('/');
	ob_start ();
	$image=upg_image_src('large',$post);
	$image_medium=upg_image_src('medium',$post);
	$post_status=get_post_status();
	$author = get_user_by('id', get_the_author_meta( 'ID' ));
	//echo $author->first_name;
	//echo $author->user_nicename;
	
	
include(upg_BASE_DIR."layout/media/shop/content.php");

	$abc=ob_get_clean (); 
	return $abc;
}
