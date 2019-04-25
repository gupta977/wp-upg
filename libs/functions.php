<?php

//Imports UPG's layout zip file. This is used at layout editor page. Files are uploaded into wordpress's upload /upg/ folder 
function upg_upload_file( $file = array(),$path ) 
{
    if(!empty($file)) 
    {


        $upload_dir=$path;
        $uploaded=move_uploaded_file($file['tmp_name'], $upload_dir.$file['name']);
        if($uploaded) 
        {
            echo "<div class='updated notice is-dismissible'><p>Uploaded successfully</p></div>";

        }else
        {
            echo "<div class='error notice is-dismissible'><p>Some error in upload</p></div> " ;
			print_r($file['error']);  
        }
    }

}

//List the tags created in UPG dashboard. Currently this function is used at content.php of layout/media folder.
function upg_list_tags($post)
{
	//Returns All Term Items for "my_taxonomy"
	$term_list = wp_get_post_terms($post->ID, 'upg_tag', array("fields" => "all"));
	//var_dump($term_list);
	
	if(count($term_list)>0)
	echo '<div class="meta-tags clearfix"><ul>';

	for($x = 0; $x < count($term_list); $x++) 
	{
		
				$page_settings = get_option( 'upg_settings' );
				$link = get_permalink( $page_settings['main_page'] );
				$link = add_query_arg( "upg_tag", $term_list[$x]->slug, $link );
				
				
		echo '<li><a href="'.$link.'" rel="tag">'.$term_list[$x]->name.'</a></li>';
	}
	
	if(count($term_list)>0)
		echo '</ul></div>';
	
}


//returns album/category url. 'upg_cate' is $taxonomy. $term is a album slug name.
function upg_get_category_page_link( $term, $taxonomy ) 
{

	$page_settings = get_option( 'upg_settings' );
	
	$link = '/';
	
	if( $page_settings['main_page'] > 0 ) {
		$link = get_permalink( $page_settings['main_page'] );
	
		if( '' != get_option( 'permalink_structure' ) ) 
		{
    		$link = user_trailingslashit( trailingslashit( $link ) . $term->slug );
			//$link = add_query_arg( $taxonomy, $term->slug, $link );
  		} 
		else 
		{
			//echo "----------------";
    		$link = add_query_arg( $taxonomy, $term->slug, $link );
			
  		}
	}
  
	return $link;

}

//Sanitize the $content. 
function upg_sanitize_content($content) 
{
	$allowed_tags = wp_kses_allowed_html('post');
	return wp_kses(stripslashes($content), $allowed_tags);
}


//Before posting, assigning required metadata to the post.
function upg_prepare_post($title, $content) 
{
	$options = get_option('upg_settings');
	
	$postData = array();
	$postData['post_title']   = $title;
	$postData['post_content'] = $content;
	$postData['post_author']  = upg_get_author();
	$postData['post_type']  = 'upg';
	
	if(isset($options['publish']) && $options['publish']=='1' )
	$postData['post_status'] = 'publish';
	
	return apply_filters('upg_post_data', $postData);
}

//Returns author ID of logged in user. If not returns the id of default user in UPG settings. 
function upg_get_author() 
{
	if ( is_user_logged_in() )
	{
		$author_id =get_current_user_id();
	} 
	else 
	{
		$options = get_option('upg_settings');
			if(!isset($options['guest_user']))
			$options['guest_user']="";
		$author_id =$options['guest_user'];
	}	
	
	
	return $author_id;
}

//Including the files used during the time of file upload. It is required to get default wordpress file handling. 
function upg_include_deps() 
{
	if (!function_exists('media_handle_upload')) {
		require_once (ABSPATH .'/wp-admin/includes/media.php');
		require_once (ABSPATH .'/wp-admin/includes/file.php');
		require_once (ABSPATH .'/wp-admin/includes/image.php');
	}
}

//During image upload process, it check the file is valid image type. 
function upg_check_images($files) 
{
	global $upg_options;
	
	$temp = false; $errr = false; $error = array();
	
	if (isset($files['tmp_name'])) $temp = array_filter($files['tmp_name']);
	if (isset($files['error']))    $errr = array_filter($files['error']);
	
	$file_count = 0;
	if (!empty($temp)) 
	{
		foreach ($temp as $key => $value) if (is_uploaded_file($value)) $file_count++;
	}
	if (true) 
	{
		
		//if ($file_count > 1) $error[] = 'file-max';
		
		$i=0;
			
			$image = @getimagesize($temp[$i]);
			
			if (false === $image) 
			{
				$error[] = 'file-type';
				//error_log("Check file size");
				//break;
			} 
			else 
			{
				if (function_exists('exif_imagetype')) 
				if (isset($temp[$i]) && !exif_imagetype($temp[$i])) 
				{
					$error[] = 'exif_imagetype';
					//break;
				}
					
				
			}

			//$file = wp_max_upload_size( $temp[$i] );
		//	if ( $file['error'] != '0' )
			//{
			//	if($temp[$i] < wp_max_upload_size())
			//	$error[] = 'max-filesize';
			//} 
		
	}
	else 
	{
		$files = false;
	}
	$file_data = array('error' => $error, 'file_count' => $file_count);
	return $file_data;
}		


