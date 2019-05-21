<?php
function upg_add_admin_menu(  ) 
{ 
	$options = get_option('upg_settings');
	if(upg_get_option( 'show_advance_setting', 'upg_general', '0' )=='1')
	add_submenu_page( 'edit.php?post_type=upg', 'User Post Gallery Settings', 'UPG Settings', 'manage_options', 'wp_upg', 'upg_options_page' );
	
	add_submenu_page( 'edit.php?post_type=upg', 'Edit UPG Layouts', 'Layout Editor', 'manage_options', 'wp_upg_layout', 'upg_layout_page' );
	//add_submenu_page( 'edit.php?post_type=upg', 'Quick Mode Setting', 'Quick Settings', 'manage_options', 'upg_quick_setting', 'upg_quick_setting' );
	add_submenu_page( 'edit.php?post_type=upg', 'FREE and Premium plugins', 'UPG Addons / Help', 'manage_options', 'wp_upg_addon', 'upg_addon_page' );
}


function upg_settings_init(  ) 
{ 
	
	
	//Basic Setting
	register_setting( 'ImageSettingPage', 'upg_settings' );
	

	add_settings_section(
		'upg_ImageSettingPage_section', 
		__( 'Settings', 'wp-upg' ), 
		'upg_settings_section_callback', 
		'ImageSettingPage'
	);
	add_settings_field( 
		'upg_select_quick_field', 
		__('Extra Settings', 'wp-upg' ), 
		'upg_quick_settings', 
		'ImageSettingPage', 
		'upg_ImageSettingPage_section' 
	);

	add_settings_field( 
		'upg_grid_settings_field', 
		__( 'Grid/Gallery Layout Settings', 'wp-upg' ), 
		'upg_grid_settings', 
		'ImageSettingPage', 
		'upg_ImageSettingPage_section' 
	);

	add_settings_field( 
		'upg_select_pickup_field', 
		__( 'Submission form Settings', 'wp-upg' ), 
		'upg_form_settings', 
		'ImageSettingPage', 
		'upg_ImageSettingPage_section' 
	);

	
	add_settings_field( 
		'upg_primary_global_field', 
		__( 'Media/Preview Layout Settings', 'wp-upg' ), 
		'upg_preview_layout_settings', 
		'ImageSettingPage', 
		'upg_ImageSettingPage_section' 
	);
	

	
	
	//End Basic Setting
	

	
	//Add Primary Images Settings
	register_setting( 'primary_images_setting_page', 'upg_settings' );
	add_settings_section(
		'upg_primary_image_section', 
		__( 'Form Fields & Shortcodes', 'wp-upg' ), 
		'upg_primary_image_section_callback', 
		'primary_images_setting_page'
	);

		
	
	add_settings_field( 
		'upg_primary_extra_field', 
		__( 'Extra Form Fields', 'wp-upg' ), 
		'upg_primary_custom_field_settings', 
		'primary_images_setting_page', 
		'upg_primary_image_section' 
	);
	
	 add_settings_field( 
		'upg_textarea_shortcode_1', 
		__( 'Shortcode for Position 1st', 'wp-upg' ), 
		'upg_textarea_shortcode_1_render', 
		'primary_images_setting_page', 
		'upg_primary_image_section' 
	); 
	 add_settings_field( 
		'upg_textarea_shortcode_2', 
		__( 'Shortcode for Position 2nd', 'wp-upg' ), 
		'upg_textarea_shortcode_2_render', 
		'primary_images_setting_page', 
		'upg_primary_image_section' 
	); 
			
		
	
	//Ultimate Member Setting Page
	register_setting( 'ImageSetting_ultimatemember_Page', 'upg_settings' );
	
		add_settings_section(
		'upg_ImageSettingPage_ultimatemember_section', 
		__( 'Social Profile Settings', 'wp-upg' ), 
		'upg_settings_section_ultimatemember_callback', 
		'ImageSetting_ultimatemember_Page'
	);
	
	 add_settings_field( 
		'upg_setting_ultimatemember_1', 
		__( 'Member Profile Tab', 'wp-upg' ), 
		'upg_setting_ultimatemember_1_render', 
		'ImageSetting_ultimatemember_Page', 
		'upg_ImageSettingPage_ultimatemember_section' 
	); 


	//Media Settings
	register_setting( 'MediaSetting_Page', 'upg_settings' );
	
		add_settings_section(
		'upg_MediaSettingPage_section', 
		__( 'Media Settings', 'wp-upg' ), 
		'upg_media_section_callback', 
		'MediaSetting_Page'
	);
	
	 add_settings_field( 
		'upg_setting_ultimatemember_1', 
		__( 'Images sizes & Settings', 'wp-upg' ), 
		'upg_media_setting_1_render', 
		'MediaSetting_Page', 
		'upg_MediaSettingPage_section' 
	); 
	 


}



 function upg_textarea_shortcode_1_render(  ) 
{ 

	$options = get_option( 'upg_settings' );
	if(isset($options['upg_textarea_shortcode_1']))
		$output=$options['upg_textarea_shortcode_1'];
		else
		$output="";
	?>
	You can include any other plugin shortcode or message. Eg. social share, buttons, notices<br>It will appear at media preview page only only if lightbox is off.<br>
	<textarea cols='60' rows='3' name='upg_settings[upg_textarea_shortcode_1]'><?php echo $output; ?></textarea>
	<?php

} 
 function upg_textarea_shortcode_2_render(  ) 
{ 

	$options = get_option( 'upg_settings' );
	if(isset($options['upg_textarea_shortcode_2']))
		$output=$options['upg_textarea_shortcode_2'];
		else
		$output="";
	?>
	<textarea cols='60' rows='3' name='upg_settings[upg_textarea_shortcode_2]'><?php echo $output; ?></textarea>
	<?php

} 

