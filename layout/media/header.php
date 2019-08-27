<?php
function upg_position1()
{
    $shortcode_1=upg_get_option('global_media_shortcode_1', 'upg_preview', '');
    
    if ($shortcode_1!='') 
    {
        return do_shortcode(stripslashes($shortcode_1));
    } 
    else 
    {
        $options = get_option('upg_settings', '');
        if (isset($options['upg_textarea_shortcode_1'])) 
        {
            upg_set_option( 'global_media_shortcode_1','upg_preview', $options['upg_textarea_shortcode_1'] );
            return do_shortcode(stripslashes($options['upg_textarea_shortcode_1']));
        }
         else 
         {
            return "" ;
        }
    }
}
function upg_position2()
{
    $shortcode_2=upg_get_option('global_media_shortcode_2', 'upg_preview', '');
    
    if ($shortcode_2!='') 
    {
        return do_shortcode(stripslashes($shortcode_2));
    } 
    else 
    {
        $options = get_option('upg_settings', '');
        if (isset($options['upg_textarea_shortcode_2']))
        {
            upg_set_option( 'global_media_shortcode_2','upg_preview', $options['upg_textarea_shortcode_2'] );
            return do_shortcode(stripslashes($options['upg_textarea_shortcode_2']));
        } 
        else 
        {
            return "" ;
        }
    }
}
 
 $options = get_option('upg_settings');
 $post_title=$post->post_title;
    ?>
	