//It is used during submission of video url. Used at post_youtube.php
//$title : title of the video
//$url : url of the video (youtube & vimeo only)
//$content: description 
//$category: UPG album slug name
//$preview: assign preview layout for current post.
function upg_submit_url($title, $url, $content, $category,$preview)
{
	$newPost = array('id' => false, 'error' => false);
	$newPost['error'][] ="";
	
	if (empty($title))    $newPost['error'][] = 'required-title';
	if (empty($category)) $newPost['error'][] = 'required-category';
	//if (empty($content))  $newPost['error'][] = 'required-description';
	if (empty($url))  $newPost['error'][] = 'required-url';
	if ($category=='-1') $newPost['error'][] = 'required-category';
	if(upg_getid_youtube($url)=='') $newPost['error'][] = 'wrong-video-url';
		
	$newPost['error'][]=apply_filters('upg_verify_submit', "");
		//var_dump($newPost);

		
		foreach ($newPost['error'] as $e) 
	{
		if (!empty($e)) 
		{
			unset($newPost['id']);
			return $newPost;
		}
	}
	
	$postData = upg_prepare_post($title, $content);
	
	do_action('upg_insert_before', $postData);
	$newPost['id'] = wp_insert_post($postData);
	do_action('upg_insert_after', $newPost);
	
	if ($newPost['id']) 
	{
		$post_id = $newPost['id'];
		//wp_set_post_categories($post_id, array($category));

		//if($category>0)
		wp_set_object_terms($post_id, array($category),'upg_cate');

		
		add_post_meta($post_id, 'youtube_url', $url);
		
		//Assign preview layout
		add_post_meta($post_id, 'upg_layout', $preview);
		
	}
	
	return apply_filters('upg_new_post', $newPost);
	
	
}


//Update/edit the post with reference of post ID
function upg_update_post($post_id,$title, $files, $content, $category)
{
	$options = get_option('upg_settings');
	$updatePost['error'][] ="";
	if (empty($title))    $updatePost['error'][] = 'required-title';
	if (empty($category)) $updatePost['error'][] = 'required-category';
	$updatePost['error'][]=apply_filters('upg_verify_submit', "");
	$file_count=0;
	
	if(isset($options['publish']) && $options['publish']=='1' )
	{
		$new_post = array(
			'ID'           => $post_id,
			'post_title'   => $title,
			'post_content' => $content,
			'post_status' => 'publish',
		);
	}
	else
	{
	 $new_post = array(
      'ID'           => $post_id,
      'post_title'   => $title,
      'post_content' => $content,
	  'post_status' => 'draft',
	  );
	}


	// Update the post into the database
	$pid=wp_update_post( $new_post );
	if (is_wp_error($pid)) 
	{
		return false;
	}
	else
	{
		//Update post meta fields
		for ($x = 1; $x <= 5; $x++) 
		{
			if(isset($_POST["upg_custom_field_".$x]))
			{
			update_post_meta($post_id, "upg_custom_field_".$x, sanitize_text_field($_POST["upg_custom_field_".$x]));
			}
			else
			{
				update_post_meta($post_id, "upg_custom_field_".$x,'');
			}
		}
		
		
		
		//Set category
		if ($category=='-1') $updatePost['error'][] = 'required-category';
		wp_set_object_terms($post_id, array($category),'upg_cate');
	
			foreach ($updatePost['error'] as $e) 
			{
				if (!empty($e)) 
				{
					unset($updatePost['id']);
					return $updatePost;
				}
			}
			
	
	
		return true;
	}
	
	
	
}
	
//Submits new post. 
//$title = Title of post
//$files = files selected 
//$contet= Description 
//category =Album name
//$preview = layout name for post detail page. Not required if lightbox is enabled.
function upg_submit($title, $files, $content, $category, $preview)
{
	$options = get_option('upg_settings');
	$newPost = array('id' => false, 'error' => false);
	$newPost['error'][] ="";
	$file_count=0;
	if (empty($title))    $newPost['error'][] = 'required-title';
	if (empty($category)) $newPost['error'][] = 'required-category';
	//if (empty($content))  $newPost['error'][] = 'required-description';
	
	$newPost['error'][]=apply_filters('upg_verify_submit', "");
	
	if(isset($files['tmp_name'][0]))
		$check_file_exist=$files['tmp_name'][0];
	else
		$check_file_exist="";
	
		//It will only check file type only if the image upload compulsory is enabled in backend
	if(!empty($check_file_exist) || $options['image_required']=='1')
	{
		$file_data = upg_check_images($files, $newPost);
		$file_count = $file_data['file_count'];
		
		//echo "<h1>$file_count</h1>";
		
		$newPost['error'] = array_unique(array_merge($file_data['error'], $newPost['error']));
	}
		
	if ($category=='-1') $newPost['error'][] = 'required-category';
	
	foreach ($newPost['error'] as $e) 
	{
		if (!empty($e)) 
		{
			unset($newPost['id']);
			return $newPost;
		}
	}
	
	$postData = upg_prepare_post($title, $content);
	do_action('upg_insert_before', $postData);
	upg_include_deps();
		$i=0;
		if($file_count==0)
			$file_count=1;
		
		for ($x = 1; $x <= $file_count; $x++) 
		{
			$newPost['id'] = wp_insert_post($postData);
			if ($newPost['id']) 
			{
				//echo "Successfully added $x <hr>";
				$post_id = $newPost['id'];
				wp_set_object_terms($post_id, array($category),'upg_cate');
				
				$attach_ids = array();
				if ($files && !empty($check_file_exist)) 
				{
					$key = apply_filters('upg_file_key', 'user-submitted-image-{$i}');
				
					$_FILES[$key] = array();
					$_FILES[$key]['name']     = $files['name'][$i];
					$_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
					$_FILES[$key]['type']     = $files['type'][$i];
					$_FILES[$key]['error']    = $files['error'][$i];
					$_FILES[$key]['size']     = $files['size'][$i];
					
					$attach_id = media_handle_upload($key, $post_id);
					if (!is_wp_error($attach_id) && wp_attachment_is_image($attach_id)) 
					{
						$attach_ids[] = $attach_id;
						add_post_meta($post_id, 'pic_name', $attach_id);
						
						//Assign preview layout
						add_post_meta($post_id, 'upg_layout', $preview);
						
					} 
					else 
					{
						wp_delete_attachment($attach_id);
						wp_delete_post($post_id, true);
						$newPost['error'][] = 'upload-error';
						unset($newPost['id']);
						return $newPost;
					}
				$i++;
					
				}
				else
				{
					//Checking in setting if image is compulsory during submission.
					if($options['image_required']=='1')
					{
						$newPost['error'][] = 'no-files';
						
					}
				}				
				
			}
			else 
			{
				$newPost['error'][] = 'post-fail';
				
			}
			
		}
		
	do_action('upg_insert_after', $newPost);
	return $newPost;

}



