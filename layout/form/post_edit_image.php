<?php
if(isset($options['editor']) && $options['editor']=='1' )
	$editor=true;
else
	$editor=false;	


$title='';

$abc="";
ob_start ();
if (isset($_POST['user-submitted-title'], $_POST['upg-nonce']) && !empty($_POST['user-submitted-title']) && wp_verify_nonce($_POST['upg-nonce'], 'upg-nonce')) 
$title=sanitize_text_field($_POST['user-submitted-title']);

	if($title=='')
{
		if($layout=="personal")
		{
			if(file_exists(upg_BASE_DIR."/layout/form/".$layout."/".get_current_blog_id()."_".$layout."_edit_form.php"))
			{
				include(upg_BASE_DIR."/layout/form/".$layout."/".get_current_blog_id()."_".$layout."_edit_form.php");
			}
			else
			{
				echo __('Refresh Page','wp-upg').": ".$layout;
				upg_auto_create_file('personal','form','personal_edit_form');
			}

		}
		else
		{
			if(file_exists(upg_BASE_DIR."/layout/form/".$layout."/".$layout."_edit_form.php"))
			{
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if ( is_plugin_active( 'wp-upg-pro/wp-upg-pro.php' ) ) 
				{
				include(upg_BASE_DIR."/layout/form/".$layout."/".$layout."_edit_form.php");
				}
				else 
				{
					echo "Edit option is available only to <a href='https://odude.com/product/wp-upg-pro/'>UPG Pro version</a>.<br> You can hide this button at UPG Grid settings.";
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
		$author = ''; $url = ''; $email = ''; $tags = ''; $captcha = ''; $verify = ''; $content = ''; $category = ''; 
	
		$files = array();
		if (isset($_FILES['user-submitted-image']))
		{
			$files = $_FILES['user-submitted-image'];
		
		}
		
		
		
		if (isset($_POST['user-submitted-content']))  $content  = upg_sanitize_content($_POST['user-submitted-content']);
		if (isset($_POST['cat'])) $category = intval($_POST['cat']);
		if (isset($_POST['tags'])) $tags = $_POST['tags'];
		
		$content=str_replace("[","[[",$content);
		$content=str_replace("]","]]",$content);
		
		$result = upg_update_post($post_id,$title, $files, $content, $category,$tags);
		
		if($result)
		{
			echo "<h2>".__('Successfully updated.','wp-upg')."</h2>";
			
			//Submit files
			upg_include_deps();
			if(isset($files['tmp_name'][0]))
					$check_file_exist=$files['tmp_name'][0];
				else
					$check_file_exist="";
			
				if(!empty($check_file_exist) || $options['image_required']=='1')
				{
					$file_data = upg_check_images($files);
					$file_count = $file_data['file_count'];
					//error_log("Checking file");
				}
				$attach_ids = array();
				if ($files && !empty($check_file_exist)) 
				{
					//error_log("Ready for file processing");
					$key = apply_filters('upg_file_key', 'user-submitted-image-{0}');
				
					$_FILES[$key] = array();
					$_FILES[$key]['name']     = $files['name'][0];
					$_FILES[$key]['tmp_name'] = $files['tmp_name'][0];
					$_FILES[$key]['type']     = $files['type'][0];
					$_FILES[$key]['error']    = $files['error'][0];
					$_FILES[$key]['size']     = $files['size'][0];
					
					 $attach_id = media_handle_upload($key, $post_id);
					if (!is_wp_error($attach_id) && wp_attachment_is_image($attach_id)) 
					{
						//Delete old file from server
						$old_attachid=get_post_meta( $post_id, 'pic_name', true );
						wp_delete_attachment($old_attachid);
						
						$attach_ids[] = $attach_id;
						update_post_meta($post_id, 'pic_name', $attach_id);
						//error_log("update post meta ".$attach_id);
						
						
					} 
					else 
					{
						//error_log("cannot upload");
						//wp_delete_attachment($attach_id);
						echo __('Error in Image file. Image not updated.','wp-upg');
					} 
					
					
			
					
				}
				else
				{
					//error_log("No files to upload");
				}
			
			//echo "<br><br><a href='".esc_url( get_permalink($post_id) )."' class=\"pure-button\">".__('View','wp-upg')."</a> ";
					
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

//ob_flush();	

$abc=ob_get_clean (); 
return $abc;
?>