//Media settings Thumbnail
function upg_media_setting_1_render()
{
	$options = get_option( 'upg_settings' );

	if(!isset($options['upg_thumbnail_crop']))
		{
			$options['upg_thumbnail_crop']='0';
			
		}

		if(!isset($options['upg_thumbnail_size_h']))
		{
			$options['upg_thumbnail_size_w']="150";
			$options['upg_thumbnail_size_h']="150";

			

			$options['upg_medium_size_w']="300";
			$options['upg_medium_size_h']="300";

			$options['upg_large_size_w']="1024";
			$options['upg_large_size_h']="1024";
			
		}

	?>
	<b>UPG Thumbnail Size:</b> Width: <input name="upg_settings[upg_thumbnail_size_w]" type="number" step="1" min="0" id="upg_settings[upg_thumbnail_size_w]" value="<?php echo $options['upg_thumbnail_size_w']; ?>" class="small-text">  
	Height: <input name="upg_settings[upg_thumbnail_size_h]" type="number" step="1" min="0" id="upg_settings[upg_thumbnail_size_h]" value="<?php echo $options['upg_thumbnail_size_h']; ?>" class="small-text"> 
	<br>
	<input name="upg_settings[upg_thumbnail_crop]" type="checkbox" id="upg_settings[upg_thumbnail_crop]" value="1" <?php if($options['upg_thumbnail_crop']=='1') echo 'checked="checked"'; ?>> 
	<label for="upg_settings[upg_thumbnail_crop]">Crop thumbnail to exact dimensions (normally thumbnails are proportional)</label>
	<br><br>
	<b>UPG Medium Size: </b> &nbsp;&nbsp;&nbsp;&nbsp;Width: <input name="upg_settings[upg_medium_size_w]" type="number" step="1" min="0" id="upg_settings[upg_medium_size_w]" value="<?php echo $options['upg_medium_size_w']; ?>" class="small-text">  
	Height: <input name="upg_settings[upg_medium_size_h]" type="number" step="1" min="0" id="upg_settings[upg_medium_size_h]" value="<?php echo $options['upg_medium_size_h']; ?>" class="small-text">
	<br><br>
	<b>UPG Large Size: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Width: <input name="upg_settings[upg_large_size_w]" type="number" step="1" min="0" id="upg_settings[upg_large_size_w]" value="<?php echo $options['upg_large_size_w']; ?>" class="small-text">  
	Height: <input name="upg_settings[upg_large_size_h]" type="number" step="1" min="0" id="upg_settings[upg_large_size_h]" value="<?php echo $options['upg_large_size_h']; ?>" class="small-text">
	
	<?php

}