//Gets link of post author with it's avatar icon. 
function upg_author($author,$redirect=true)
{
	$options = get_option('upg_settings');
	if(isset($options['main_page']))
	{
		if(isset($options['upg_ultimatemember_enable']) && $options['upg_ultimatemember_enable']=='1' && function_exists( 'um_user_profile_url' ) && $redirect )
		{
			$linku= um_user_profile_url($author->ID);
			$linku=esc_url( add_query_arg( 'profiletab', 'upg', $linku ) );
			
		}
		else if(isset($options['upg_buddypress_enable']) && $options['upg_buddypress_enable']=='1' && function_exists( 'bp_core_get_user_domain' ) && $redirect)
		{
			$linku= bp_core_get_user_domain($author->ID)."upg";
			
		}
		else
		{
		if ( get_option('permalink_structure') )
		$linku=esc_url( get_permalink($options['main_page'])."member/".$author->user_nicename );
		else
		$linku=esc_url( get_permalink($options['main_page'])."&user=".$author->user_nicename );
		}
	}
	else
	{
		$linku="";
	}
	
	return  '<div class=""><a href="'.$linku.'" title='.$author->display_name.'>'.get_avatar( $author->user_email, $size = '50').'</a></div><div class="upg-profile-name">'.$author->display_name.'</div>';

	//return '<span class="">Submitted by: <a href="'.$linku.'">'.$author->display_name.'</a></span><br>';
	
	//return '<a href="'.$linku.'">'.get_avatar( $author->user_email,32 ).'</a><br>'.$author->display_name;
}


//Icon container. Eg. Author icon, Delete icon, Edit icon
function upg_show_icon_grid()
{
	$icon = array();
	

	$list = '';
 
	if(has_filter('upg_add_icon_grid')) {
		$icon = apply_filters('upg_add_icon_grid', $icon);
	}
 
if(count($icon)>0)
	$list .= '<div class="upg_button_contain">';

 for($r=0;$r<count($icon);$r++)
{
		$nonce = wp_create_nonce($icon[$r][3]);
	
		if($icon[$r][0]!="")
		$list.= '<a class="'.$icon[$r][3].'" href="'.$icon[$r][2].'" title="'.$icon[$r][1].'" data-nonce="'. $nonce.'" data-post_id="' . $icon[$r][4] . '"><small><i class="'.$icon[$r][0].'"></i></small></a>';
		
}
 $list .= '</div>';
 
	return $list;
}

//Adds edit icon in upg icon container. 
function upg_add_extra_icon_grid_edit($icon)
{
	global $post; 
	$options = get_option('upg_settings');
		
	if(isset($options['edit_upg_page']))
	$edit_link=esc_url( add_query_arg( 'upg_id', $post->ID, get_permalink($options['edit_upg_page']) ) );
	else
		$edit_link="#";
	
	$extra_icon = array();
	
	if(get_the_author_meta('ID') == get_current_user_id())
	{
		if(isset($options['show_edit_icon']))
		{
			if($options['show_edit_icon']=="1")
			{
				$extra_icon = array
			  (
				array("fa fa-edit fa-fw fa-border","Edit",$edit_link,'',$post->ID),
								
			  );
			}
		}
	}
	
 
	// combine the two arrays
	if(is_array($extra_icon) && is_array($icon))
	$icon = array_merge($extra_icon, $icon);
 
	return $icon;
}

add_filter('upg_add_icon_grid', 'upg_add_extra_icon_grid_edit');

//Adds delete/trash icon in upg icon container. 
function upg_add_extra_icon_grid_delete($icon)
{
	global $post; 
	$options = get_option('upg_settings');
	$nonce = wp_create_nonce("upg_delete");
    $link = admin_url('admin-ajax.php?action=upg_delete&post_id='.$post->ID.'&nonce='.$nonce);
		
	$extra_icon = array();
	
	if(get_the_author_meta('ID') == get_current_user_id())
	{
		if(isset($options['show_trash_icon']))
		{
			if($options['show_trash_icon']=="1")
			{
				$extra_icon = array
			  (
				array("fa fa-trash fa-fw fa-border",'Delete',$link,'upg_delete',$post->ID)
								
			  );
			}
		}
	}
	
 
	// combine the two arrays
	if(is_array($extra_icon) && is_array($icon))
	$icon = array_merge($extra_icon, $icon);
 
	return $icon;
}

			add_filter('upg_add_icon_grid', 'upg_add_extra_icon_grid_delete');

