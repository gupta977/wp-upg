<?php
//[upg-post] include file for image submission
global $post; 
$options = get_option('upg_settings');


if(isset($options['editor']) && $options['editor']=='1' )
	$editor=true;
else
	$editor=false;	

$title='';

$abc="";
ob_start ();
if(isset($params['login']))
	$login_check=$params['login'];
else
	$login_check="false";

if(!is_user_logged_in() && $login_check=='true')
{
	upg_login_link();
	
}
else 
{

if (isset($_POST['user-submitted-title'], $_POST['upg-nonce']) && !empty($_POST['user-submitted-title']) && wp_verify_nonce($_POST['upg-nonce'], 'upg-nonce')) 
$title=sanitize_text_field($_POST['user-submitted-title']);

	if($title=='')
{
	//Form not submitted yet.
	
}
else
{
	
	if(isset($_POST['form_name']))
		$frname=sanitize_text_field($_POST['form_name']);
	else
		$frname="";

	if($frname==$form_name)
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
		
		$result = upg_submit($title, $files, $content, $category, $preview,'upg','upg_cate',$tags,'upg_tag');
		
		
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
			
						
			$post   = get_post( $post_id );
			$image=upg_image_src('large',$post);
			
			do_action( "upg_submit_complete");
			
			if(upg_get_option( 'publish','upg_form', 'on' )=='on' )
			{
				
			echo "<h2>".__('Successfully posted.','wp-upg')."</h2>";
			//echo "<br><br><a href='".esc_url( get_permalink($post_id) )."' class=\"pure-button\">".__('Click here to view','wp-upg')."</a><br><br>";
			if(upg_get_option( 'my_gallery','upg_gallery', '0' )!='0')
				{
					echo "<br><a href='".esc_url( get_page_link( upg_get_option( 'my_gallery','upg_gallery', '0' ) ) )."' class=\"pure-button\">".__('My Gallery','wp-upg')."</a><br><br>";
				}
			}
		else
		{
			echo "<h2>".__('Your submission is under review.','wp-upg')."</h2>";
			
		}
			
			
			//echo "<h1 class=\"archive-title\">".$post->post_title."</h1>";
			//echo "<img src='$image'>";
		}
		else
		{
			
			if ($error) 
			{
				$e = implode(',', $error);
				$e = trim($e, ',');
			} 
			else 
			{
				$e = 'error';
			}

			if($e=='file-type')
			{
				echo "<h1>".__('Invalid file','wp-upg')."</h1>";
			}
			else
			{
				echo "<h1>".__('Error occurred','wp-upg')."</h1>";
			}
			
			
		} 
		
	}
}


if(isset($params['layout']))
	$layout=trim($params['layout']);
else
	$layout=upg_get_option( 'global_form_layout','upg_form', 'basic' );

if($layout=="personal")
{
	$inc_file=upg_BASE_DIR."/layout/form/".$layout."/".get_current_blog_id()."_".$layout."_post_form.php";

	if(file_exists($inc_file))
	{
		if( strpos(file_get_contents($inc_file),'[upg-form') !== false)
		{
			
			$file_shortcode = file_get_contents($inc_file, true);
			echo do_shortcode($file_shortcode);
		
	   } 
	   else
	   {
			include($inc_file);
	   }
	}
	else
	{
		echo __('Refresh Page','wp-upg').": ".$layout;
		upg_auto_create_file('personal','form','personal_post_form');
	}

}
else
{
	
	//echo do_shortcode($shor);
	$inc_file=upg_BASE_DIR."/layout/form/".$layout."/".$layout."_post_form.php";
	if(file_exists($inc_file))
	{
		if( strpos(file_get_contents($inc_file),'[upg-form') !== false)
		{
			
			$file_shortcode = file_get_contents($inc_file, true);
			echo do_shortcode($file_shortcode);
		
	   } 
	   else
	   {
			include($inc_file);
	   }
		
	}
	else
	{
		echo __('Layout Not Found. Check settings.','wp-upg').": ".$layout;
	}
		
	}

//ob_flush();	
}
$abc=ob_get_clean (); 
return $abc;
?>