//Ultimate-Member functions
 function upg_setting_ultimatemember_1_render(  ) 
{ 

	$options = get_option( 'upg_settings' );
	if(isset($options['upg_ultimatemember_tabname']))
		$output=$options['upg_ultimatemember_tabname'];
		else
		$output="Gallery";
	
		if(!isset($options['upg_ultimatemember_enable']))
		{
			$options['upg_ultimatemember_enable']="0";
			
		}
		
			if(!isset($options['upg_buddypress_enable']))
		{
			$options['upg_buddypress_enable']="0";
			
		}
		
		if(isset($options['upg_ultimatemember_icon']))
		$output_icon=$options['upg_ultimatemember_icon'];
		else
		$output_icon="um-faicon-picture-o";
	
	?>
	
	<b>Enable <a href="https://wordpress.org/plugins/ultimate-member/" target="_blank">Ultimate-Member:</a></b> <input type="checkbox" name='upg_settings[upg_ultimatemember_enable]' value='1' <?php if($options['upg_ultimatemember_enable']=='1') echo 'checked="checked"'; ?> ><br>
	Shows tab on user profile page of Ultimate Member plugin.
	<br><br>
	  <b>Enable <a href="https://wordpress.org/plugins/buddypress/" target="_blank">BuddyPress:</a></b> <input type="checkbox" name='upg_settings[upg_buddypress_enable]' value='1' <?php if($options['upg_buddypress_enable']=='1') echo 'checked="checked"'; ?> ><br>
	Shows tab on user profile page of BuddyPress plugin.
	<br><br>
	
	<b>Tab-name</b> at profile page : <input type="text" name='upg_settings[upg_ultimatemember_tabname]' value='<?php echo $output; ?>' maxlength="20" size="20" ><br><br>
	<b>Tab-icon</b> at the Ultimate-Member profile page : <input type="text" name='upg_settings[upg_ultimatemember_icon]' value='<?php echo $output_icon; ?>' maxlength="20" size="20" > Eg. <a href="https://gist.github.com/plusplugins/b504b6851cb3a8a6166585073f3110dd" target="_blank">um-faicon-picture-o </a><br><br>
	
	<?php
	
	

} 
 