add_action("wp_ajax_upg_delete", "upg_delete");
add_action("wp_ajax_nopriv_upg_delete", "upg_my_must_login");

function upg_delete() 
{

   if ( !wp_verify_nonce( $_REQUEST['nonce'], "upg_delete")) {
      exit("No naughty business please");
   }   

   
	$post_id=$_REQUEST["post_id"];
	
	$post_author_id = get_post_field( 'post_author', $post_id );
   
   if(get_current_user_id() == $post_author_id)
		$data = wp_delete_post( $post_id, true );
	else
		$data=false;

   if($data === false) 
   {
      $result['type'] = "error";
      $result['data_count'] = "Fail";
   }
   else 
   {
      $result['type'] = "success";
      $result['data_count'] = "Pass";
   }

   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $result = json_encode($result);
      echo $result;
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
   }

   die();

}

//Used in ajax call, force users to login before any action. 
function upg_my_must_login() {
   echo "You must log in.";
   die();
}

//Adds user icon in upg icon container. Links to user gallery page.
function upg_add_extra_icon_grid_user($icon)
{
	global $post; 
	$extra_icon=array();
	$options = get_option('upg_settings');
	$author = get_user_by('id', get_the_author_meta( 'ID' ));
	if(isset($options['main_page']))
	{
		
		if ( get_option('permalink_structure') )
		$link=esc_url( get_permalink($options['main_page'])."member/".$author->user_nicename );
		else
		$link=esc_url( get_permalink($options['main_page'])."&user=".$author->user_nicename );
	}
	else
	{
		$link="";
	}
	
	if(isset($options['show_user_icon']))
	{
		if($options['show_user_icon']=="1")
		{
	
			$extra_icon = array
		  (
			//array("fa fa-trash fa-fw fa-border",'Delete',$link,'upg_delete',$post->ID),
			array("fa fa-user fa-border",$author->user_nicename,$link,'',$post->ID)
		  );
		}
		else
		{
			$extra_icon = array(
			array("",$author->user_nicename,'','',$post->ID)
			);
		}
	}
	
 
	// combine the two arrays
	if(is_array($extra_icon) && is_array($icon))
	$icon = array_merge($extra_icon, $icon);
 
	return $icon;
}

	
	add_filter('upg_add_icon_grid', 'upg_add_extra_icon_grid_user');

//Preview link of post.
function upg_get_preview_link($url,$layout)
{
	$url=add_query_arg( 'upg_layout', $layout, $url );
	$link='<a href="'.$url.'" target="_blank" style="text-decoration:none"><span class="dashicons 
dashicons-visibility"></span></a>';
	return $link;
}


