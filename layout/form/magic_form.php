<?php
$options = get_option('upg_settings');
$attr    = shortcode_atts(array(
 'class'         => 'pure-form pure-form-stacked',
 'title'         => 'Submit',
 'preview'       => upg_get_option('global_media_layout', 'upg_preview', 'basic'),
 'name'          => '',
 'id'            => get_the_ID(),
 'post_type'     => 'upg',
 'taxonomy'      => 'upg_cate',
 'tag_taxonomy'  => 'upg_tag',
 'ajax'          => 'true',
 'media_private' => 'false',
), $params);

//var_dump($attr);
$abc = "";
ob_start();
if ('wp_post' == $attr['post_type']) {
 $attr['post_type'] = 'post';
}

if (post_type_exists($attr['post_type']) || "video_url" == $attr['post_type']) {
 if (isset($_POST['upg-nonce']) && wp_verify_nonce($_POST['upg-nonce'], 'upg-nonce')) {
  //Submit in USER POST GALLERY WP-UPG Plugin
  if ('upg' == $attr['post_type']) {
   //**************/
   $title    = '';
   $author   = '';
   $url      = '';
   $email    = '';
   $tags     = '';
   $captcha  = '';
   $verify   = '';
   $content  = '';
   $category = '';

   $files = array();
   if (isset($_FILES['user-submitted-image'])) {
    $files = $_FILES['user-submitted-image'];
   }

   $preview = $attr['preview'];

   $title = sanitize_text_field($_POST['user-submitted-title']);
   if (isset($_POST['user-submitted-content'])) {
    $content = upg_sanitize_content($_POST['user-submitted-content']);
   }

   if (isset($_POST['cat'])) {
    $category = intval($_POST['cat']);
   }

   if (isset($_POST['tags'])) {
    $tags = $_POST['tags'];
   }

   $content = str_replace("[", "[[", $content);
   $content = str_replace("]", "]]", $content);

   //$result = array();
   $result = upg_submit($title, $files, $content, $category, $preview, 'upg', 'upg_cate', $tags, 'upg_tag');

   $post_id = false;
   if (isset($result['id'])) {
    $post_id = $result['id'];
   }

   $error = false;
   if (isset($result['error'])) {
    $error = array_filter(array_unique($result['error']));
   }

   if ($post_id) {
    /*
    //Submit extra fields data
    for ($x = 1; $x <= 10; $x++) {
    if (isset($_POST['upg_custom_field_' . $x])) {
    add_post_meta($post_id, 'upg_custom_field_' . $x, $_POST['upg_custom_field_' . $x]);
    }

    }
     */
    //Ended to submit extra fields

    $post  = get_post($post_id);
    $image = upg_image_src('large', $post);

    do_action("upg_submit_complete");

    if (upg_get_option('publish', 'upg_form', 'on') == 'on') {

     echo "<h2>" . __('Successfully posted.', 'wp-upg') . "</h2>";
     //echo "<br><br><a href='".esc_url( get_permalink($post_id) )."' class=\"pure-button\">".__('Click here to view','wp-upg')."</a><br><br>";
     if (upg_get_option('my_gallery', 'upg_gallery', '0') != '0') {
      echo "<br><a href='" . esc_url(get_page_link(upg_get_option('my_gallery', 'upg_gallery', '0'))) . "' class=\"pure-button\">" . __('My Gallery', 'wp-upg') . "</a><br><br>";
     }
    } else {
     echo "<h2>" . __('Your submission is under review.', 'wp-upg') . "</h2>";
    }

    //echo "<h1 class=\"archive-title\">".$post->post_title."</h1>";
    //echo "<img src='$image'>";
   } else {
    //upg_log($error);
    if ($error) {
     $e = implode(',', $error);
     $e = trim($e, ',');
    } else {
     $e = 'error';
    }

    if ('file-type' == $e) {
     echo "<h1>" . __('Invalid file', 'wp-upg') . "</h1>";
    } else {
     echo "<h1>" . __('Error occurred', 'wp-upg') . ": " . $e . "</h1>";
    }
   }

   //**************/
  } else {
   echo "Something is wrong with your submission. Please check if your browser support java-scripts";
   if ('false' == $attr['ajax']) {
    echo "<br><b>ajax parameter cannot be false if post_type is not upg.</b>";
   }
  }
 } else {

  ?>

        <div id="upg_ajax">

            <!-- Image loader -->
            <div id='upg_loader' style='display: none;'>

                <br>
                <?php echo __("Uploading", "wp-upg"); ?>
                <div class="upg_progress-bar">
                    <span id="upg_progress" class="upg_progress-bar-load" style="width: 0%;text-align: center;"></span>
                </div>
                <br>
                <?php echo __("Processing", "wp-upg"); ?>
                <div class="upg_progress-bar">
                    <span id="upg_progress_process" class="upg_progress-bar-process" style="width: 0%;text-align: center;"></span>
                </div>


            </div>


            <div class='upg_response'></div>
            <div id="upg_after_response" style='display: none;'>
                <a href='<?php echo admin_url('admin-ajax.php?action=upg_send_again&post_id=' . get_the_ID()); ?>' class='upg_send_again'>
                    <?php echo __('Post again', 'wp-upg'); ?>
                </a> |
                <?php
if (upg_get_option('my_gallery', 'upg_gallery', '0') != '0') {
   echo "<a href='" . esc_url(get_page_link(upg_get_option('my_gallery', 'upg_gallery', '0'))) . "' >" . __('My Gallery', 'wp-upg') . "</a>";
  }

  ?>
            </div>

        </div>

<?php

  if ('false' == $attr['ajax']) {
   echo '<form class="' . $attr['class'] . '" method="post" enctype="multipart/form-data" action="">';
  } else {
   echo '<div id="upg_form">
        <form
        id="upg-request-form"
        class="upg_ajax_post ' . $attr['class'] . '"
        method="post"
        enctype="multipart/form-data"
        action="' . admin_url("admin-ajax.php") . '"
        >';
  }

  echo do_shortcode($content);

  wp_nonce_field('upg-nonce', 'upg-nonce', false);
  echo '<input type="hidden" name="action" value="upg_ajax_post">';
  echo '<input type="hidden" name="upload_type" value="' . $attr['post_type'] . '">';
  echo '<input type="hidden" name="upload_taxonomy" value="' . $attr['taxonomy'] . '">';
  echo '<input type="hidden" name="tag_taxonomy" value="' . $attr['tag_taxonomy'] . '">';
  echo '<input type="hidden" name="preview" value="' . $attr['preview'] . '">';
  echo '<input type="hidden" name="form_name" value="' . $attr['name'] . '">';
  echo '<input type="hidden" name="media_private" value="' . $attr['media_private'] . '">';
  echo '<input type="hidden" name="form_attach" value="' . $attr['id'] . '">';

  echo '</form></div>';
 }
} else {
 echo $attr['post_type'] . " post_type specified does not exists.";
}
//to update price of woocommerce
/* function wpufe_update_post_price( $post_id )
{

$regular_price = get_post_meta( $post_id, ‘_regular_price’, true );
$sale_price = get_post_meta( $post_id, ‘_sale_price’, true );

update_post_meta( $post_id, ‘_price’, $regular_price );

if ( !empty( $sale_price ) ) {

update_post_meta( $post_id, ‘_price’, $sale_price );

}

} */
$abc = ob_get_clean();
return $abc;
?>