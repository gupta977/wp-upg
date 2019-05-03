<style>
.upg_basic_title{
	font-family: 'Francois One', Tahoma, Verdana, Arial;
	line-height: 1.4em;
	word-wrap: break-word;
	font-size: 2.0em;
	text-decoration: none;
	letter-spacing: 0.05em;
	text-shadow: 2px 2px 2px rgba(0,0,0,0.3);
	
}
.upg-desp{
	color:#070342;
	font-size:1.0em;
	
	
}
.upg-profile-name{
	color:#999;
}

.avatar {
border-radius: 50%;
-moz-border-radius: 50%;
-webkit-border-radius: 50%;
}
</style>

							
<?php


function upg_product_content($post)
{
	$text=wpautop( stripslashes ($post->post_content));
	
	require_once(upg_BASE_DIR."layout/media/header.php");
	$abc="";
	 $home = home_url('/');
	ob_start ();
	$image=upg_image_src('large',$post);

	//Make image blank, if noimg.png is found in url.
	if (stripos($image,'noimg.png') !== false) 
	{
		$image=upg_PLUGIN_URL.'/images/spacer.png';
	}
	
	$author = get_user_by('id', get_the_author_meta( 'ID' ));
	//echo $author->first_name;
	//echo $author->user_nicename;
	$post_status=get_post_status();
	include(upg_BASE_DIR."layout/media/basic/content.php");
	
	$abc=ob_get_clean (); 
	return $abc;
}