add_action("wp_ajax_upg_ajax_post", "upg_ajax_post");
add_action("wp_ajax_nopriv_upg_ajax_post", "upg_ajax_post");
function upg_ajax_post()
{
	$options = get_option('upg_settings');
	if ( 
        ! isset( $_POST['upg-nonce'] ) 
        || ! wp_verify_nonce( $_POST['upg-nonce'], 'upg-nonce') 
    ) {
 
        exit('The form is not valid');
 
    }

    // A default response holder, which will have data for sending back to our js file
    $response = array(
		'error' => false,
		'msg' => 'No Message'
    );
 
    // Example for creating an response with error information, to know in our js file
    // about the error and behave accordingly, like adding error message to the form with JS
    if (trim($_POST['upload_type']) == '') {
    	$response['error'] = true;
    	$response['error_message'] = 'Improper form fields. Ajax cannot continue.';
 
    	// Exit here, for not processing further because of the error
    	exit(json_encode($response));
    }
	
	$author = ''; $url = ''; $email = ''; $tags = ''; $captcha = ''; $verify = ''; $content = ''; $category = ''; 
		
	if (isset($_POST['user-submitted-content']))  $content  = upg_sanitize_content($_POST['user-submitted-content']);
	if (isset($_POST['cat'])) $category = intval($_POST['cat']);

	$content=str_replace("[","[[",$content);
	$content=str_replace("]","]]",$content);

	$title=sanitize_text_field($_POST['user-submitted-title']);

	if (isset($_POST['preview'])) $preview = upg_sanitize_content($_POST['preview']);

	if($_POST['upload_type']=="video_url")
	{
		//$response['msg'] = "VIDEO URL";
		
		$url=sanitize_text_field($_POST['user-submitted-url']);

		$result = upg_submit_url($title, $url, $content, $category,$preview);
		if(isset($result['error'][1]['id']))
		{
			//echo "it is set";
			$result = array('id' => false, 'error' => false);
			$result['error'][] ="";
			
		}
		
		$post_id = false; 
		if (isset($result['id'])) $post_id = $result['id'];
		
		//print_r($result);
		$error = false;
		
		if (isset($result['error']))
		$error = array_filter(array_unique($result['error']));

		if ($post_id) 
		{
			//Submit extra fields data
			for ($x = 1; $x <= 10; $x++) 
			{
				if (isset($_POST['upg_custom_field_'.$x]))
				add_post_meta($post_id, 'upg_custom_field_'.$x, $_POST['upg_custom_field_'.$x]);
			}

				//Attach post id if the gallery is attached to specific post.
				if (isset($_POST['form_attach']))
				{
						add_post_meta($post_id, 'form_attach', $_POST['form_attach']);
						//$response['srv_attach']="Media attached to "+$_POST['form_attach'];
				}
				
			
			
			$post   = get_post( $post_id );
			//Email Notification 
			do_action( "upg_submit_complete");
			$response['type'] = "success";
			
			if(isset($options['publish']) && $options['publish']=='1' )
			{
			
			//echo "<h2>".__('YouTube Video is successfully posted.','wp-upg')."</h2>";
			//echo "<br><br><a href='".esc_url( get_permalink($post_id) )."' class=\"pure-button\">Click here to view</a><br><br>";
			$response['msg'] = "<div class='upg_success'>".__('Video is successfully posted.','wp-upg')."</div>";

			}
			else
			{
				$response['msg'] = "<div class='upg_warning'>".__('Your video submission is under review.','wp-upg')."</div>";
				//echo "<h2>".__('YouTube video is under review','wp-upg')."</h2>";
				
				
			}
			
			
			//echo "<h1 class=\"archive-title\">".$post->post_title."</h1>";
			//echo "<img src='$image'>";
		}
		else
		{
			
			$response['msg'] = "<div class='upg_error'>".__('Server error. Try again later','wp-upg')."</div>";
			
		} 
		
		
	}
	else
	{
		//Uploading Image

		$files = array();
		if (isset($_FILES['user-submitted-image']))
		{
			$files = $_FILES['user-submitted-image'];
			$response['srv_msg'] = "Image found ";
		
		}
		else
		{
			$response['srv_msg'] = "Image not found";
		}

		$result = upg_submit($title, $files, $content, $category, $preview);

		$post_id = false; 
		if (isset($result['id'])) $post_id = $result['id'];
		
		$error = false;
		if (isset($result['error'])) $error = array_filter(array_unique($result['error']));
		
		if ($post_id) 
		{
			//Submit extra fields data
			for ($x = 1; $x <= 10; $x++) 
			{
				if (isset($_POST['upg_custom_field_'.$x]))
				add_post_meta($post_id, 'upg_custom_field_'.$x, $_POST['upg_custom_field_'.$x]);
			}
			
			//Ended to submit extra fields

			//Attach post id if the gallery is attached to specific post.
			if (isset($_POST['form_attach']))
			{
					add_post_meta($post_id, 'form_attach', $_POST['form_attach']);
					//$response['srv_attach']="Media attached to "+$_POST['form_attach'];
			}
			
			
			$post   = get_post( $post_id );
			$image=upg_image_src('large',$post);
			
			do_action( "upg_submit_complete");
			$response['type'] = "success";
			
			if(isset($options['publish']) && $options['publish']=='1' )
			{
				
			//echo "<h2>".__('Successfully posted.','wp-upg')."</h2>";
			//echo "<br><br><a href='".esc_url( get_permalink($post_id) )."' class=\"pure-button\">".__('Click here to view','wp-upg')."</a><br><br>";
			$response['msg'] = "<div class='upg_success'>".__('Successfully posted.','wp-upg')."</div>";
			}
		else
		{
			//echo "<h2>".__('Your submission is under review.','wp-upg')."</h2>";
			$response['msg'] = "<div class='upg_warning'>".__('Your submission is under review.','wp-upg')."</div>";
			
		}
			
			
			//echo "<h1 class=\"archive-title\">".$post->post_title."</h1>";
			//echo "<img src='$image'>";
		}
		else
		{
			$response['msg'] ="<div class='upg_error'>".__('Server error. Try again later','wp-upg')."</div>";
		} 

		
		



	}
    // ... Do some code here, like storing inputs to the database, but don't forget to properly sanitize input data!
 
    // Don't forget to exit at the end of processing
	
	$result = json_encode($response);
	echo $result;
	die();
  
}

function upg_breakLongText($text, $length = 200, $maxLength = 250){
 //Text length
 $text=htmlspecialchars(trim(strip_tags($text))) . PHP_EOL;
 $textLength = strlen($text);

 //initialize empty array to store split text
 $splitText = array();

 //return without breaking if text is already short
 if (!($textLength > $maxLength)){
  $splitText[] = $text;
  return $splitText[0];
 }

 //Guess sentence completion
 $needle = '.';

 /*iterate over $text length 
   as substr_replace deleting it*/  
 while (strlen($text) > $length){

  $end = strpos($text, $needle, $length);

  if ($end === false){

   //Returns FALSE if the needle (in this case ".") was not found.
   $splitText[] = substr($text,0);
   $text = '';
   break;

  }

  $end++;
  $splitText[] = substr($text,0,$end);
  $text = substr_replace($text,'',0,$end);

 }
 
 if ($text){
  $splitText[] = substr($text,0);
 }

 return $splitText[0]."...";

}

