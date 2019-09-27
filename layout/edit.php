<?php
function upg_layout_page()
{
	$options = get_option('upg_settings');
	$current_page=admin_url( 'edit.php?post_type=upg&page=wp_upg_layout');
	$current_page=add_query_arg( 'file', '', $current_page );
	$grid_layout="basic";
	$media_layout="basic";
	$form_layout="basic";
	
	if (function_exists('wp_enqueue_code_editor')) 
	wp_enqueue_code_editor( array( 'type' => 'text/x-php' ) );
	wp_enqueue_script( 'js-code-editor', plugins_url() .'/'. upg_FOLDER. '/js/code-editor.js', array( 'jquery' ), '', true );
				
	
	if(isset($_GET['type']))
		{
			if($_GET['type']=='grid')
				$grid_layout=$_GET['file'];
			else if($_GET['type']=='media')
				$media_layout=$_GET['file'];
			else if($_GET['type']=='form')
				$form_layout=$_GET['file'];
				
		}
			

	
	//$content =  file_get_contents($user_dirname);
	//Get media/preview file code
	$content = upg_get_layout_code($media_layout,'media','content');
	
	$settings = array(
				    'wpautop'          => false,  // enable rich text editor
				    'media_buttons'    => false,  // enable add media button
				    'textarea_rows'    => '30',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'widefat textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => false,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => false, // enable drag-drop
				);	
	
	?>
<div class="wrap">
<?php
		do_action( "upg_admin_top_menu");
		?>
	<h2>Layout Editor</h2>	 
	<b>Notes:</b><br>
	# This is your personal Layout which is designed only for you. Use it only if you are good at html/php script. <br>
	
	# <font color="blue">If you update, the <b>personal layout</b> will be updated. No changes at other layouts.</font><br>	
	
	# Even after plugin updated, the created file will not be updated. You need to update it manually if required. <br>
	
	# If you ended up with error, choose other layout and update personal layout again. 
<br>
<?php include("import_layout.php"); ?>



	<script>
jQuery(document).ready(function($){
       $("#tabs").tabs();
});
  </script>
  	<div id="tabs">
	<ul>
		
       
	
		<li><a href="#tab-2"><?php echo "Grid File";?></a></li>
		 <li><a href="#tab-1"><?php echo "Preview File";?></a></li>
		<li><a href="#tab-3"><?php echo "Pick File";?></a></li>
		<li><a href="#tab-4"><?php echo "Post Form File";?></a></li>
		<li><a href="#tab-5"><?php echo "Post Embed URL File";?></a></li>
		
       </ul>
	 <div id="tab-1">
	 
	 <?php
if(isset($_POST['newcontent']))
	{
		echo "<h2>Media/Preview File Update</h2>";
		//upg_save_layout_code(wp_unslash($_POST['newcontent']),$media_layout,'media',$media_layout);
		echo upg_save_layout_code(wp_unslash($_POST['newcontent']),'personal','media','content')."<hr>";
		
	}
?>	 
	 <form  id="listpressMedia">
	 <table border="0" width="100%"><tr><td width="50%">
	<h2><?php echo $media_layout; ?> layout</h2>
	 
	This layout is used for single UPG post. If lightbox popup is enabled, this page won't get activated.
	 </td><td align="right"><b>Copy code from :</b> </td><td>
<?php echo upg_grid_layout_list($media_layout,"listpress_settings[global_layout]","media",false); ?></td></tr></table>
</form>
<script>
var sz = document.forms['listpressMedia'].elements['listpress_settings[global_layout]'];
// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        //this.form.elements.total.value = this.value;
		var link='<?php echo $current_page; ?>='+this.value+'&type=media#tab-1';
		window.location.href = link;
		//alert(link);
    };
}
</script>

	
	
	<br>
	<form class="pure-form" method="post" action="">
	<table border='1' width='99%'>
	<tr><td valign="top" width="70%">
 
	
		<?php
			wp_editor( $content, 'newcontent', $settings );
	?>
	
	
	</td>
	<td valign='top' style="background-color:#eeeeee ;">
	<b>Below are the php variables/fields you can use between PHP tag.</b><hr>
	<b>$image</b> = URL of the large image<br>
	<b>$text </b>= Description of image <br>
	<b>$post_status</b>= Return draft (Under review) or published<br>
	<br>
	<br>
	<b>upg_get_filed_label('upg_custom_field_2')</b> = <br>Get (Label Field Name) saved for extra custom fields inside UPG Settings.<br> 
	Syntax : echo upg_get_filed_label('Internal field name');
	<br>
	<b>upg_get_value('upg_custom_field_2')</b> = <br>Get value saved for extra custom fields inside UPG Posts.<br> 
	Syntax : echo upg_get_value('Internal field name');
	<br>
	<br>
	<b>$author->user_nicename</b> = Author's Nice name. $author is array.
	<b>upg_author($author,true)</b> = Author image icon/avatar. If second variable is true, it will link to social profile plugin else will display classic gallery of UPG. <br>
	<br>
	<b>upg_isVideo($post)</b> = Check if media is video or image (true/false)<br>


	<b>upg_position1()</b> = Shortcode area for Position 1st<br>
	<b>upg_position2()</b> = Shortcode area for Position 2nd<br>
	<br>
	<br><b>upg_list_tags($post);</b> = Print tags with link associated with post.
	<br><br>
	<b>upg_get_album($post,'name')</b>= Returns album name <br>
	<b>upg_get_album($post,'url')</b>= Returns album link url <br>
	<b>upg_get_album($post,'slug')</b>= Returns album slug <br>
	
	<hr>
	<b>Tips</b>:
	<br>
	* You can copy paste css code for your own style between style tag.<br>
	* You can use UPG built in grid system https://purecss.io/ <br>
	* For better css style http://fontawesome.io/ is included by default. <br>
	* Even after plugin update, your changes will not be lost.
	
	
	
	</td></tr></table>
	<br>
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Personal Post Preview File">
	</form>
	</div>
	

	
	
	 <div id="tab-2">
	 
	 	<?php
	
	if(isset($_POST['personal_up']))
	{
		echo "<h2>Grid File Update</h2>";
		
		/* upg_save_layout_code(wp_unslash($_POST['personal_up']),$grid_layout,'grid',$grid_layout.'_up');
		
		upg_save_layout_code(wp_unslash($_POST['personal_down']),$grid_layout,'grid',$grid_layout.'_down');
			
		upg_save_layout_code(wp_unslash($_POST['personal_main']),$grid_layout,'grid',$grid_layout); */
		
		upg_save_layout_code(wp_unslash($_POST['personal_up']),'personal','grid','personal_up');
		
		upg_save_layout_code(wp_unslash($_POST['personal_down']),'personal','grid','personal_down');
			
		echo upg_save_layout_code(wp_unslash($_POST['personal_main']),'personal','grid','personal_main')."<hr>";
		
	}
	
	$content_up = upg_get_layout_code($grid_layout,'grid',$grid_layout.'_up');

	$content_down = upg_get_layout_code($grid_layout,'grid',$grid_layout.'_down');

	$content_main =upg_get_layout_code($grid_layout,'grid',$grid_layout.'_main');
	?>
	 
		 <form  id="listpressGrid">
	 <table border="0" width="100%"><tr><td width="50%">
	 <b>Gallery Grid Layout</b> <h2><?php echo $grid_layout; ?> layout</h2>
	Shortcode: [upg-list layout="<?php echo $grid_layout; ?>"]
	
	 </td><td align="right"><b>Copy code from:</b>: </td><td>
