<?php
if(isset($options['editor']) && $options['editor']=='1' )
	$editor=true;
else
	$editor=false;	


$title='';

$abc="";
ob_start ();
if (isset($_POST['user-submitted-title'], $_POST['upg-nonce']) && !empty($_POST['user-submitted-url']) && wp_verify_nonce($_POST['upg-nonce'], 'upg-nonce')) 
{
$title=sanitize_text_field($_POST['user-submitted-title']);
$url=sanitize_text_field($_POST['user-submitted-url']);
}
	if($title=='')
{
	
	if($layout=="personal")
		{
			if(file_exists(upg_BASE_DIR."/layout/form/".$layout."/".get_current_blog_id()."_".$layout."_edit_youtube.php"))
			{
				include(upg_BASE_DIR."/layout/form/".$layout."/".get_current_blog_id()."_".$layout."_edit_youtube.php");
			}
			else
			{
				echo __('Updating personal edit form layout. Refresh page again.','wp-upg').": ".$layout;
				upg_auto_create_file('personal','form','personal_edit_youtube');
			}
		}
		else
		{
			if(file_exists(upg_BASE_DIR."/layout/form/".$layout."/".$layout."_edit_form.php"))
			{
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if ( is_plugin_active( 'wp-upg-pro/wp-upg-pro.php' ) ) 
				{
					include(upg_BASE_DIR."/layout/form/".$layout."/".$layout."_edit_youtube.php");
				}
				else 
				{
					echo "Edit layout is available only to UPG Pro version.";
				}
				
			}
				else
			{
				echo __('Edit Layout Not Found.','wp-upg').": ".$layout;
			}
		}


}
else
{
		$author = ''; ; $email = ''; $tags = ''; $captcha = ''; $verify = ''; $content = ''; $category = '';
	
				
		if (isset($_POST['user-submitted-content']))  $content  = upg_sanitize_content($_POST['user-submitted-content']);
		if (isset($_POST['cat'])) $category = intval($_POST['cat']);
		
		$content=str_replace("[","[[",$content);
		$content=str_replace("]","]]",$content);
		
		
		$result = upg_update_post($post_id,$title, '', $content, $category);
		
		if($result)
		{
			echo "<h2>".__('Successfully updated.','wp-upg')."</h2>";
			
			//update video url
			if(upg_getid_youtube($url)=='')
			{
				echo __('Error in Video URL','wp-upg');
			}
			else
			{
				update_post_meta($post_id, 'youtube_url', $url);
			}
		}
		else
		{
			echo "error";
		}
		
	?>

	<?php
}
$abc=ob_get_clean (); 
return $abc;
?>