//Return album name with and without link
function upg_get_album($post,$type)
{
	//$type values can be term_id,slug,name,url
	$categories = get_the_terms( $post->ID, 'upg_cate');
	foreach( (array) $categories as $category ) 
	{
		if($type=='url')
		{
			return upg_get_category_page_link( $category, 'upg_cate' );
		}
		else
		{
			if(isset($category->$type))
			return $category->$type;
			else
			return '';
		}
	}
}

 
//If plugins are updated or just installed. The personal files got deleted.
//It will either create files or copy files from upload folder.
function upg_auto_create_file($layout_name,$type,$file)
 {
	 if($layout_name=="personal")
	 {
	 $upload_dir = wp_upload_dir();
	 $user_dirname = $upload_dir['basedir'].'/upg_'.$type.'_'.$file.'.php';
	  $filename=upg_BASE_DIR."layout/".$type."/".$layout_name."/".get_current_blog_id()."_".$file.".php";
	    
	  
	  //If personal file not created before
    if( ! file_exists( $user_dirname ) )
	{
		
		$sample_filename=upg_BASE_DIR."layout/".$type."/".$layout_name."/".$file.".txt";
		$sample_content =  file_get_contents($sample_filename);
		
		$file = fopen($user_dirname,"w+");
		fwrite($file, $sample_content);
		
		$file = fopen($filename,"w+");
		fwrite($file, $sample_content);
		
		
	}
	 //If personal file exist but plugin updated
    if( file_exists( $user_dirname ) && !file_exists( $filename ))
	{
		
		$sample_content =  file_get_contents($user_dirname);
		
		//Get content from saved personal 
		$file = fopen($filename,"w+");
		fwrite($file, $sample_content);
	}
 }
}

//Update Personal layout files.
function upg_update_personal_layout()
{
	
	$blog_id=get_current_blog_id();
	
	$upload_dir = wp_upload_dir();
	$user_dirname_up = $upload_dir['basedir'].'/upg_grid_personal_up.php';
	$user_dirname_down = $upload_dir['basedir'].'/upg_grid_personal_down.php';
	$user_dirname_main = $upload_dir['basedir'].'/upg_grid_personal_main.php';
	$user_dirname_pick = $upload_dir['basedir'].'/upg_grid_personal_pick.php';
	$user_dirname_post_form = $upload_dir['basedir'].'/upg_form_personal_post_form.php';
	$user_dirname_post_youtube = $upload_dir['basedir'].'/upg_form_personal_post_youtube.php';
	
		$file_personal_post_form=upg_BASE_DIR."layout/form/personal/".$blog_id."_personal_post_form.php";
		$file_personal_post_youtube=upg_BASE_DIR."layout/form/personal/".$blog_id."_personal_post_youtube.php";
	
	$file_personal_pick=upg_BASE_DIR."layout/grid/personal/".$blog_id."_personal_pick.php";
	$file_personal_up=upg_BASE_DIR."layout/grid/personal/".$blog_id."_personal_up.php";
	$file_personal_down=upg_BASE_DIR."layout/grid/personal/".$blog_id."_personal_down.php";
	$file_personal_main=upg_BASE_DIR."layout/grid/personal/".$blog_id."_personal.php";
	
	//IF file not exist
	if( ! file_exists( $file_personal_post_form ) )
	{
		if( file_exists( $user_dirname_post_form ) )
		{
			//copy files from upload folder
			if (!copy($user_dirname_up, $file_personal_up)) 
			{
				echo "Failed to copy $user_dirname_up...<br>";
				
			}
			//copy files from upload folder
			if (!copy($user_dirname_down, $file_personal_down)) 
			{
				echo "Failed to copy $user_dirname_down...<br>";
			}
			//copy files from upload folder
			if (!copy($user_dirname_main, $file_personal_main)) 
			{
				echo "Failed to copy $user_dirname_main...<br>";
			}
			//copy files from upload folder
			if (!copy($user_dirname_pick, $file_personal_pick)) 
			{
				echo "Failed to copy $user_dirname_pick...<br>";
			}
			//copy files from upload folder
			if (!copy($user_dirname_post_form, $file_personal_post_form)) 
			{
				echo "Failed to copy $user_dirname_post_form...<br>";
			}
			//copy files from upload folder
			if (!copy($user_dirname_post_youtube, $file_personal_post_youtube)) 
			{
				echo "Failed to copy $user_dirname_post_youtube...<br>";
			}
			
			//echo "Creating files...";
		}
		else
		{
			//echo "Trying to copy files...";
			
			$sample_filename=upg_BASE_DIR."layout/grid/personal/personal.txt";
			$sample_content =  file_get_contents($sample_filename);
			
			if(file_exists($file_personal_main))
			{
				$file = fopen($file_personal_main,"w+");
				fwrite($file, $sample_content);
				fclose($file);
			}
			
			$sample_filename=upg_BASE_DIR."layout/grid/personal/personal_up.txt";
			$sample_content =  file_get_contents($sample_filename);
			
			if(file_exists($file_personal_main))
			{
			$file = fopen($file_personal_up,"w+");
			fwrite($file, $sample_content);
			fclose($file);
			}
			

			$sample_filename=upg_BASE_DIR."layout/grid/personal/personal_down.txt";
			$sample_content =  file_get_contents($sample_filename);
			
			if(file_exists($file_personal_main))
			{
			$file = fopen($file_personal_down,"w+");
			fwrite($file, $sample_content);
			fclose($file);
			}
			

			$sample_filename=upg_BASE_DIR."layout/grid/personal/personal_pick.txt";
			$sample_content =  file_get_contents($sample_filename);
			
			if(file_exists($file_personal_main))
			{
			$file = fopen($file_personal_pick,"w+");
			fwrite($file, $sample_content);
			fclose($file);
			}
			
			$sample_filename=upg_BASE_DIR."layout/form/personal/personal_post_form.txt";
			$sample_content =  file_get_contents($sample_filename);
			
			if(file_exists($file_personal_post_form))
			{
			$file = fopen($file_personal_post_form,"w+");
			fwrite($file, $sample_content);
			fclose($file);
			}
			
			$sample_filename=upg_BASE_DIR."layout/form/personal/personal_post_youtube.txt";
			$sample_content =  file_get_contents($sample_filename);
			
			if(file_exists($file_personal_post_youtube))
			{
			$file = fopen($file_personal_post_youtube,"w+");
			fwrite($file, $sample_content);
			fclose($file);
			}
			
		}
	}
	
}


 // Only for extra custom fields. It will grab the value.
 function upg_get_value($field,$post="")
 {
	  if($post=="")
	  global $post;
  
	  $value= get_post_custom($post->ID);
	  if(isset($value[$field][0]))
		  return $value[$field][0];
	  else
		  return "";
	  
 }
 
 //get filed name
 function upg_get_filed_label($field)
 {
	 $options = get_option('upg_settings');
	 return $options[$field];
 }
 
 
 
	//Detail Layout List
	 function upg_grid_layout_list($param,$name,$type,$preview)
	{
        $options = get_option('upg_settings');
		$upg_layout=$param;
		
		$dir    = upg_BASE_DIR.'layout/'.$type.'/';
		$filelist ="";
		$files = array_map("htmlspecialchars", scandir($dir));       

		foreach ($files as $file) 
		{
			if($upg_layout==$file)
				$checked='checked=checked';
			else
				$checked="";
			
			if(!strpos($file, '.') && $file != "." && $file != "..")
			{				
				//Show preview link of layout
				if(isset($options['main_page']) && $preview==true)
				{
					$main_page=get_permalink($options['main_page']);
					
					$filelist .= sprintf('<input type="radio" '.$checked.' name="'.$name.'" id="'.$name.'"  value="%s"/>%s layout '.upg_get_preview_link($main_page,$file).'<br>' . PHP_EOL, $file, $file );
				}
				else
				{
					$filelist .= sprintf('<input type="radio" '.$checked.' name="'.$name.'" id="'.$name.'"  value="%s"/>%s layout<br>' . PHP_EOL, $file, $file );
				}
			}
		}
echo $filelist;
   
	}