<?php echo upg_grid_layout_list($grid_layout,"listpress_settings[global_layout]","grid",true); ?></td></tr></table>
</form>
<script>
var sz = document.forms['listpressGrid'].elements['listpress_settings[global_layout]'];
// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        //this.form.elements.total.value = this.value;
		var link='<?php echo $current_page; ?>='+this.value+'&type=grid';
		window.location.href = link;
		//alert(link);
    };
}
</script>
	<br>

	<form class="pure-form" method="post" action="">
	<table border='1' width='99%'>
	<tr><td width="70%">
	<b>Grid Layout Up</b>(<?php echo $grid_layout; ?>_up.php)<br>
	It is used as a grid's container starting code. <br>
	Style tag can be included here.<hr>
	
	<textarea cols="90" rows="5" style="background-color:#ffefbf;" id="personal_up" name="personal_up" class="widefat textarea"><?php echo $content_up; ?></textarea>  
	
	<hr>
	<b>Grid Layout Main</b>(<?php echo $grid_layout; ?>_main.php)<br>
	Repeated body inside loop.<hr>
	<textarea cols="90" rows="10" name="personal_main" id="personal_main" class="widefat textarea"><?php echo $content_main; ?></textarea>
	
	<hr>
	<b>Grid Layout Down</b>(<?php echo $grid_layout; ?>_down.php)<br>
	It is used as a grid's container ending code. <hr>
	<textarea name="personal_down" id="personal_down" class="widefat textarea" cols="90" rows="5" style="background-color:#ffefbf;"><?php echo $content_down; ?></textarea>

	
	</td>
	<td valign='top' style="background-color:#eeeeee;">
	<b>Below are the php variables/fields you can use between PHP tag.</b><hr>
	<b>$image</b> = URL of the thumbnail image<br>
	<b>$preview_large</b> = URL of the large image <br>
	<b>$permalink</b> = URL to the image post content <br>
	<b>$thetitle</b> = Title of the image <br>
	
	<b>$popup </b>= Returns popup is on/off<br>
	<b>$preview_type</b> = Returns preview as image/embed <br>
	<b>$perrow </b>= Returns number of row to display. Used in loops.<br>
	<b><?php //echo '<img src="'.upg_PLUGIN_URL.'/images/new.png"> '; ?> $post_status</b>= Return draft (Under review) or published<br>
	<b>$count</b> = Displays total number of post found.
	<br><br>
	<br> 
	<b>upg_get_album($post,'name')</b>= Returns album name <br>
	<b>upg_get_album($post,'url')</b>= Returns album link url <br>
	<b>upg_get_album($post,'slug')</b>= Returns album slug <br>
	
	<br>
	<b>$post->post_title;</b>= Returns UPG post title <br>
	
	<br>
	 
	<b>upg_breakLongText($text, $length = 200, $maxLength = 250)</b> = Breaks $text or content into small paragraph.
	<hr>
	<b>upg_get_value('upg_custom_field_2')</b> = <br>Get value saved for extra custom fields inside primary-image gallery.<br> Syntax : upg_get_value('Internal field name');
	<br>

	
	<hr>
	<b>Tips</b>:
	<br>

	* You can use UPG built in grid system https://purecss.io/ <br>
	* For better css style http://fontawesome.io/ is included by default. <br>
	* Even after plugin update, your changes will not be lost.
	
	
	
	</td></tr></table>
	<br>
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Personal Grid Layout File">
	</form>
	
	
	
	 </div>
	 
	 
	 
	 
	 <div  id="tab-3" >
	  <?php

	if(isset($_POST['personal_pick']))
	{
		echo "<h2>Updating Personal Pick File</h2>";
		//upg_save_layout_code(wp_unslash($_POST['personal_pick']),$grid_layout,'grid',$grid_layout.'_pick');
		echo upg_save_layout_code(wp_unslash($_POST['personal_pick']),'personal','grid','personal_pick')."<hr>";
		
	}
	
	
	//$content_pick =  file_get_contents($user_dirname_pick);
	$content_pick = upg_get_layout_code($grid_layout,'grid',$grid_layout.'_pick');
	 
	 ?>
	  		 <form  id="listpressPick">
	 <table border="0" width="100%"><tr><td width="50%">
	 <b>Pick Layout: </b> \layout\media\personal\<?php echo get_current_blog_id(); ?>_personal_pick.php)
	
	<br>
	This layout is used if you want to display selected UPG Post into pages or WP-Posts.
	<h2><?php echo $grid_layout; ?> layout</h2>
	
	Shortcode: Eg.	[upg-pick id='xxx' notice='Your Choice' layout='<?php echo $grid_layout; ?>']<br>
	id='xxx' is ID of UPG Gallery. Eg. id='11'<br>
	 </td><td align="right"><b>Copy code from: </b>: </td><td>
