<?php
//function upg_help_page()
//{
	$title="";
	if(isset($_POST['subject']))
	$title=sanitize_text_field($_POST['subject']);
	?>
	<div class="wrap">
	<h2>Contact Us</h2>
	<?php
	$user_info = get_userdata(1);
      $username = $user_info->user_login;
      $name = $user_info->user_nicename;
	  $email = $user_info->user_email;
	  $url=get_site_url();
	  $plugin_version="UPG-".get_option('upg_plugin_version');
	
	if($title=='')
	{
?>
		<div class="update-nag">
		<b>Common shortcodes uses:</b><br>
	copy/paste <code>[upg-attach type="image"]</code>or <code>[upg-attach type="youtube"]</code> shortcode into wordpress post/page content area.<br>
	The embed gallery will have own set of post. All post/images from different post will be shown in primary gallery <code>[upg-list]</code>.
	<br>Use <code>[upg-post]</code> for submission form.<br>
	Check all important settings with start icon. <a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a>
		</div>
	<?php	
		echo "<h3>System Check</h3><ul>";
		
		$file_personal_up=upg_BASE_DIR."layout/grid/personal/".get_current_blog_id()."_personal_up.php";
		if ( is_writeable(dirname($file_personal_up)) ) 
		{
			echo "<li>".upg_BASE_DIR."layout/grid/personal/ is writable.</li>";
		}
		else
		{
			echo "<li>".upg_BASE_DIR."layout/grid/personal/ is <b>not writable</b>. Please [chmod -R 777] or make this folder writable via FTP/cpanel. You cannot use personal layout unless it is corrected.</li>";
		}
		
		$file_personal_media=upg_BASE_DIR."layout/media/personal/".get_current_blog_id()."_content.php";
		if ( is_writeable(dirname($file_personal_media)) ) 
		{
			echo "<li>".upg_BASE_DIR."layout/media/personal/ is writable.</li>";
		}
		else
		{
			echo "<li>".upg_BASE_DIR."layout/media/personal/ is <b>not writable</b>. Please [chmod -R 777] or make this folder writable via FTP/cpanel. You cannot use personal layout unless it is corrected.</li>";
		}
		
			$file_personal_form=upg_BASE_DIR."layout/form/personal/".get_current_blog_id()."_personal_post_form.php";
		if ( is_writeable(dirname($file_personal_form)) ) 
		{
			echo "<li>".upg_BASE_DIR."layout/form/personal/ is writable.</li>";
		}
		else
		{
			echo "<li>".upg_BASE_DIR."layout/form/personal/ is <b>not writable</b>. Please [chmod -R 777] or make this folder writable via FTP/cpanel. You cannot use personal layout for form unless it is corrected.</li>";
		}
		
		
		$upload_dir = wp_upload_dir();
		$user_dirname_up = $upload_dir['basedir'].'/upg_grid_personal_up.php';
		if ( is_writeable($user_dirname_up) ) 
		{
			echo "<li>".$upload_dir['basedir']."/ is writable.</li>";
		}
		else
		{
			echo "<li>".$upload_dir['basedir']."/ may be writable</b> but unable to create some files into it. If you get upload-error when posting image, please [chmod -R 777] or make this folder writable via FTP/cpanel.</li>";
			
		}
		
		
		
		
if (function_exists('exif_imagetype')) 
{
    echo "<li>exif_imagetype is OK</li>";
}
 else 
 {
    echo "<li>exif_imagetype is not available in your server. This is important to check file type uploaded by user.</li>";
}
?>
 <li><?php echo _e('Maximum upload file size limit:','wp-upg') ?> <b><?php //echo ini_get('post_max_size'); ?> <?php echo size_format( wp_max_upload_size() ); ?></b></li>
<?php	
flush_rewrite_rules();
	echo "<li>Permalink structure updated</li>";
	echo "</ul>";
	
	echo "<h3>Tips</h3><ul>";
	
	echo '<li><b>To create Frontend Image Upload Page:</b> Create a page and add it to menu. The Content should be <br>For Image [upg-post type="image"] <br> For Youtube or vimeo [upg-post type="youtube"]</li>';
	
	?>
		 
		<?php
		
			echo '<li><b>To change layout of form to your personal layout.</b> Eg. [upg-post type="image" preview="personal" layout="personal"]</li>';
		
	echo '<li><b>To post image directly to given media/preview layout,</b> At post form add parameter with the layout name. Eg. [upg-post type="youtube" preview="personal"]</li>';
	
	echo "<li>Click <b><a href='http://odude.com/demo/faq/' target='_blank'>this link</a> </b>for more basic installation questions and available features. </li>";
	echo "</ul>";
	
	

	
	?>
	<hr>
	<b>If you have question,suggestion then you can directly contact us with the form below.<br>You will get reply from navneet@odude.com </b>
	<form class="pure-form" method="post" action="">
	<table class="form-table"><tbody><tr><th scope="row">Subject</th>
	<td>	<input name="subject" id="subject" type="text" value="" class="regular-text code" required>
	</td></tr><tr><th scope="row">Message</th><td>	
	
	<div class="pure-controls">
					<div class="usp_text-editor">
			<?php $settings = array(
				    'wpautop'          => true,  // enable rich text editor
				    'media_buttons'    => true,  // enable add media button
				    'textarea_name'    => 'message', // name
				    'textarea_rows'    => '10',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'usp-rich-textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => true,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => true, // enable drag-drop
				);
				wp_editor('', 'upgcontent', apply_filters('upg_editor_settings', $settings));
				
			

				?>
				 
				</div>
			</div>
	
	
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Send Message to ODude.com">
	</td></tr></tbody></table>
	</form>
   
<br>
<b>These are the information passed along with the message</b>

	<?php
	
      echo "<ul><li>Name: $name </li><li>Username: $username</li><li>Email: $email</li><li>URL: $url</li><li>Version : $plugin_version</li></ul>";
	
	}
	else
	{
		$sub=sanitize_text_field($_POST['subject']);
		$msg=$_POST['message']."<hr>"."<ul><li>Name: $name </li><li>Username: $username</li><li>Email: $email</li><li>URL: $url</li><li>Version : $plugin_version</li></ul>";
		$msg=wp_kses_post($msg);

			//Sending Mail
			add_filter( 'wp_mail_content_type', 'upg_html_content_type' );
			//$headers[] = 'From: '.$name.' <'.$email.'>';
			wp_mail( 'navneet@odude.com', $sub, $msg );
			// Reset content-type to avoid conflicts 
			remove_filter( 'wp_mail_content_type', 'upg_html_content_type' );
		
	echo "Message Sent. We will contact you as soon as possible if required.";
	//echo $msg;
	}
	?>
	</div>
	<?php
//}
?>