//Adding facebook image meta tag for product page
function upg_metatag_facebook_head() 
{
	global $post;
	if(get_post_type( get_the_ID() )=='upg')
	{
		
	echo '<meta property="og:image" content="'.upg_image_src('large',$post).'" />';
	echo '<meta property="og:type" content="website" />';
	echo '<meta property="og:title" content="'.get_the_title($post->ID).'" />';
	echo '<meta property="og:url"  content="'.get_permalink($post).'" />';
	echo '<meta property="og:description"  content="'.wp_strip_all_tags($post->post_content).'" />';

	}

}

//Get full size media server path. Not URL
function upg_image_server_path($post)
{
	wp_enqueue_media();
	$field_names = array( 'pic_name');
	foreach ( $field_names as $name ) 
	{
		$value = $rawvalue = get_post_meta( $post->ID, $name, true );
		$fullsize_path = get_attached_file( $rawvalue );
		return $fullsize_path;
	}
}

//Return image url
function upg_image_src($size,$post)
{
	// global $post;
	wp_enqueue_media();
	$field_names = array( 'pic_name');
	
	
	$all_upg_extra= get_post_custom($post->ID);
			if(isset($all_upg_extra["youtube_url"][0]))
			$youtube_url=trim($all_upg_extra["youtube_url"][0]);
			else	
			$youtube_url="";
		
			
	foreach ( $field_names as $name ) 
	{
	

			$value = $rawvalue = get_post_meta( $post->ID, $name, true );
		//	$image_attributes = wp_get_attachment_image_src( $rawvalue,'odude-thumb' );
			//var_dump($image_attributes);
			$image_attributes = wp_get_attachment_image_src( $rawvalue,$size );
			//wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array('220','220'), true );
			if ( $image_attributes )
			{
			return $image_attributes[0];
			}
			else
			{
				if(empty($youtube_url))
					return plugins_url( '../images/noimg.png', __FILE__ );
				else if(trim($youtube_url)!="")
					return upg_getimg_youtube($youtube_url);
				else
					return plugins_url( '../images/noimg.png', __FILE__ );
			}
					
			
	}
}
function upg_droplist_category($selected_album="")
{
	
		$disp='';
		$ptype='';
		

			$args = array(
			'show_option_all'    => '',
			'orderby'            => 'name',
			'order'              => 'ASC',
			'style'              => 'list',
			'show_count'         => 0,
			'hide_empty'         => 0,
			'use_desc_for_title' => 1,
			'feed'               => '',
			'feed_type'          => '',
			'feed_image'         => '',
			'exclude'            => '',
			'exclude_tree'       => '',
			'include'            => '',
			'hierarchical'       => 1,
			
			'number'             => null,
			'echo'               => 0,
			'depth'              => 0,
			'current_category'   => 0,
			'pad_counts'         => 0,
			'taxonomy'           => 'upg_cate',
			'walker'             => null,
			'value_field'	     => 'term_id'
			);

			

		

	 //$disp.=wp_dropdown_categories( $args );
	 
	 $disp.='<select name="cat" id="cat">'; 
    
    
    $categories = get_categories( array( 'taxonomy'=> 'upg_cate','hide_empty'         => 0 ) ); 
	
	$i=0;
    foreach ( $categories as $category ) 
	{
		$upg_show_cate = get_term_meta( $category->term_id, 'upg_show_cate', true  );
		
		if($upg_show_cate!="1")
		{
			
			if(isset($_GET['album']) && $_GET['album']!="")
			$selected_album = $_GET['album'];
						
			if($selected_album==$category->cat_name)
			{
			$disp.='<option value="'.$category->term_id.'" selected>'.$category->cat_name.'</option>'; 	
			}
			else
			{
			$disp.='<option value="'.$category->term_id.'">'.$category->cat_name.'</option>'; 
			}
			$i++;
		}
    }
	if($i==0)
		$disp.='<option value="0">Create Category - Admin</option>';
    
$disp.='</select>';
				
	
return $disp;

}