<?php echo upg_grid_layout_list($grid_layout,"listpress_settings[global_layout]","grid",false); ?></td></tr></table>
</form>
<script>
var sz = document.forms['listpressPick'].elements['listpress_settings[global_layout]'];
// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        //this.form.elements.total.value = this.value;
		var link='<?php echo $current_page; ?>='+this.value+'&type=grid#tab-3';
		window.location.href = link;
		//alert(link);
    };
}
</script>
	   
		<br>
	<form class="pure-form" method="post" action="">
	<table border='1' width='99%'>
	<tr><td valign="top" width="70%">
	
	<?php
			wp_editor( $content_pick, 'personal_pick', $settings );
	?>
	
	
	</td>
	<td valign='top' style="background-color:#eeeeee ;">
	
	<b>Below are the php variables/fields you can use between PHP tag.</b><hr>
	
	<b>$image</b> = URL of the thumbnail image<br>
	<b>$preview_large</b> = URL of the large image <br>
	<b>$permalink</b> = URL to the image post content <br>
	<b>$thetitle</b> = Title of the image <br>
	<br>
	<b>$popup </b>= Returns popup is on/off<br>
	<b>$preview_type</b> = Returns preview as image/embed <br>
	
	
	<br>
	
	
	
	<hr>
	<b>Tips</b>:
	<br>

	* You can use UPG built in grid system https://purecss.io/ <br>
	* For better css style http://fontawesome.io/ is included by default. <br>
	* Even after plugin update, your changes will not be lost.
	
	</td></tr></table>
	<br>
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Personal Pick Layout File">
	</form>
	  
	  
	  
	  
	 </div>
	 
  
	  <div  id="tab-4" >
	  	 <?php
	 //Personal Post form update

	if(isset($_POST['personal_form_post']))
	{
		echo "<h2>Update Post Form File</h2>";
		
		
		echo upg_save_layout_code(wp_unslash($_POST['personal_form_post']),'personal','form','personal_post_form')."<hr>";
		
		echo upg_save_layout_code(wp_unslash($_POST['personal_form_edit']),'personal','form','personal_edit_form')."<hr>";
				
		
	}
		
	
	//$content_post_form =  file_get_contents($user_dirname_post_form);
	$content_post_form=upg_get_layout_code($form_layout,'form',$form_layout.'_post_form');
	$content_edit_form=upg_get_layout_code($form_layout,'form',$form_layout.'_edit_form');
	 
	 ?>

	   <form  id="listpressForm">
	 <table border="0" width="100%"><tr><td width="50%">
	 <b>UPG Post Form: </b><h2><?php echo $form_layout;?> layout</h2>
	 Shortcode: [upg-post type="image" layout="<?php echo $form_layout;?>"] <br>
	This layout is used to show image submission form.
	<br>
	<font color="red">Due to html <b>form</b> tag, the submission may not work in chrome browser.</font>
	 
	 </td><td align="right"><b>Copy code from</b>: </td><td>