function upg_settings_section_ultimatemember_callback(  ) 
{ 

	echo ( 'Ultimate-Member is Wordpress membership plugin
that offers a member profile page.<br>After enabling the UPG plugin, you can cause
the Ultimate-Member profile page to have an extra tab and that tab can show the UPG post of your choice.<br><br>Basic settings applied to UPG-Post tab.');
	
	
}

function upg_media_section_callback()
{
	echo __( 'UPG Media Settings','wp-upg' );
	echo "<br>";
	echo ('Note: When you change WordPress themes or change the sizes of your thumbnails, images that you have previously uploaded to you media library will be missing thumbnail files for those new image sizes. Use <a href="https://wordpress.org/plugins/regenerate-thumbnails/">this plugin tool</a> to create those missing thumbnail files for all images.');
}





 function upg_quick_settings()
 {
	$frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax
	 $options = get_option('upg_settings');
		if(!isset($options['publish']))
		$options['publish']="0";
	
		if(!isset($options['guest_user']))
		$options['guest_user']=0;

		if(!isset($options['my_gallery']))
		$options['my_gallery']="";

		if(!isset($options['my_login']))
		$options['my_login']="";
	
	?>
	<button id='load_more_extra' type="button" style='margin:5px; font-size: 110%;'>Check Extra Settings</button>
	<hr>

	<div id='upg_toggle_extra' style='display: none;background-color: #F0F0F0;border-style: inset;padding: 20px;'>
	<br>
	<a href="#" title="<?php echo ( 'This will turn off all the advance settings.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<?php
echo "<b>Switch setting mode to: </b>";
echo $frm->addInput('radio', 'upg_settings[show_advance_setting]', '1',array('checked'=>'true')).' Advance ';
echo $frm->addInput('radio', 'upg_settings[show_advance_setting]', '0').' Basic ';

?>
<br><br>
	<a href="#" title="<?php echo ( 'Unpublished post are saved as draft. Admin must manually mark as published before it is visible to visitors.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> <b>Automatically publish UPG Post as soon as user upload/submit:</b> <input type="checkbox" name='upg_settings[publish]' value='1' <?php if($options['publish']=='1') echo 'checked="checked"'; ?> >
	<br><br>
	
	<a href="#" title="<?php echo ( 'When not logged in user submit post the post must be assigned with username.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>Assign user for unregistered or not logged in users: </b><?php upg_droplist_user($options['guest_user']); ?> <br>It's better to <a href="<?php echo admin_url( 'user-new.php' );?>">create GUEST USER</a> with minimum access.
	<br><br>
	
	
	
	<b>Include UPG post into archive page:</b> <input type="checkbox" name='upg_settings[archive]' value='1' <?php if($options['archive']=='1') echo 'checked="checked"'; ?> >
	<br>
	<br>
	<b>Disable purecss.io grid (rows/column) from frontend environment:</b> <input type="checkbox" name='upg_settings[purecss]' value='1' <?php if($options['purecss']=='1') echo 'checked="checked"'; ?> ><br>
	<br>
	 <b>Disable fontawesome CSS (fancy icons & buttons) from frontend environment:</b> <input type="checkbox" name='upg_settings[fontawesome]' value='1' <?php if($options['fontawesome']=='1') echo 'checked="checked"'; ?> ><br>
	<br>
	<b>Disable colorbox CSS (popup/Lightbox) from frontend environment:</b> <input type="checkbox" name='upg_settings[colorbox]' value='1' <?php if($options['colorbox']=='1') echo 'checked="checked"'; ?> ><br>
	

	<br>
<div style="border-style: outset;">
<a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a> 
	<?php
	
	echo "<b>Select MY GALLERY <a href='".admin_url( 'edit.php?post_type=page' )."'>page</a>. Display gallery submitted by logged in user.</b>: ";
    wp_dropdown_pages(
        array(
             'name' => 'upg_settings[my_gallery]',
             'echo' => 1,
             //'show_option_none' => __( '&mdash; Select &mdash;' ),
             //'option_none_value' => '0',
             'selected' => $options['my_gallery']
			 
        )
    );
	echo '<br>Page must include [upg-list user="show_mine"] shortcode in content.';
	?>
	</div>
	<br>
	<br>

<div style="border-style: outset;">
<?php echo '<img src="'.upg_PLUGIN_URL.'/images/new.png"> '; ?> 
 <a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a> 
	<?php
	
	echo "<b>Select LOGIN <a href='".admin_url( 'edit.php?post_type=page' )."'>page</a>.</b>: ";
    wp_dropdown_pages(
        array(
             'name' => 'upg_settings[my_login]',
             'echo' => 1,
             'show_option_none' => __( '&mdash; None &mdash;' ),
             'option_none_value' => '0',
             'selected' => $options['my_login']
			 
        )
    );
	echo '<br>Some area user need to login. Select proper login page.';
	//**************
	?>
	</div>
	 
	<?php
	do_action( "upg_setting_tab_basic_extra");
	echo "</div>"; 
 }

 function upg_grid_settings()
 {
	$options = get_option('upg_settings');
	?>
	<?php
	if(!isset($options['main_page']))
		$options['main_page']="";

		if(!isset($options['button_check_capability']))
		$options['button_check_capability']=0;


?>
<script>
//Load first record on page load
jQuery(document).ready(function () {

	jQuery("#load_more_extra").click(function (e) {
				jQuery("#upg_toggle_extra").slideToggle(1000);
				
		}) 
	
  jQuery("#load_more_grid").click(function (e) {
				jQuery("#upg_toggle_grid").slideToggle(1000);
				
		})  
		jQuery("#load_more_form").click(function (e) {
				jQuery("#upg_toggle_form").slideToggle(1000);
			
		})  
		jQuery("#load_more_media").click(function (e) {
				jQuery("#upg_toggle_media").slideToggle(1000);
			
    })  
})
</script>
<button id='load_more_grid' type="button" style='margin:5px; font-size: 110%;'>Check Grid Settings</button> [upg-list] & [upg-attach]
	<hr>

	<div id='upg_toggle_grid' style='display: none;background-color: #F0F0F0;border-style: inset;padding: 20px;'>
	
Use the shortcode <code>[upg-list]</code> to display the  primary gallery.<br>
Use the shortcode <code>[upg-attach]</code> to embed gallery to particular WordPress post.<br> Override the page’s settings by adding shortcode parameters (see example below).


<hr>

<div style="border-style: outset;">
<a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a> 
<?php
	echo "<b>Select USER POST GALLERY main <a href='".admin_url( 'edit.php?post_type=page' )."'>page</a>. It is used for SEO.</b>: ";
    wp_dropdown_pages(
        array(
             'name' => 'upg_settings[main_page]',
             'echo' => 1,
             //'show_option_none' => __( '&mdash; Select &mdash;' ),
             //'option_none_value' => '0',
             'selected' => $options['main_page']
			 
        )
    );
	echo "<br>Page cannot be static front page and it must include [upg-list] shortcode.";
	
	
	//**************
	?>
	</div>
	<br>
	<br>
	<b>Number of column (perrow) :</b> <input type="text" name='upg_settings[global_perrow]' value='<?php echo $options['global_perrow']; ?>' maxlength="2" size="5" ><br><br>
	
	<b>Number of records per page :</b> <input type="text" name='upg_settings[global_perpage]' value='<?php echo $options['global_perpage']; ?>' maxlength="3" size="5" ><br><br>
	
	<b>Order/Sort By :</b>
	
	<select name="upg_settings[global_order]" id="upg_settings[global_order]">
	<option value="date" <?php if($options['global_order']=="date") echo 'selected="selected"'; ?>>Posted Date</option>
	<option value="modified" <?php if($options['global_order']=="modified") echo 'selected="selected"'; ?>>Modified Date</option>
	<option value="title" <?php if($options['global_order']=="title") echo 'selected="selected"'; ?>>Title</option>
	<option value="rand" <?php if($options['global_order']=="rand") echo 'selected="selected"'; ?>>Random</option>
	<option value="ID" <?php if($options['global_order']=="ID") echo 'selected="selected"'; ?>>Post ID</option>
</select><br><br>
	
	<a href="#" title="<?php echo ( 'wp-pagenavi plugin must be installed and active.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	
	<b>Enable Page Navigation :</b> <input type="checkbox" name='upg_settings[global_page]' value='on' <?php if($options['global_page']=='on') echo 'checked="checked"'; ?> ><br><br>
	
		<a href="#" title="<?php echo ( 'Image will get enlarged at same page. There is no change in page hence no preview layout is used.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
		
		<b>Enable Lightbox Popup :</b> <input type="checkbox" name='upg_settings[global_popup]' value='on' <?php if($options['global_popup']=='on') echo 'checked="checked"'; ?> ><br><br>
		
		
	<b>Default UPG Post Album: </b> 
<?php 
wp_dropdown_categories( 'show_count=1&hierarchical=1&taxonomy=upg_cate&value_field=slug&name=upg_settings[global_album]&selected='.$options['global_album'].'&hide_empty=0&show_option_none=All Categories&option_none_value=' );
 ?>
 <br>
 <br>
 
 
 
 <table border="0"><tr><td>
 <a href="#" title="<?php echo ( 'Grid layout is where [upg-list] shortcode is used.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a>  
 <b>Default Grid Layout Name </b>:</td><td>

<?php echo upg_grid_layout_list($options['global_layout'],"upg_settings[global_layout]","grid",true); ?>
</td></tr></table>


	<b>Display Image Upload Button :</b> <input type="checkbox" name='upg_settings[primary_show_image_button]' value='1' <?php if($options['primary_show_image_button']=='1') echo 'checked="checked"'; ?> ><br>
	Submit Button will be displayed which is linked to page where [upg-post type=image] shortcode is used. Link page is at Global Settings tab.
	<br><br>
	
	
	<b>Display Post Video URL Button:</b> <input type="checkbox" name='upg_settings[primary_show_youtube_button]' value='1' <?php if($options['primary_show_youtube_button']=='1') echo 'checked="checked"'; ?> ><br>
	Submit Youtube Button will be displayed which is linked to page where [upg-post type=youtube] shortcode is used. Link page is form settings.
	<br><br>
	
	
	<a href="#" title="<?php echo ( 'This will check if the user is logged in or not.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>Display post buttons for logged-in users (Any User Role) : </b>
	<input type="checkbox" name='upg_settings[button_check_login]' value='1' <?php if($options['button_check_login']=='1') echo 'checked="checked"'; ?> ><br>
	This will hide upload/post button from guest visitors.
	<br>
	<br>
	
	<a href="#" title="<?php echo ( 'Post button displayed only to logged in user but who have capabilities to edit current post.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>Display post buttons only for logged-in users but with editing rights : </b>
	<input type="checkbox" name='upg_settings[button_check_capability]' value='1' <?php if($options['button_check_capability']=='1') echo 'checked="checked"'; ?> ><br>
	This will show post button only to user with editing capabilities of current post.  This works only to [upg-attach] shortcode.
	<br>
	<br>
  <b>Show trash icon at front-end: </b>
	<input type="checkbox" name='upg_settings[show_trash_icon]' value='1' <?php if($options['show_trash_icon']=='1') echo 'checked="checked"'; ?> ><br>
	This will show trash icon button for logged-in user in gallery & preview page.
	<br>
	<br>
  <b>Show Edit/Update icon at front-end: </b>
	<input type="checkbox" name='upg_settings[show_edit_icon]' value='1' <?php if($options['show_edit_icon']=='1') echo 'checked="checked"'; ?> ><br>
	This will show edit icon at gallery. This will let user to update submitted post.
	<br><br>
  <b>Show user icon at front-end: </b>
	<input type="checkbox" name='upg_settings[show_user_icon]' value='1' <?php if($options['show_user_icon']=='1') echo 'checked="checked"'; ?> ><br>
	This will show user icon button in gallery page which list upg-post submitted by user.

		<hr>
	<div class="update-nag">
	<b>Shortcode generated with above configuration to display Primary-Image Gallery</b><br><br>
	<code>[upg-list 
	perrow="<?php echo $options['global_perrow']; ?>" 
	perpage="<?php echo $options['global_perpage']; ?>" 
	orderby="<?php echo $options['global_order']; ?>" 
	page="<?php echo $options['global_page']; ?>" 
	layout="<?php echo $options['global_layout']; ?>" 
	popup="<?php echo $options['global_popup']; ?>"
	album="<?php echo $options['global_album']; ?>" 
	<?php
	if(isset($options['primary_show_image_button']) || isset($options['primary_show_youtube_button']))
	{
		echo 'button="on"';
	}
	?>
	
	]</code>
	<br><br>
	Global settings will only be applied to below shortcode with only missing parameters.<br>
	<br>
	<code>	[upg-list]</code> : List post as of default settings of missing parameters.<br>
	<code>[upg-list album="<?php echo $options['global_album']; ?>"]</code> : Displays post in grid layout of specific album/category<br>
  <code>[upg-list tag=""]</code> : Displays post related to tags.<br>
	<code>[upg-list popup="on"]</code> : LightBox/Popup will be enabled. No preview page is used.<br>
	
	</div>
	<?php
	do_action( "upg_setting_tab_basic_grid");	
	?>

</div>
	<?php
 }

 function upg_form_settings() 
 {
$options = get_option('upg_settings');


	if(!isset($options['guest_user']))
		$options['guest_user']="";
	
	if(!isset($options['archive']))
		$options['archive']="0";


		if(!isset($options['editor']))
		$options['editor']="0";

	
	
	
	?>
	<button id='load_more_form' type="button" style='margin:5px; font-size: 110%;'>Check Form Settings</button> [upg-post]
	<hr>
	<div id='upg_toggle_form' style='display: none;background-color: #F0F0F0;border-style: inset;padding: 20px;'>
	If you don't want user submission form, skip the settings below.<br> Submission form must have 	<code>[upg-post type="image"]</code> or 	<code>[upg-post type="youtube"]</code> as shortcode.<hr>
	
	<?php
	if(!isset($options['post_image_page']))
		$options['post_image_page']="";
?>
<div style="border-style: outset;">
<a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a> 
<?php
	echo "<b>Select POST IMAGE <a href='".admin_url( 'edit.php?post_type=page' )."'>page</a>.</b>: ";
    wp_dropdown_pages(
        array(
             'name' => 'upg_settings[post_image_page]',
             'echo' => 1,
             //'show_option_none' => __( '&mdash; Select &mdash;' ),
             //'option_none_value' => '0',
             'selected' => $options['post_image_page']
			 
        )
    );
	echo "<br>It is the page to upload/post image/post. Page must contain [upg-post type=\"image\"] shortcode.";
	
	//**************
	?>
	</div><br><br>
	
	<?php
	if(!isset($options['post_youtube_page']))
		$options['post_youtube_page']="";

	?>
	<div style="border-style: outset;">
<a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a> 
	<?php
		echo "<b>Select POST VIDEO URL <a href='".admin_url( 'edit.php?post_type=page' )."'>page</a>.</b>: ";
    wp_dropdown_pages(
        array(
             'name' => 'upg_settings[post_youtube_page]',
             'echo' => 1,
             //'show_option_none' => __( '&mdash; Select &mdash;' ),
             //'option_none_value' => '0',
             'selected' => $options['post_youtube_page']
			 
        )
    );
	echo "<br>It is the page to upload/post image/post. Page must contain [upg-post type=\"youtube\"] shortcode.";
	
	echo "</div><br><br>";
	
	
 	if(!isset($options['edit_upg_page']))
		$options['edit_upg_page']="";

	?>
	<div style="border-style: outset;">
<a href="#" title="<?php echo __( 'Important settings', 'wp-upg' ); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?></a> 
	<?php
		echo "<b>Select UPG Edit <a href='".admin_url( 'edit.php?post_type=page' )."'>page</a>.</b>: ";
    wp_dropdown_pages(
        array(
             'name' => 'upg_settings[edit_upg_page]',
             'echo' => 1,
             //'show_option_none' => __( '&mdash; Select &mdash;' ),
             //'option_none_value' => '0',
             'selected' => $options['edit_upg_page']
			 
        )
    );
	echo "<br>It is the page to edit/modify submitted post by user. Page must contain [upg-edit] shortcode."; 
	
	echo "</div><br><br>";

	//**************
?>


<a href="#" title="<?php echo ( 'This settings doesn\'t get applied to personal layout.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>Display description input field at post form:</b> <input type="checkbox" name='upg_settings[primary_show_formshow_desp]' value='1' <?php if($options['primary_show_formshow_desp']=='1') echo 'checked="checked"'; ?> >
	<br><br>
	

	
	<a href="#" title="<?php echo ( 'This settings doesn\'t get applied to personal layout.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>Enable GUI Editor (Bold,Italic,color) in description input field at post form:</b> <input type="checkbox" name='upg_settings[editor]' value='1' <?php if($options['editor']=='1') echo 'checked="checked"'; ?> >
	<br><br>
	
	<a href="#" title="<?php echo ( 'User at front-end don\'t require to post image compulsory but image upload field will be visible.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>Make image upload compulsory or required during post submission.:</b> <input type="checkbox" name='upg_settings[image_required]' value='1' <?php if($options['image_required']=='1') echo 'checked="checked"'; ?> >
	<br><br>
	
	<a href="#" title="<?php echo ( 'Page doesn\'t get changed during form submission.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a> 
	<b>AJAX dynamic form submission:</b> <input type="checkbox" name='upg_settings[ajax_form]' value='1' <?php if(isset($options['ajax_form'])) if($options['ajax_form']=='1') echo 'checked="checked"'; ?> >
	<br>Add parameter ajax="true" in [upg-post] shortcode to enable ajax.<br>
	Note: Bulk upload will not work in ajax form<br><br>
	
	<table border="0"><tr><td>
	<a href="#" title="<?php echo ( 'Form layout is where [upg-post] shortcode is used.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a>  
 <b>Default Form Layout Name </b>:</td><td>

<?php echo upg_grid_layout_list($options['global_form_layout'],"upg_settings[global_form_layout]","form",false); ?>
</td></tr></table>
	
<?php
	do_action( "upg_setting_tab_basic_form");	
	?>
	</div>
	<?php
}
function upg_primary_custom_field_settings()
{
	$options = get_option('upg_settings');

	
	?>
	<b>Note:</b> Custom Extra Fields values can be displayed in more dynamic way by using your own PHP code at [<b>Layout Editor: personal layout</b>]. Use personal layout for post.  
	<table class="pure-table pure-table-horizontal">
    <thead>
        <tr>
            <th>Type</th>
            <th>Internal Field Name</th>
            <th>Label Field Name</th>
            <th>Display Back end</th>
			<th>Display Front end</th>
        </tr>
    </thead>

    <tbody>
	<?php
	for ($x = 1; $x <= 5; $x++) 
	{
	?>
        <tr>
            <td>
			<select name='upg_settings[upg_custom_field_type_<?php echo $x; ?>]'>
			  <option value="222" <?php if($options['upg_custom_field_type_'.$x]=='text') echo 'selected'; ?>>Text</option>
			  <option value="checkbox" <?php if($options['upg_custom_field_type_'.$x]=='checkbox') echo 'selected'; ?>>Checkbox</option>
			</select>
			
					
			</td>
            <td>upg_custom_field_<?php echo $x; ?></td>
            
			<td><input type="text" name='upg_settings[upg_custom_field_<?php echo $x; ?>]' value='<?php echo $options['upg_custom_field_'.$x]; ?>' maxlength="20" size="20" ></td>
            
			<td><input type="checkbox" name='upg_settings[upg_custom_field_<?php echo $x; ?>_show]' value='on' <?php if($options['upg_custom_field_'.$x.'_show']=='on') echo 'checked="checked"'; ?> ></td>
			
			 <td><input type="checkbox" name='upg_settings[upg_custom_field_<?php echo $x; ?>_show_front]' value='on' <?php if($options['upg_custom_field_'.$x.'_show_front']=='on') echo 'checked="checked"'; ?> ></td>
        </tr>
	<?php
	}
?> 
    </tbody>
</table>
	<?php
	
	
}


 function upg_preview_layout_settings() 
 {
	$options = get_option('upg_settings');

	if(!isset($options['hide_title']))
	$options['hide_title']="0";
		
	?>
	<button id='load_more_media' type="button" style='margin:5px; font-size: 110%;'>Check Media/Preview Settings</button>
	<hr>
	<div id='upg_toggle_media' style='display: none;background-color: #F0F0F0;border-style: inset;padding: 20px;'>
	
	If LightBox or popup are enabled in grid layout. The media/preview page is not visible. Hence below settings are not required. This page doesn't require any shortcode. It is auto generated.
	<hr>
		
<a href="#" title="<?php echo ( 'Sometime due to special theme, UPG will show two titles. You need to enable to make it one.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a>
	<b>Hide one UPG title if found double :</b> <input type="checkbox" name='upg_settings[hide_title]' value='1' <?php if($options['hide_title']=='1') echo 'checked="checked"'; ?> >
	<br>
	<br>

	<table border="0"><tr><td>
	<a href="#" title="<?php echo ( 'Media layout is UPG system. Preview parameter in [upg-post] shortcode is for media layouts.'); ?>" class="upg_tooltip"><?php echo '<img src="'.upg_PLUGIN_URL.'/images/info.png">'; ?></a>  
 <b>Default Media Layout Name </b>:</td><td>

<?php echo upg_grid_layout_list($options['global_media_layout'],"upg_settings[global_media_layout]","media",false); ?>
</td></tr></table>

	<hr>
	<div class="update-nag">
	<b>To display single UPG post by ID : BETA version</b><br>
	<code>[upg-pick id='00' notice='SALE']</code><br>
	layout & popup parameters are supported for upg-pick
	
	</div><br>
	<?php
	do_action( "upg_setting_tab_basic_media");	
	?>
	</div>
	<?php
	
}


function upg_settings_section_callback(  ) 
{ 
	//echo __( 'Update or modify required settings.', 'upg' );
	/**
 * Detect plugin. For use on Front End only.
 */
 //include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
$options = get_option('upg_settings');  
		if($options['main_page']=='0' || $options['main_page']=='')
			{ 
				?>
				<h3>Steps to install UPG:</h3>
            <p>Some pages are auto created. Do not delete them even if not required.
			<ul>
			<li>1. <b>User’s Post Gallery</b>: Main UPG gallery page. <?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?> - Grid Settings)</li>
			<li>2. <b>Post Image</b>: Submission page for images. <?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?> - Form Settings)</li> 
			<li>3. <b>Post Video URL</b>: Submission page for YouTube/Vimeo URL. <?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?> - Form Settings)</li>
			<li>4. <b>Edit UPG Post</b>: Let users to modify/update own UPG post. <?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?> - Form Settings)</li>
			<li>5. <b>My Gallery</b>: Registered user can see own submitted post. <?php echo '<img src="'.upg_PLUGIN_URL.'/images/star.png">'; ?> - Extra Settings) </li>
			
			</ul>
			</p>
				
				
				<?php

			}
	?>

	<?php
}

