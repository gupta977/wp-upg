<?php

//Checks if current theme page is of upg
function is_upg() {
    return apply_filters( 'is_upg', is_upg_gallery() || is_upg_preview());
}

function is_upg_gallery()
{
	$main_page=upg_get_option( 'main_page','upg_gallery', '0' );
	if(is_page() && is_page($main_page))
	{
		//upg_log("upg page");
		return true;
	}
	return false;
}

function is_upg_preview()
{
	global $post;      
	if($post->post_type!='upg')
	return false;     
     	
       if( is_singular() && is_main_query() ) 
	   {
			return true;
	   }
	return false;
}

//Check if upg-pro is activated
function is_upg_pro()
{
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if ( is_plugin_active( 'wp-upg-pro/wp-upg-pro.php' ) ) 
    {
		return true;
	}
	else
	{
		return false;
	}
}
?>