<?php echo upg_grid_layout_list($form_layout,"listpress_settings[global_layout]","form",false); ?></td></tr></table>
</form>
<script>
var sz = document.forms['listpressForm'].elements['listpress_settings[global_layout]'];
// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        //this.form.elements.total.value = this.value;
		var link='<?php echo $current_page; ?>='+this.value+'&type=form#tab-4';
		window.location.href = link;
		//alert(link);
    };
}
</script>
	  
	
	
		<form class="pure-form" method="post" action="">
	<table border='1' width='99%'>
	<tr><td width="70%" valign="top">
	<h2>Post Form</h2>This form is used to post by user.<br>
	<?php
	wp_editor( $content_post_form, 'personal_form_post', $settings );
	?>
		<h2>Edit Form</h2>This form is used to edit post submitted by user.
<?php
	wp_editor( $content_edit_form, 'personal_form_edit', $settings );
	?>
	
	</td>
	<td valign='top' style="background-color:#eeeeee ;"><br>
	<a class='button' href='https://odude.com/upg-user-post-gallery/upg-form/' target='_blank'>Generate form with shortcode</a>
	<hr>
	<b>HTML id & name parameters are important part in form creation. Some name are reserved by default.</b><hr>
	
	<b>Title Field </b>: id="name" name="user-submitted-title" <br><br>
	<b>Description Field</b>: name="user-submitted-content" <br><br>
	
	<b>Category/Album Field</b>: name='cat' value='2' <br>
	The value field will have a ID of album. To generate dynamic category selection use php function as upg_droplist_category('','');<br><br>
	
	<b>For File field </b>: id="file" name="user-submitted-image[]" type="file"<br>
	<br>
	<b>Custom Fields</b>: name="upg_custom_field_1" <br>
	There are 5 custom fields (i.e. upg_custom_field_1, upg_custom_field_2, upg_custom_field_3, upg_custom_field_4, upg_custom_field_5)<br>
	You can assign any label name and type but form name should be equals to above. 
	<br><br>
	<b>Submit Button</b>: type="submit" name="SN"<br><br>
	

	<hr>
	<b>Tips</b>:
	<br>

	* You can use UPG built in grid system https://purecss.io/ <br>
	* For better css style http://fontawesome.io/ is included by default. <br>
	* Even after plugin update, your changes will not be lost.
	
	</td></tr></table>
	<br>
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Personal Post Form File">
	</form>
	
	
	
	
	  </div>
	    
	   <div  id="tab-5" >
	   
	   <?php
	 //Personal Post form update
	
	if(isset($_POST['personal_post_youtube']))
	{
		echo "<h2>Update Embed Form File</h2>";
				
		echo upg_save_layout_code(wp_unslash($_POST['personal_post_youtube']),'personal','form','personal_post_youtube')."<hr>";
		
		echo upg_save_layout_code(wp_unslash($_POST['personal_edit_youtube']),'personal','form','personal_edit_youtube')."<hr>";
	}
	
	
	//$content_post_youtube =  file_get_contents($user_dirname_post_youtube);
	$content_post_youtube = upg_get_layout_code($form_layout,'form',$form_layout.'_post_youtube');
	$content_edit_youtube = upg_get_layout_code($form_layout,'form',$form_layout.'_edit_youtube');
	 
	 ?>
	   
	   <form  id="listpressYoutube">
	 <table border="0" width="100%"><tr><td width="50%">
	 <b>UPG Post Embed Form: </b><h2><?php echo $form_layout;?> layout</h2>
	Shortcode: [upg-post type="embed" layout="<?php echo $form_layout;?>"] <br>
	This layout is used to show submission form for embed url only. It cannot be combined with file upload.
	<br>
	<font color="red">Due to html <b>form</b> tag, the submission may not work in chrome browser.</font>
	 </td><td align="right"><b>Copy code from </b>: </td><td>