function upg_primary_image_section_callback(  ) 
{ 
echo '<b>';
echo ( 'Shortcode to display submission on front page is [upg-post type="image"] & [upg-post type="youtube"]');
echo '</b>';
	
}

function upg_options_page(  ) 
{ 
	$options = get_option('upg_settings');  
/**
 * Detect plugin. For use on Front End only.
 */
 //include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$proactive=false;
 
	if ( is_plugin_active( 'wp-upg-pro/odude-ecard-pro.php' ) ) 
	{
		 $proactive=true;
	} 
	
	$propassive="This features required premium support.";

	?>
	
	<script>
jQuery(document).ready(function($){
       $("#tabs").tabs();
});
  </script>
  
<div class="wrap">
	<form action='options.php' method='post'>
	
		<h2>User Post Gallery (UPG) Settings</h2>
		<div id="tabs">
	<ul>
		
        <li><a href="#tab-1"><?php echo __("Basic Settings","wp-upg");?></a></li>
       
		
		<li><a href="#tab-3"><?php echo __("Form Fields","wp-upg");?></a></li> 
		
		<li> <a href="#tab-2"><?php echo __("Social Profile","wp-upg");?></a></li> 
		<li> <a href="#tab-4"><?php echo __("Media Settings","wp-upg");?></a></li> 
		
		<?php
		do_action( "upg_setting_tab_title" , $upg_tab_title_id="", $upg_tab_title_label="" );
		?>
				
	</ul>
	 <div id="tab-1">
     <?php
	 settings_fields( 'ImageSettingPage' );
	do_settings_sections( 'ImageSettingPage' );
	 ?>
    </div>
   
	<div id="tab-3">
      <?php
	  
	  settings_fields( 'primary_images_setting_page' );
	  do_settings_sections( 'primary_images_setting_page' );
	  
	  ?>
    </div>
	
			 <div id="tab-2">
      <?php
	  
	 settings_fields( 'ImageSetting_ultimatemember_Page' );
	  do_settings_sections( 'ImageSetting_ultimatemember_Page' );
	  
	  ?>
    </div>

	<div id="tab-4">
	<?php
		settings_fields('MediaSetting_Page');
		do_settings_sections('MediaSetting_Page');
	?>
	</div>
	
	<?php
		do_action( "upg_setting_tab_body" , $upg_tab_title_id="");
		?>
	
	</div>
		
		<?php
		flush_rewrite_rules();
		submit_button();
		?>
		
	</form>
</div>
	<?php
}
?>