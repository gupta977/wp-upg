<?php
$options = get_option('upg_settings');
$attr = shortcode_atts( array(
    'class' => 'pure-form',
    'title' => 'Submit',
    'preview' => $options['global_media_layout'],
    'name' => '',
    'id' =>get_the_ID()
), $params );


$abc="";
ob_start ();
if (isset($_POST['upg-nonce']) && wp_verify_nonce($_POST['upg-nonce'], 'upg-nonce')) 
{

	echo "form not submitted";
	
}
else
{
    
    echo '<form class="'.$attr['class'].'" method="post" enctype="multipart/form-data" action="">';
    
    echo do_shortcode($content);

    wp_nonce_field('upg-nonce', 'upg-nonce', false);
    echo '<input type="hidden" name="action" value="upg_ajax_post">';
    echo '<input type="hidden" name="upload_type" value="upg_post">';
    echo '<input type="hidden" name="preview" value="'.$attr['preview'].'">';
    echo '<input type="hidden" name="form_name" value="'.$attr['name'].'">';
    echo '<input type="hidden" name="form_attach" value="'.$attr['id'].'">';

    echo '</form>';
    
}

$abc=ob_get_clean (); 
return $abc;
?>