<?php echo upg_grid_layout_list($form_layout,"listpress_settings[global_layout]","form",false); ?></td></tr></table>
</form>
<script>
var sz = document.forms['listpressYoutube'].elements['listpress_settings[global_layout]'];
// loop through list
for (var i=0, len=sz.length; i<len; i++) {
    sz[i].onclick = function() { // assign onclick handler function to each
        // put clicked radio button's value in total field
        //this.form.elements.total.value = this.value;
		var link='<?php echo $current_page; ?>='+this.value+'&type=form#tab-5';
		window.location.href = link;
		//alert(link);
    };
}
</script>


	
		<form class="pure-form" method="post" action="">
	<table border='1' width='99%'>
	<tr><td width="70%" valign="top">
	<h3>Post Form</h3>
	This form is displayed when user submit/post for the first time.<br>
	<?php
	wp_editor( $content_post_youtube, 'personal_post_youtube', $settings );
	?>
	<h3>Edit Form</h3> This is edit form displayed when user edit/update/modify post.<br>
	<?php
	wp_editor( $content_edit_youtube, 'personal_edit_youtube', $settings );
	?>
	</td>
	<td valign='top' style="background-color:#eeeeee ;">
	
	<b>HTML id & name parameters are important part in form creation. Some name are reserved by default.</b><hr>
	
	<b>Title Field </b>: id="name" name="user-submitted-title" <br><br>
	<b>Description Field</b>: name="user-submitted-content" <br><br>
	
	<b>Category/Album Field</b>: name='cat' value='2' <br>
	The value field will have a ID of album. To generate dynamic category selection use php function as upg_droplist_category('','');<br><br>
	
	<b>File field </b>:File upload is not available at this form.<br>
	<br>
	<b>For Embed URL Field</b>: id="url" name="user-submitted-url" type="url" <br><br>
	<b>Custom Fields</b>: name="upg_custom_field_1" <br>
	There are 5 custom fields (i.e. upg_custom_field_1, upg_custom_field_2, upg_custom_field_3, upg_custom_field_4, upg_custom_field_5)<br>
	You can assign any label name and type but form name should be equals to above. 
	<br><br>
	<b>Submit Button</b>: type="submit" name="SN"<br><br>
	
	<hr>
	<b>Tips</b>:
	<br>

	* You can use UPG built in grid system https://purecss.io/ <br>
	* For better css style http://fontawesome.io/ is included by default. <br>
	* Even after plugin update, your changes will not be lost.
	
	</td></tr></table>
	<br>
	<input type="submit" name="submit" id="submit" class="button button-primary" value="Update Personal Form Youtube File">
	</form>
	
	
	   </div>
	 
	 	</div>
	 </div>