function upg_droplist_user($user)
{
	 $args = array(
    'show_option_all'         => null, // string
    'show_option_none'        => null, // string
    'hide_if_only_one_author' => null, // string
    'orderby'                 => 'display_name',
    'order'                   => 'ASC',
    'include'                 => null, // string
    'exclude'                 => null, // string
    'multi'                   => false,
    'show'                    => 'display_name',
    'echo'                    => true,
    'selected'                => $user,
    'include_selected'        => false,
    'name'                    => 'upg_settings[guest_user]', // string
    'id'                      => null, // integer
    'class'                   => null, // string 
    'blog_id'                 => $GLOBALS['blog_id'],
    'who'                     => null // string
	); 
	$disp= wp_dropdown_users( $args );
	return $disp;
}


function upg_html_content_type() 
{

	return 'text/html';
}
function upg_log($message) 
{
    if (WP_DEBUG === true) {
        if (is_array($message) || is_object($message)) {
            error_log(print_r($message, true));
        } else {
            error_log($message);
        }
    }
}
//log_me('This is a message for debugging purposes. works if dubug is enabled.');

function upg_delete_post_media( $post_id ) {

	if(!isset($post_id)) return; // Will die in case you run a function like this: delete_post_media($post_id); if you will remove this line - ALL ATTACHMENTS WHO HAS A PARENT WILL BE DELETED PERMANENTLY!
	elseif($post_id == 0) return; // Will die in case you have 0 set. there's no page id called 0 :)
	elseif(is_array($post_id)) return; // Will die in case you place there an array of pages.

	else {

	    $attachments = get_posts( array(
	        'post_type'      => 'attachment',
	        'posts_per_page' => -1,
	        'post_status'    => 'any',
	        'post_parent'    => $post_id
	    ) );

	    foreach ( $attachments as $attachment ) {
	        if ( false === wp_delete_attachment( $attachment->ID ) ) 
			{
	            upg_log('Unable to delete image-'.$post_id);
	        }
	    }
	}
}

function upg_getid_youtube($url)
{
	//echo $url;
	if (strpos($url, 'vimeo') > 0) 
	{
		$video = $url;
		$result = preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $output_array);
		
		if($result)
			return $output_array[5];
		else
			return '';
	}
	else
	{
		
		$url=str_replace("m.youtube","www.youtube",$url);

		$pattern = 
                '%^# Match any youtube URL
                (?:https?://)?  # Optional scheme. Either http or https
                (?:www\.)?      # Optional www subdomain
				(?:m\.)?      # Optional mobile subdomain
                (?:             # Group host alternatives
                  youtu\.be/    # Either youtu.be,
                | youtube\.com  # or youtube.com
                  (?:           # Group path alternatives
                    /embed/     # Either /embed/
                  | /v/         # or /v/
                  | /watch\?v=  # or /watch\?v=
                  )             # End path alternatives.
                )               # End host alternatives.
                ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
                $%x'
                ;
            $result = preg_match($pattern, $url, $matches);
            if ($result) {
                return $matches[1];
            }
            return '';
	}

}

function upg_getimg_youtube($url)
{
	$youtube_id=upg_getid_youtube($url);
	if (strpos($url, 'vimeo') > 0) 
	{
		$data = file_get_contents("http://vimeo.com/api/v2/video/$youtube_id.json");
		$data = json_decode($data);
		return $data[0]->thumbnail_large;
	}
	else
	{
	
	return 'https://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg';
	}
}


function upg_isVideo($post)
{
	$all_upg_extra= get_post_custom($post->ID);
			
			if(isset($all_upg_extra["youtube_url"][0]))
			$youtube_url=$all_upg_extra["youtube_url"][0];
			else	
			$youtube_url="";
		
		if($youtube_url=="")
			return '';
		else
			return $youtube_url;
	
}

function upg_video_preview_url($url)
{
	$youtube_id=upg_getid_youtube($url);
	
	if (strpos($url, 'vimeo') > 0) 
	{
		return "http://player.vimeo.com/video/".$youtube_id;
	}
	else
	{
		
		return 'https://www.youtube.com/embed/'.$youtube_id.'?rel=0&amp;wmode=transparent';
	}
}

function upg_get_listings_count_by_category( $term_id, $pad_counts = true ) {
	
	$args = array(
		'fields'          =>'ids',
		'posts_per_page'  => -1,
   		'post_type'       => 'upg',
   		'post_status'     => 'publish',
   		'tax_query' 	  => array(
			array(
				'taxonomy'         => 'upg_cate',
				'field'            => 'term_id',
				'terms'            => $term_id,
				'include_children' => $pad_counts
			)
		)    		
	);

	return count( get_posts( $args ) );

}
//Return album name,term_id,term_group,term_taxonomy_id,description,parent,count
// from album slug name 
function upg_get_term_id($slug,$return='term_id')
{

	$abc= get_term_by('slug', $slug, 'upg_cate');
	//var_dump($abc);
	if(isset($abc->$return))
	{
		return $abc->$return;
	}
	else
	{
		return 99999;
	}
	
}
?>