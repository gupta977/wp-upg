<?php
global $post;
global $wp_query;

$options = get_option('upg_settings');

if (isset($params['login'])) {
 $login_check = $params['login'];
} else {
 $login_check = "false";
}

if (!is_user_logged_in() && 'true' == $login_check) {
 upg_login_link();
 return "";
} else {

 //Get tags
 $tag_slug = get_query_var('upg_tag');
 $tag      = get_term_by('slug', $tag_slug, 'upg_tag');
 $tag_name = "";
 if ("" != $tag_slug) {
  $tag_name = $tag->name;
 }

 if ("" != $tag_slug) {
  $keyword = $tag_slug;
  //echo "keyword tag in url ".$keyword ;
 } else if (isset($params['tag'])) {
  //echo "parameter set";
  $keyword = trim($params['tag']);
 } else {
  $keyword = '';
  //echo "default from global";
 }

 //Get redirected sub album
 $term_slug  = get_query_var('upg_cate');
 $term       = get_term_by('slug', $term_slug, 'upg_cate');
 $album_name = "";

 if ("" != $term_slug) {
  $album_name = $term->name;
 }

 if (isset($wp_query->query_vars['user'])) {
  $user = sanitize_text_field($wp_query->query_vars['user']);
 } else if (isset($params['user'])) {
  $user = $params['user'];
 } else {
  $user = "";
 }

 $current_user = wp_get_current_user();
 if ("show_mine" == $user) {
  $user        = $current_user->user_login;
  $post_status = array('draft', 'publish');
 } else {
  $post_status = array('publish');
 }
 $author = get_user_by('slug', $user);

 //$output='<div class="odude-shop">
 // <div id="catalog" class="row-fluid">';

 $postsperpage = $options['global_perpage'];
 $perrow       = $options['global_perrow'];

 $orderby = $options['global_order'];
 $page    = $options['global_page'];
 //$popup=$options['global_popup'];
 $popup    = upg_get_option('global_popup', 'upg_preview', 'on');
 $show_tag = upg_get_option('gallery_tags', 'upg_gallery', 'off');
 $album    = "";
 $post_id  = get_the_ID();

 if (isset($params['perpage']) && $params['perpage'] > 0) {
  $postsperpage = $params['perpage'];
 }

 if (isset($params['perrow']) && $params['perrow'] > 0) {
  $perrow = $params['perrow'];
 }

 if (isset($params['list_name'])) {
  $list_name = $params['list_name'];
 } else {
  $list_name = "";
 }

 //Disable/Hide submit button from current page. It applies to all shortcode on same page.
 if (isset($params['button'])) {

  if ("on" == $params['button'] && "" != $user) {
   add_action('upg_grip_top', 'upg_show_button', 10, 0);
  } else {
   add_action('upg_grip_top', 'upg_hide_button', 9, 0);
  }
 } else {

  if (isset($options['primary_show_image_button']) || isset($options['primary_show_youtube_button'])) {

   if (isset($options['button_check_login']) && "1" == $options['button_check_login']) {

    if (is_user_logged_in()) {

     $current_user = wp_get_current_user();
     $loggedin_as  = $current_user->user_login;
     if ($loggedin_as == $user) {
      add_action('upg_grip_top', 'upg_show_button', 10, 0);
     }
    }
   } else {
    add_action('upg_grip_top', 'upg_show_button', 10, 0);
   }
  }
 }

 //Show hide upg_author profile logo
 $author_show = true;
 if (isset($params['author'])) {
  if ("off" == $params['author']) {
   $author_show = false;
  }
 }

 if ("" != $term_slug) {
  $album = $term_slug;
  //echo "album in url ".$album;
 } else if (isset($params['album'])) {
  //echo "parameter set";
  $album = trim($params['album']);
 } else {
  $album = $options['global_album'];
  //echo "default from global";
 }

 if (isset($params['orderby'])) {
  $orderby = $params['orderby'];
 }

 if (isset($params['page'])) {
  $page = $params['page'];
 }

 if (isset($params['popup'])) {
  $popup = $params['popup'];
 }

 if (isset($params['tag_show'])) {
  $show_tag = $params['tag_show'];
 }

 //If upg_layout is mentioned in url, it will ignore currently set layout.
 if (isset($_GET['upg_layout'])) {
  $upg_layout_slug = $_GET['upg_layout'];
  $layout          = sanitize_text_field($upg_layout_slug);
 } else {

  if (isset($params['layout'])) {
   $layout = trim($params['layout']);
  } else {
   $layout = upg_get_option('global_layout', 'upg_gallery', 'photo');
  }

 }

 //It will add search term if found in url
 if (isset($_GET['search'])) {
  $search = $_GET['search'];
 } else {
  $search = "";
 }

 $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

 //echo $album."----";
 if ("" != $album && "" != $keyword) {
  $relation = "AND";
 } else {
  $relation = "OR";
 }

 if ("" != $album || "" != $keyword) {
  $args = array(
   'post_type'      => 'upg',
   'paged'          => $paged,
   's'              => $search,
   'posts_per_page' => $postsperpage,
   'orderby'        => $orderby,
   'order'          => 'DESC',
   'author_name'    => $user,
   'tax_query'      => array(
    'relation' => $relation,
    array(
     'taxonomy' => 'upg_cate',
     'field'    => 'slug',
     'terms'    => explode(',', $album),
     //'terms'    => array( 'mobile', 'sports' ),
     //'include_children' => 0 //It will not include post of sub categories
    ),

    array(
     'taxonomy' => 'upg_tag',
     'field'    => 'slug',
     'terms'    => explode(',', $keyword),
     //'terms'    => array( 'mobile', 'sports' ),
    ),

   ),
  );
 } else {
  $args = array(
   'post_type'      => 'upg',
   's'              => $search,
   'paged'          => $paged,
   'posts_per_page' => $postsperpage,
   'author_name'    => $user,
   'post_status'    => $post_status,
   'orderby'        => $orderby,
   'order'          => 'DESC',

  );
 }
/*
if (!in_array("draft", $post_status)) {
$args['meta_query'] = array(
'relation' => 'OR',
array(
'key'     => 'media_private',
'value'   => 'true',
'compare' => '!=',
),
array(
'key'     => 'media_private',
'compare' => 'NOT EXISTS',
),
);
}
 */
 //var_dump($args);

 //filter parameter
 if (isset($params['filter'])) {
  if ('image' == $params['filter']) {
   $filter = 'pic_name';
  } else if ('youtube' == $params['filter'] || 'video' == $params['filter'] || 'embed' == $params['filter']) {
   $filter = 'youtube_url';
  } else {
   $filter = trim($params['filter']);
  }

 } else {
  $filter = '';
 }

 if ('' != $filter) {
  $args['meta_query'] = array(
   array(
    'key' => $filter,
   ),
  );
 }

 //Empty array if not logged in
 if (!is_user_logged_in() & isset($params['user']) && "show_mine" == $params['user']) {
  upg_login_link();

  $args = array();
 }

 //print_r($args);
 //var_dump($args);

 //Do not run if array is blank
 if (!empty($args)) {
  //wp_reset_query();
  $query = new WP_Query($args);

  //Get the tags only
  $tags_array = array();
  while ($query->have_posts()): $query->the_post();
   foreach (wp_get_post_terms($post->ID, 'upg_tag') as $t) {
    $tags_array[$t->slug] = $t->name;
   }
   // this adds to the array in the form ['slug']=>'name'
  endwhile;
  // de-dupe
  $tags_array = array_unique($tags_array);
  natcasesort($tags_array);
  //print_r($tags_array);

  $put = "";
  ob_start();
  if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_config.php")) {
   include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_config.php";
  }

  if ("personal" == $layout) {
   if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_up.php")) {
    include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_up.php";
   } else {
    echo "Updating personal grid file. Refresh page.<br>";
    //create this file
    upg_auto_create_file('personal', 'grid', 'personal_up');
    //create pick file too
    upg_auto_create_file('personal', 'grid', 'personal_pick');
   }
  } else {
   if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_up.php")) {
    include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_up.php";
   } else {
    echo __('Layout Not Found. Check settings.', 'wp-upg') . ": " . $layout;
   }

  }
  $count = 0;
  while ($query->have_posts()): $query->the_post();
   $count++;
   $permalink    = get_permalink();
   $thetitle     = get_the_title();
   $theauthor    = get_the_author();
   $image        = upg_image_src('odude-thumb', $post);
   $image_large  = upg_image_src('odude-large', $post);
   $image_medium = upg_image_src('odude-medium', $post);
   $tags         = upg_get_taxonony_raw($post->ID, 'upg_tag');

   //Set featured image if not available
   if (strpos($image_large, 'noimg.png') == false) {
    upg_set_featured_image($post, $image_large, $post->post_title);
   }
   $post_status = get_post_status();

   $text         = wpautop(stripslashes($post->post_content));
   $text_excerpt = wpautop(stripslashes($post->post_excerpt));

   if (upg_isVideo($post)) {
    $nonce        = wp_create_nonce("upg_oembed");
    $oembed_url   = upg_video_preview_url(upg_isVideo($post), $post);
    $extra_param  = "";
    $preview_type = '';

    if (strpos($oembed_url, 'vimeo') > 0) {
     $preview_large = $oembed_url;
    } else if (strpos($oembed_url, 'yout') > 0) {

    $preview_large = $oembed_url;
   } else if (strpos($oembed_url, 'facebook') > 0) {

    $preview_large = admin_url('admin-ajax.php?action=upg_oembed&oembed_url=' . $oembed_url . '&nonce=' . $nonce);

    $extra_param = 'data-type="iframe"';
   } else {
    $preview_large = admin_url('admin-ajax.php?action=upg_oembed&oembed_url=' . $oembed_url . '&nonce=' . $nonce);
    $extra_param   = 'data-type="ajax"';
   }
  } else {
   $preview_large = $image_large;
   $preview_type  = 'images';
   $extra_param   = "";
  }

  if ("personal" == $layout) {
   if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_main.php")) {

    include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_main.php";
   }
  } else {
   if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_main.php")) {
    include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_main.php";
   }

  }

  endwhile;

  if ("personal" == $layout) {
   if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_down.php")) {
    include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_down.php";
   } else {
    upg_auto_create_file('personal', 'grid', 'personal_down');
    upg_auto_create_file('personal', 'grid', 'personal_main');
   }
  } else {

   if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_down.php")) {
    include upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_down.php";
   }

  }

  //echo '</div> </div>';

  echo "<br>";

  if (function_exists('wp_pagenavi')) {
   if ("on" == $page) {
    echo "" . wp_pagenavi(array('query' => $query));
   }

  }

  $put = ob_get_clean();
  wp_reset_query();
  return $put;
 } else {
  return "";
 }
}
