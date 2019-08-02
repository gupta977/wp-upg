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
				echo __('Refresh Page','wp-upg').": ".$layout;
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
					echo "Edit layout is available only to <a href='https://odude.com/product/wp-upg-pro/'>UPG Pro version</a>.";
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
		if (isset($_POST['tags'])) $tags = $_POST['tags'];
		
		$content=str_replace("[","[[",$content);
		$content=str_replace("]","]]",$content);
		
		//upg_log($tags);
		$result = upg_update_post($post_id,$title, '', $content, $category,$tags);
		
		if($result)
		{
			echo "<h2>".__('Successfully updated.','wp-upg')."</h2>";
			
			//update video url
			if(upg_allowed_embed_url($url)=='')
			{
				echo "<h2>".__('Error in oEmbed URL','wp-upg')."</h2>";
			}
			else
			{
				update_post_meta($post_id, 'youtube_url', $url);
			}

			$edit_link=esc_url( add_query_arg( 'upg_id', $post_id, get_permalink(upg_get_option( 'edit_upg_page','upg_form', '0' )) ) );
					
					echo "<a href='".$edit_link."' class=\"pure-button\">".__('Edit','wp-upg')."</a> ";

					if(upg_get_option( 'my_gallery','upg_gallery', '0' )!='0')
					{
    					echo "<a href='".esc_url( get_page_link( upg_get_option( 'my_gallery','upg_gallery', '0' ) ) )."' class=\"pure-button\">".__('My Gallery','wp-upg')."</a><br><br>";
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