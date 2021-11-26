<?php
/*
Plugin Name: User Post Gallery
Plugin URI: http://odude.com/
Description: UPG - User Post Gallery. User can post content/images from frontend.
Version: 2.19
Author: ODude Network
Author URI: http://odude.com/
License: GPLv2 or later
Text Domain: wp-upg
Domain Path: /languages
 */

define('UPG_PLUGIN_VERSION', '2.19');
define('upg_ROOT_URL', plugin_dir_url(__FILE__));
define('upg_FOLDER', dirname(plugin_basename(__FILE__)));
define('upg_BASE_DIR', WP_CONTENT_DIR . '/plugins/' . upg_FOLDER . '/');
define('upg_PLUGIN_URL', content_url('/plugins/' . upg_FOLDER));

function upg_languages()
{
  load_plugin_textdomain('wp-upg', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

include dirname(__FILE__) . '/classes/class.settings-api.php';
include dirname(__FILE__) . "/classes/class.FormEntries.php";
include dirname(__FILE__) . '/classes/class.html_form.php';
include dirname(__FILE__) . "/classes/quick_mode_setting.php";
include dirname(__FILE__) . "/classes/class.AlbumThumbnail.php";
include dirname(__FILE__) . "/libs/functions.php";
include dirname(__FILE__) . "/libs/functions-boolean.php";
include dirname(__FILE__) . "/libs/load_more.php";
include dirname(__FILE__) . "/libs/install.php";
include dirname(__FILE__) . "/libs/hooks.php";
include dirname(__FILE__) . "/libs/custom_column.php";
include dirname(__FILE__) . "/setting.php";
include dirname(__FILE__) . "/addon.php";
include dirname(__FILE__) . "/shortcode.php";
include dirname(__FILE__) . "/libs/metabox.php";
include dirname(__FILE__) . "/libs/breadcrumb.php";
include dirname(__FILE__) . "/layout/edit.php";
include dirname(__FILE__) . "/layout/button.php";
include dirname(__FILE__) . "/libs/taxonomy.php";
include dirname(__FILE__) . "/widgets/categories.php";
include dirname(__FILE__) . "/widgets/form.php";
include dirname(__FILE__) . "/addon/ultimatemember.php";
include dirname(__FILE__) . "/addon/buddypress.php";

register_activation_hook(__FILE__, 'upg_install');
register_uninstall_hook(__FILE__, 'upg_drop');

function upg_plugin_check_version()
{
  $options = get_option('upg_settings', '');

  if (UPG_PLUGIN_VERSION !== get_option('upg_plugin_version')) {
    //upg_log('I will be executed as soon as version do not match');

    if (get_option('upg_plugin_version') < 1.92) {

      if (isset($options['global_form_layout'])) {
        upg_set_option('global_form_layout', 'upg_form', $options['global_form_layout']);
        upg_set_option('global_layout', 'upg_gallery', $options['global_layout']);
        upg_set_option('global_media_layout', 'upg_preview', $options['global_media_layout']);
        //upg_log('Value Updated to : '.$options['global_media_layout']);
      }
    }

    //Update Permalink
    flush_rewrite_rules();
    // Copy layouts from media folder to plugin folder
    require_once ABSPATH . 'wp-admin/includes/file.php';
    WP_Filesystem();
    $upload_dir = wp_upload_dir();
    $path       = $upload_dir['basedir'] . '/upg/';
    $copy_file  = copy_dir($path, upg_BASE_DIR . "layout/", $skip_list = array());

    update_option('upg_plugin_version', UPG_PLUGIN_VERSION);
  }
}

//Loading css files
function upg_enqueue_scripts()
{
  global $upg_plugin, $current_screen;
  $options = get_option('upg_settings', '');

  wp_enqueue_style('upg-style', plugins_url() . '/' . upg_FOLDER . '/css/style.css', '', UPG_PLUGIN_VERSION, 'all');

  if (!isset($options['fancybox']) || '0' == $options['fancybox']) {
    wp_enqueue_style('upg_fancybox_css', plugins_url() . '/' . upg_FOLDER . '/css/jquery.fancybox.min.css', '', UPG_PLUGIN_VERSION, 'all');
    wp_enqueue_script('upg_fancybox_js', plugins_url() . '/' . upg_FOLDER . '/js/jquery.fancybox.min.js', array('jquery'), null, false);
  }

  if (!isset($options['purecss']) || '0' == $options['purecss']) {
    wp_enqueue_style('odude-pure', plugins_url() . '/' . upg_FOLDER . '/css/pure-min.css');
    wp_enqueue_style('odude-pure-grid', plugins_url() . '/' . upg_FOLDER . '/css/grids-responsive-min.css');
  }

  if (!isset($options['fontawesome']) || '0' == $options['fontawesome']) {
    wp_enqueue_style('upg-fontawesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');
  }
  wp_enqueue_script('upg_input_tags', plugins_url() . '/' . upg_FOLDER . '/js/jquery.tagsinput.js', '', UPG_PLUGIN_VERSION, '');
  wp_enqueue_script('upg_tags', plugins_url() . '/' . upg_FOLDER . '/js/filter-tags.js', '', UPG_PLUGIN_VERSION, '');
  wp_enqueue_script('upg_common', plugins_url() . '/' . upg_FOLDER . '/js/common.js', '', UPG_PLUGIN_VERSION, '');
  wp_enqueue_script('jquery.zoom', plugins_url() . '/' . upg_FOLDER . '/js/jquery.zoom.js');
  wp_enqueue_script('upg_delete', plugins_url() . '/' . upg_FOLDER . '/js/upg_delete.js', '', UPG_PLUGIN_VERSION, '');
  wp_enqueue_script('upg_oembed', plugins_url() . '/' . upg_FOLDER . '/js/upg_oembed.js', '', UPG_PLUGIN_VERSION, '');
  wp_enqueue_script('upg_load_more', plugins_url() . '/' . upg_FOLDER . '/js/upg_load_more.js', '', UPG_PLUGIN_VERSION, '');
  wp_enqueue_script('upg_ajax_post', plugins_url() . '/' . upg_FOLDER . '/js/upg_ajax_post.js', '', UPG_PLUGIN_VERSION, '');

  // Localize the script with new data
  $translation_array = array(
    'delete_string' => __('Are you sure you want to delete?', 'wp-upg'),
    'ajaxurl'       => admin_url('admin-ajax.php'),
  );

  wp_localize_script('upg_load_more', 'myAjax', $translation_array);
  wp_localize_script('upg_common', 'myAjax_datatable', array('ajaxurl' => admin_url('admin-ajax.php?action=upg_datatable')));
}
function upg_admin_enqueue_scripts()
{
  global $upg_plugin, $current_screen;
  $options = get_option('upg_settings', '');
  $screen  = get_current_screen();
  //echo $screen->base;
  if ('upg_page_wp_upg' == $screen->base) {

    wp_enqueue_style('odude-pure', plugins_url() . '/' . upg_FOLDER . '/css/pure-min.css');
    //wp_enqueue_style('font-awesome-css','https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
    wp_enqueue_style('odude-pure-grid', plugins_url() . '/' . upg_FOLDER . '/css/grids-responsive-min.css');
  }
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-form');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_script('jquery-ui-tabs'); // enqueue jQuery UI Tabs
  //wp_enqueue_script('jquery-ui-accordion');
  wp_enqueue_style('wp-color-picker');
  wp_enqueue_script('wp-color-picker');

  $options = get_option('upg_settings', '');
  wp_enqueue_style('upg-style', plugins_url() . '/' . upg_FOLDER . '/css/aristo.css');
  wp_enqueue_style('upg-admin', plugins_url() . '/' . upg_FOLDER . '/css/admin.css');
}

//Move image meta box-media
function upg_admin_footer_hook()
{
  global $post;
  if (get_post_type($post) == 'upg') { ?> <script type="text/javascript">
      jQuery(document).ready(function($) {
        $('#normal-sortables').insertBefore('#postdivrich');
      });
    </script> <?php }
          }
          /** Hook into the Admin Footer */ add_action('admin_footer', 'upg_admin_footer_hook');

          //Generate auto media preview page
          function upg_the_content($content)
          {

            global $post;
            $options = get_option('upg_settings');

            if ('upg' != $post->post_type) {
              return $content;
            }

            if (is_singular() && is_main_query()) {
              //Receiving all the custom post values
              $all_upg_fields = get_post_custom($post->ID);

              //If upg_layout is mentioned in url, it will ignore currently set layout.
              if (isset($_GET['upg_layout'])) {
                $upg_layout_slug = $_GET['upg_layout'];
                $upg_layout      = sanitize_text_field($upg_layout_slug);
              } else {

                if (isset($all_upg_fields["upg_layout"][0])) {
                  $upg_layout = $all_upg_fields["upg_layout"][0];
                } else {
                  $upg_layout = "basic";
                }
              }

              $filename = dirname(__FILE__) . "/layout/media/" . $upg_layout . "/" . $upg_layout . ".php";

              if (file_exists($filename)) {
                require_once $filename;
                return upg_product_content($post);
              } else {
                require_once dirname(__FILE__) . "/layout/media/basic/basic.php";
                return upg_product_content($post);
              }
            }
          }
          //Include youtube from url
          function upg_showyoutube($params)
          {

            $abc = include upg_BASE_DIR . 'layout/youtube.php';
            return $abc;
          }

          //Pick single upg-post
          function upg_pick($params)
          {

            $abc = include upg_BASE_DIR . 'layout/pick.php';
            return $abc;
          }

          //List Primary Images [upg-list]
          function upg_list($params)
          {
            $options = get_option('upg_settings');

            $abc = include upg_BASE_DIR . 'layout/catalog.php';
            return $abc;
          }

          //Attach gallery to post. [upg-attach]
          function upg_attach($params)
          {
            $options         = get_option('upg_settings');
            $current_post_id = get_the_ID();
            $abc             = include upg_BASE_DIR . 'layout/attach.php';

            return $abc;
          }

          //Attach gallery to post. [upg-datatable]
          function upg_datatable_shortcode($params)
          {
            $options         = get_option('upg_settings');
            $current_post_id = get_the_ID();
            $abc             = include upg_BASE_DIR . 'layout/datatable.php';

            return $abc;
          }

          //List album [upg-album]
          function upg_album($params)
          {
            $options = get_option('upg_settings');
            $abc     = include upg_BASE_DIR . 'layout/album.php';

            return $abc;
          }

          //Generate UPG Magic Form. [upg-form]
          function upg_magic_form($params, $content = null)
          {
            $options = get_option('upg_settings');
            $abc     = include upg_BASE_DIR . 'layout/form/magic_form.php';
            return $abc;
          }
          function upg_magic_form_tag($params)
          {
            $options = get_option('upg_settings');
            $abc     = include upg_BASE_DIR . 'layout/form/magic_form_tag.php';
            return $abc;
          }

          //Generate UPG classic form [upg-post-form]
          function upg_post_form($params, $content = null)
          {
            $options = get_option('upg_settings');
            $abc     = include upg_BASE_DIR . 'layout/form/magic_form.php';
            return $abc;
          }

          //Front end User Edit Post [upg-edit]
          function upg_user_edit_form($params)
          {
            if (is_user_logged_in()) {
              if (isset($_REQUEST["upg_id"])) {
                $post_id = $_REQUEST["upg_id"];
              } else {
                $post_id = "0";
              }

              if ('0' == $post_id) {
                return __('Invalid request', 'wp-upg');
              }

              //$post=get_post($post_id );
              $options = get_option('upg_settings');
              if (get_post_field('post_author', $post_id) == get_current_user_id() && isset($_REQUEST["upg_id"])) {

                $post = get_post($post_id);

                if (upg_isVideo($post)) {
                  $type = "embed";
                } else {
                  $type = "image";
                }

                if (isset($params['layout'])) {
                  $layout = trim($params['layout']);
                } else {
                  $layout = "basic";
                }

                if (isset($params['preview'])) {
                  $preview = $params['preview'];
                } else {
                  $preview = "basic";
                }

                if ("youtube" == $type || "vimeo" == $type || "embed" == $type) {
                  $abc = include upg_BASE_DIR . 'layout/form/post_edit_youtube.php';
                } else {
                  $abc = include upg_BASE_DIR . 'layout/form/post_edit_image.php';
                }

                return $abc;
              }
            } else {

              upg_login_link();
            }
          }

          //Front end User Post [upg-post]
          function upg_user_post_form($params)
          {
            $options = get_option('upg_settings');

            if (isset($params['type'])) {
              $type = $params['type'];
            } else {
              $type = "image";
            }

            if (isset($params['preview'])) {
              $preview = $params['preview'];
            } else {
              $preview = upg_get_option('global_media_layout', 'upg_preview', 'basic');
            }

            if (isset($options['ajax_form']) && '1' == $options['ajax_form']) {
              $upg_ajax = true;
            } else {
              $upg_ajax = false;
            }

            if (isset($params['ajax']) && 'true' == $params['ajax']) {
              $upg_ajax = true;
            }

            if (isset($params['ajax']) && 'false' == $params['ajax']) {
              $upg_ajax = false;
            }

            if (isset($params['form_name'])) {
              $form_name = $params['form_name'];
            } else {
              $form_name = "";
            }

            if (isset($params['private']) && 'true' == $params['private']) {
              $media_private = "true";
            } else {
              $media_private = "false";
            }

            if (isset($params['attach']) && 'true' == $params['attach'] && $upg_ajax) {
              $form_attach_id = get_the_ID();
            } else {
              $form_attach_id = "0";
            }

            if ("youtube" == $type || "vimeo" == $type || "embed" == $type) {
              $abc = include upg_BASE_DIR . 'layout/form/post_youtube.php';
            } else {
              $abc = include upg_BASE_DIR . 'layout/form/post_image.php';
            }

            return $abc;
          }

          //Delete image attached when post is deleted
          add_action('before_delete_post', 'upg_before_delete_post');
          function upg_before_delete_post($postid)
          {

            // We check if the global post type isn't ours and just return
            global $post_type;
            if ('upg' != $post_type) {
              return;
            }

            upg_delete_post_media($postid);
          }

          //taxonomy/album will be redirected when category is opened
          add_action('template_redirect', 'upg_template_redirect');
          function upg_template_redirect()
          {
            $redirect_url = '';
            if (!is_feed()) {
              // If Album Page
              if (is_tax('upg_cate')) {

                $term         = get_queried_object();
                $redirect_url = upg_get_category_page_link($term, 'upg_cate');
              }
              if (is_tax('upg_tag')) {
                //Converts system tag url to own url
                $term          = get_queried_object();
                $page_settings = get_option('upg_settings');
                $link          = get_permalink(upg_get_option('main_page', 'upg_gallery', '0'));
                $link          = add_query_arg("upg_tag", $term->slug, $link);

                $redirect_url = $link;
              }
            }
            // Redirect
            if (!empty($redirect_url)) {

              wp_redirect($redirect_url);
              exit();
            }
          }

          //Rewrite rules for user gallery
          add_action('init', 'upg_user_url');
          function upg_user_url()
          {
            $options = get_option('upg_settings');

            if (upg_get_option('main_page', 'upg_gallery', '0') != '0') {
              //$main_page=get_permalink($options['main_page']);
              $main_page = basename(get_permalink(upg_get_option('main_page', 'upg_gallery', '0')));

              //Rewrite rules to browse by user
              add_rewrite_rule(
                '^' . $main_page . '/member/([^/]*)$',
                'index.php?user=$matches[1]&page_id=' . upg_get_option('main_page', 'upg_gallery', '0'),
                'top'
              );

              add_rewrite_rule(
                '^' . $main_page . '/member/([^/]+)/page/([0-9]+)?$',
                'index.php?user=$matches[1]&paged=$matches[2]&page_id=' . upg_get_option('main_page', 'upg_gallery', '0'),
                'top'
              );

              //Rewrite rules to browse by tag

              add_rewrite_rule(
                '^' . $main_page . '/tag/([^/]*)$',
                'index.php?page_id=' . upg_get_option('main_page', 'upg_gallery', '0') . '&upg_tag=$matches[1]',
                'top'
              );

              add_rewrite_rule(
                '^' . $main_page . '/tag/([^/]+)/page/([0-9]+)?$',
                'index.php?upg_tag=$matches[1]&paged=$matches[2]&page_id=' . upg_get_option('main_page', 'upg_gallery', '0'),
                'top'
              );

              //rewrite rules pagination to browse by album
              add_rewrite_rule(
                '^' . $main_page . '/([^/]+)/page/([0-9]+)?$',
                'index.php?upg_cate=$matches[1]&paged=$matches[2]&page_id=' . upg_get_option('main_page', 'upg_gallery', '0'),
                'top'
              );

              add_rewrite_rule(
                '^' . $main_page . '/([^/]*)$',
                'index.php?upg_cate=$matches[1]&page_id=' . upg_get_option('main_page', 'upg_gallery', '0'),
                'top'
              );
            }
          }
          function upg_query_vars($aVars)
          {
            $aVars[] = "user"; // represents the name of the variable as shown in the URL
            $aVars[] = "upg_cate";
            $aVars[] = "paged";
            return $aVars;
          }

          add_filter('query_vars', 'upg_query_vars');

          //Changing page title dynamically. loop_start prevent from updating menu title
          add_action('loop_start', 'upg_set_custom_title');
          function upg_set_custom_title()
          {

            add_filter('the_title', 'upg_filter_page_title', 10, 2);
          }

          function upg_filter_page_title($title)
          {

            $options         = get_option('upg_settings');
            $current_page_id = get_the_ID();
            $album_name      = "";
            $main_page_id    = upg_get_option('main_page', 'upg_gallery', '0');
            if ($main_page_id == $current_page_id && in_the_loop()) {

              global $post;
              global $wp_query;

              $term_slug = get_query_var('upg_cate');
              $term      = get_term_by('slug', $term_slug, 'upg_cate');

              if ("" != $term_slug) {
                $album_name = $term->name;
              }

              $term_slug = get_query_var('upg_tag');
              $term      = get_term_by('slug', $term_slug, 'upg_tag');

              if ("" != $term_slug) {
                $album_name = $term->name;
              }

              if (isset($wp_query->query_vars['user'])) {
                $user = sanitize_text_field($wp_query->query_vars['user']);
              } else {
                $user = "";
              }

              $author = get_user_by('slug', $user);

              if ("" != $album_name) {

                return $album_name;
              }

              if ("" != $user) {

                return $author->user_nicename;
              }
            }

            return $title;
          }
          //Include in archive page
          if ('1' == $options['archive']) {

            //Include UPG in archive page
            add_action('pre_get_posts', function ($query) {
              if (
                !is_admin()
                && $query->is_main_query()
                && $query->is_archive()
              ) {
                $query->set('post_type', array('post', 'upg'));
              }
            });
            //To display in Archive widget
            add_filter('getarchives_where', function ($where) {
              $where = str_replace("post_type = 'post'", "post_type IN ( 'post', 'upg' )", $where);
              return $where;
            });
          }

          /**
           * Add any custom links to plugin list page
           *
           * @param array $links
           *
           * @return array
           */
          function upg_plugin_links($links)
          {

            $more_links[] = '<a href="' . admin_url() . 'edit.php?post_type=upg&page=wp_upg_quick">' . __('Quick Settings', 'wp-upg') . '</a>';
            $more_links[] = '<a href="' . admin_url() . 'edit.php?post_type=upg&page=wp_upg">' . __('Advance Settings', 'wp-upg') . '</a>';

            $links = $more_links + $links;
            return $links;
          }

          /*
List extra links on plugin list page
 */
          function upg_plugin_links_extra($links, $file)
          {
            if (plugin_basename(__FILE__) !== $file) {
              return $links;
            }

            $more_links[] = __('Version', 'wp-upg') . ' ' . UPG_PLUGIN_VERSION . ' | <a href="http://odude.com/demo/faq/">' . __('Documentation', 'wp-upg') . '</a>';
            //    $more_links[] = '<a target="_blank" href="https://wordpress.org/support/plugin/wp-upg/reviews/?rate=5#new-post" title="' . __('Rate the plugin', 'wp-reset') . '">' . __('Rate the plugin', 'wp-upg') . ' ★★★★★</a>';
            $more_links[] = '<a href="' . admin_url() . 'edit.php?post_type=upg&page=upg_shortcode">' . __('Shortcode Guide', 'wp-upg') . '</a>';
            $links        = $more_links + $links;
            return $links;
          }
          add_filter('plugin_row_meta', 'upg_plugin_links_extra', 10, 2);

          $prefix = is_network_admin() ? 'network_admin_' : '';
          add_filter("{$prefix}plugin_action_links_" . plugin_basename(__FILE__), 'upg_plugin_links');

          //Set custom sizes for media settings.
          add_action('after_setup_theme', 'upg_your_theme_setup');
          function upg_your_theme_setup()
          {
            $options = get_option('upg_settings');

            if (!isset($options['upg_thumbnail_size_h'])) {
              $options['upg_thumbnail_size_w'] = "150";
              $options['upg_thumbnail_size_h'] = "150";

              $options['upg_medium_size_w'] = "300";
              $options['upg_medium_size_h'] = "300";

              $options['upg_large_size_w'] = "1024";
              $options['upg_large_size_h'] = "1024";
            }

            if (!isset($options['upg_thumbnail_crop'])) {
              $options['upg_thumbnail_crop'] = '0';
              $crop                          = false;
            } else {
              $crop = true;
            }

            add_image_size('odude-thumb', $options['upg_thumbnail_size_w'], $options['upg_thumbnail_size_h'], $crop);
            add_image_size('odude-medium', $options['upg_medium_size_w'], $options['upg_medium_size_h']);
            add_image_size('odude-large', $options['upg_large_size_w'], $options['upg_large_size_h']);
          }

          //Display notice as soon as plugin is activated.
          register_activation_hook(__FILE__, 'upg_admin_notice_example_activation_hook');

          function upg_admin_notice_example_activation_hook()
          {
            set_transient('upg-admin-notice-example', true, 5);
          }

          add_action('admin_notices', 'upg_admin_notice_example_notice');

          function upg_admin_notice_example_notice()
          {
            $options = get_option('upg_settings');
            /* Check transient, if available display notice */
            if (get_transient('upg-admin-notice-example')) {
              ?>
    <div class="updated notice is-dismissible">
      <h3>UPG Notes:</h3>
      <p>Some pages are auto created. Do not delete them even if not required.</p>
      <p>Go to UPG Settings and select those pages at appropriate location.</p>
      <p>It is advisable to update Wordpress "Settings > Permalinks", after page update.</p>
    </div>
  <?php
              /* Delete transient, only display this notice once. */
              delete_transient('upg-admin-notice-example');
            }

            if (upg_get_option('main_page', 'upg_gallery', '0') == '0') {
  ?>
    <div class="updated notice is-dismissible">

      <p>Review the pages selected at UPG settings and save it before continue. All pages must be selected.</p>

    </div>
<?php
            }
          }

          //Add menu hook to top of admin pages
          function upg_admin_top_menu()
          {
            if (is_admin()) {
              $page_name = 'wp_upg_quick';

              if (isset($_GET['page'])) {
                $page_name = $_GET['page'];
              }

              echo "<div style='text-align:right'>";

              echo "<a href='" . admin_url('edit.php?post_type=upg&page=wp_upg_quick') . "'><b class='button " . (('wp_upg_quick' == $page_name) ? 'button-primary' : '') . " '>" . __("Basic Settings", "wp-upg") . "</b></a>";
              echo " <a href='" . admin_url('edit.php?post_type=upg&page=wp_upg') . "'><b class='button  " . (('wp_upg' == $page_name) ? 'button-primary' : '') . " '>" . __("Advance Settings", "wp-upg") . "</b></a>";

              //$main_page_url = '#' . upg_get_option('main_page', 'upg_gallery', '0');

              //if (upg_get_option('main_page', 'upg_gallery', '0') != '0' && upg_get_option('main_page', 'upg_gallery', '0') != 'xxx')
              //    $main_page_url = esc_url(get_page_link(upg_get_option('main_page', 'upg_gallery', '0')));

              //echo " <a href='" . $main_page_url . "' class='button' target='_blank'>Test UPG Page</a>";
              echo " <a href='" . admin_url('edit.php?post_type=upg&page=wp_upg_layout') . "' class='button " . (('wp_upg_layout' == $page_name) ? 'button-primary' : '') . " '>" . __('Layout Editor', 'wp-upg') . "</a>";
              echo " <a href='" . admin_url('edit.php?post_type=upg&page=wp_upg_addon') . "' class='button " . (('wp_upg_addon' == $page_name) ? 'button-primary' : '') . " '>" . __('Addons & Help', 'wp-upg') . "</a>";
              echo " <a href='" . admin_url('edit.php?post_type=upg&page=upg_shortcode') . "' class='button " . (('upg_shortcode' == $page_name) ? 'button-primary' : '') . " '>" . __('Shortcode Guide', 'wp-upg') . "</a>";
              if (!is_upg_pro()) {
                echo " <a href='http://odude.com/product/wp-upg-pro/' class='button button-secondary'>Purchase UPG PRO</a>";
              }
              echo '</div>';
            }
          }
          add_action('upg_admin_top_menu', 'upg_admin_top_menu', 10, 2);

          /**
           * Hook into options page after save for advance setting page.
           */

            /* function upg_hook_advance_options_page_after_save( $old_value, $new_value )
{
// if ( $old_value['some_option'] != $new_value['some_option'] )
//{
// This value has been changed. Insert code here.
//}

$options = get_option('upg_settings');

if( $options['show_advance_setting']=='0')
{
upg_set_option( 'show_advance_setting', 'upg_general', '0' );

}
//upg_log($options['show_advance_setting']."----");
}
add_action( 'update_option_upg_settings', 'upg_hook_advance_options_page_after_save', 10, 2 ) */;

          //datatable ajax load [upg-datable]
          add_action("wp_ajax_upg_datatable", "upg_datatable");
          add_action("wp_ajax_nopriv_upg_datatable", "upg_datatable");

          function upg_datatable()
          {
            global $post;
            global $wp_query;
            $options = get_option('upg_settings', '');
            header("Content-Type: application/json");

            $request = $_GET;
            //print_r($request);

            //Add values as function into array
            $val        = array();
            $val_param1 = array();
            $val_param2 = array();
            $val_param3 = array();

            $values = explode(',', $request['field']);
            foreach ($values as $option) {
              $cap = explode(":", $option);

              //$cap[0] Is a column label assigned in datatable.php

              array_push($val, $cap[1]);

              if (isset($cap[2])) {
                array_push($val_param1, $cap[2]);
              } else {
                array_push($val_param1, '');
              }
              if (isset($cap[3])) {
                array_push($val_param2, $cap[3]);
              } else {
                array_push($val_param2, '');
              }
              if (isset($cap[4])) {
                array_push($val_param3, $cap[4]);
              } else {
                array_push($val_param3, '');
              }
            }

            //print_r($val);

            $args = array(
              'post_type'      => $request['post_type'],
              'post_status'    => 'publish',
              'posts_per_page' => $request['length'],
              'offset'         => $request['start'],
              'order'          => $request['order'][0]['dir'],
              '_meta_or_title' => $request['search']['value'], //action hook is used to replace 's'
            );

            if (!empty($request['search']['value'])) {
              // When datatables search is used

              $args['meta_query'] = array(
                'relation' => 'OR',
                array(
                  'key'     => 'xxxx',
                  'value'   => sanitize_text_field($request['search']['value']),
                  'compare' => 'LIKE',
                ),
              );

              if ('upg' == $request['post_type']) {
                for ($x = 1; $x <= 5; $x++) {
                  if ('on' == $options['upg_custom_field_' . $x . '_show_front']) {
                    $abc = array(
                      'relation' => 'OR',
                      array(
                        'key'     => 'upg_custom_field_' . $x,
                        'value'   => sanitize_text_field($request['search']['value']),
                        'compare' => 'LIKE',
                      ),
                    );

                    $args['meta_query'] = array_merge($args['meta_query'], $abc);
                  }
                }
              }
            }
            //print_r($args);

            $data_query = new WP_Query($args);
            $totalData  = $data_query->found_posts;

            if ($data_query->have_posts()) {

              while ($data_query->have_posts()) {

                $data_query->the_post();
                $nestedData = array();

                //Display column based on parameters
                for ($x = 0; $x < count($val); $x++) {

                  $func_name = trim($val[$x]);

                  if (function_exists($func_name)) {
                    $nestedData[] = $func_name($val_param1[$x], $val_param2[$x], $val_param3[$x]);
                  } else {
                    $nestedData[] = $func_name . "('" . $val_param1[$x] . "','" . $val_param2[$x] . ",'" . $val_param3[$x] . "') is invalid php function";
                  }
                }

                //Display column of custom fields of UPG settings
                for ($x = 1; $x <= 5; $x++) {
                  if ('on' == $options['upg_custom_field_' . $x . '_show_front']) {

                    $nestedData[] = upg_get_value('upg_custom_field_' . $x);
                  }
                }

                $data[] = $nestedData;
              }

              wp_reset_query();

              $json_data = array(
                "draw"            => intval($request['draw']),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalData),
                "data"            => $data,
              );

              echo json_encode($json_data);
            } else {

              $json_data = array(
                "draw"            => intval($request['draw']),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalData),
                "data"            => '',
              );

              echo json_encode($json_data);
            }
            wp_reset_query();
            wp_die();
          }

          // To search title along with meta query, replace the “s” parameter in your custom query with a “_meta_or_title” parameter.
          add_action('pre_get_posts', function ($q) {
            if ($title = $q->get('_meta_or_title')) {
              add_filter('get_meta_sql', function ($sql) use ($title) {
                global $wpdb;

                // Only run once:
                static $nr = 0;
                if (0 != $nr++) {
                  return $sql;
                }

                // Modified WHERE
                $sql['where'] = sprintf(
                  " AND ( %s OR %s ) ",
                  $wpdb->prepare("{$wpdb->posts}.post_title like '%%%s%%'", $title),
                  mb_substr($sql['where'], 5, mb_strlen($sql['where']))
                );

                return $sql;
              });
            }
          });

          //Display shortcode or content mentioned at UPG settings after content
          function upg_display_after_content($content)
          {
            global $post;
            $all_upg_fields = get_post_custom($post->ID);

            //Skip if in content , UPG settings is 'After Content' set to hide
            if (isset($all_upg_fields["upg_hide_after_content"][0]) && "hide" == $all_upg_fields["upg_hide_after_content"][0]) {
              return $content;
            }

            $selected = upg_get_option('after_content_post', 'upg_general', array());
            if (!is_array($selected)) {
              $selected = array();
            }

            if (is_single() || is_page() || !is_main_query() || !in_the_loop()) {
              if (in_array(get_post_type(), $selected, true)) {

                $after_content = upg_get_option('after_content', 'upg_general', '');
                $content .= do_shortcode(stripslashes($after_content));
              }
            }
            return $content;
            //return $selected;
          }
          add_filter("the_content", "upg_display_after_content");
?>