<?php

}
function upg_save_layout_code($content,$layout_name,$type,$file)
 {
	 $upload_dir = wp_upload_dir();
	
	 $user_dirname = $upload_dir['basedir'].'/upg_'.$type.'_'.$file.'.php';
	 
    $filename=upg_BASE_DIR."layout/".$type."/".$layout_name."/".get_current_blog_id()."_".$file.".php";
	 
	if ( is_writeable($filename) ) 
		{
			//Save inside plugin path
			$file = fopen($filename,"w+");
			fwrite($file, wp_unslash($content));
			
			//save inside upload path
			$file = fopen($user_dirname,"w+");
			fwrite($file, wp_unslash($content));
			
			return "<div class='updated notice is-dismissible'><p>".$layout_name." layout updated : ".$user_dirname."</p></div>";
			
		}
		else
		{
			return "<div class='error notice is-dismissible'><p>File is not writable:".$filename."</p></div>";
		}
		
			
 }
 
 function upg_get_layout_code($layout_name,$type,$file)
 {
	 //Currently it forced only for personal layout
	 upg_auto_create_file($layout_name,$type,$file);
	 
	 if($layout_name=="personal")
		$filename=dirname(__FILE__)."/".$type."/".$layout_name."/".get_current_blog_id()."_".$file.".php";
	else
		$filename=dirname(__FILE__)."/".$type."/".$layout_name."/".$file.".php";
	 
	 if( file_exists( $filename ) )
	{
		$content =  file_get_contents($filename);
		return $content;
	}
	else
	{
		return "<div class='error notice is-dismissible'><p>".$filename." Not found</p></div>";
	}
 }
 
?>