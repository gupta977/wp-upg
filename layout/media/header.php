<?php
function upg_position1()
 {
	  $options = get_option( 'upg_settings','' );
	  if(isset($options['upg_textarea_shortcode_1']))
		  return do_shortcode( stripslashes($options['upg_textarea_shortcode_1']));
	  else
		  return "" ;
 }	
function upg_position2()
 {
	  $options = get_option( 'upg_settings','' );
	  if(isset($options['upg_textarea_shortcode_2']))
		  return do_shortcode( stripslashes($options['upg_textarea_shortcode_2']));
	  else
		  return "" ;
 }	
 
 $options = get_option('upg_settings');
 $post_title=$post->post_title;
	?>
	