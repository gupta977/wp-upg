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
	$image_full=upg_image_src('full',$post);
	
	$author = get_user_by('id', get_the_author_meta( 'ID' ));
	//echo $author->first_name;
	//echo $author->user_nicename;
	
	
	//For older version 1.55 and before
	//Rename old file upg_media_personal into upg_media_content and delete created content
	$upload_dir = wp_upload_dir();
	 $old_file = $upload_dir['basedir'].'/upg_media_personal.php';
	 $new_file = $upload_dir['basedir'].'/upg_media_content.php';
	 
	 $new_content_file=upg_BASE_DIR."layout/media/personal/".get_current_blog_id()."_content.php";
	 
	  if(file_exists( $old_file ) )
	  {
		unlink($new_content_file);
		rename($old_file,$new_file);
		echo "Rename old upg_media_personal into upg_media_content";
	  }
	  else
	  {
		 upg_auto_create_file('personal','media','content'); 
		 $contnet_file=upg_BASE_DIR."layout/media/personal/".get_current_blog_id()."_content.php";
		  if(file_exists( $contnet_file ) )
		{
			include($contnet_file);
		}
		else
		{
			echo "Refresh page again, if the same message reappeared means that your folder is not writable. Go to UPG dashboard and click on help menu for more details.";
		}
		 
	  }
	 
	 
	
	

	$abc=ob_get_clean (); 
	return $abc;
}
?>