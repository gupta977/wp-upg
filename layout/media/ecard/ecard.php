<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
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
	$post_status=get_post_status();
	$author = get_user_by('id', get_the_author_meta( 'ID' ));
	//echo $author->first_name;
	//echo $author->user_nicename;
	
	$ecardactive=false;
	
	if ( is_plugin_active( 'odude-ecard/odude-ecard.php' ) ) 
	{
		 $ecardactive=true;
	} 
	
	if($ecardactive)
	{
		$ecard_layout=upg_get_value('ecard_layout');
		
		$options = get_option( 'odudecard_settings','' );	
		if(isset($options['odudecard_select_pickup_field']))
		{
			if($ecard_layout)
			include(WP_PLUGIN_DIR."/odude-ecard/layout/media/".$ecard_layout."/".$ecard_layout.".php");
			else
			include(WP_PLUGIN_DIR."/odude-ecard/layout/media/basic/basic.php");
		}
		else
		{
			echo "<h2>Ecard Pickup Page is not yet selected or created.<br> First save settings at ODude Ecard.</h2>";
		}
		
		
	}
	else
	{
	?>
	This features only available if you install <a href="https://wordpress.org/plugins/odude-ecard/">ODude Ecard</a> Free Plugin.
	<br>Don't forget to activate and set required settings at ODude Ecard.
	
	<?php
	}


	$abc=ob_get_clean (); 
	return $abc;
}