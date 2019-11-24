<?php

/**
 * ODude.com
 * #### Quick Mode backend setting page ###
 */
if (!class_exists('upg_quick_setting')) :
    class upg_quick_setting
    {
        private $settings_api;

        public function __construct()
        {
            $this->settings_api = new upg_admin_Settings_API;

            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
        }

        public function admin_init()
        {

            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());

            //initialize settings
            $this->settings_api->admin_init();
        }

        public function admin_menu()
        {
            $options = get_option('upg_settings');

            //if(upg_get_option( 'show_advance_setting', 'upg_general', '0' )=='0')
            //add_submenu_page('admin.php?page=upg_dashboard', 'Basic Settings', 'Basic Settings', 'manage_options', 'wp_upg_quick', array($this, 'plugin_page'));
            add_submenu_page('edit.php?post_type=upg', 'Basic Settings', 'Basic Settings', 'manage_options', 'wp_upg_quick', array($this, 'plugin_page'));
        }

        public function get_settings_sections()
        {
            $sections = array(
                array(
                    'id'    => 'upg_general',
                    'title' => __('General Settings', 'wp-upg')
                ),
                array(
                    'id'    => 'upg_gallery',
                    'title' => __('Gallery Settings', 'wp-upg')
                ),
                array(
                    'id'    => 'upg_form',
                    'title' => __('Form Settings', 'wp-upg')
                ),
                array(
                    'id'    => 'upg_preview',
                    'title' => __('Preview Settings', 'wp-upg')
                )
            );

            if (has_filter('upg_setting_add_section')) {
                $sections = apply_filters('upg_setting_add_section', $sections);
                // var_dump($sections);
            }

            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        public function get_settings_fields()
        {

            //Link for login page
            $login_page = upg_get_option('my_login', 'upg_general', '0');
            if ($login_page != '0') {
                $linku = get_permalink($login_page);
                $login_page = "<a href='" . $linku . "' target='_blank'>" . __("View Page", "wp-upg") . "</a>";
            } else {
                $login_page = '';
            }

            //Link for Main UPG page
            $main_upg_page = upg_get_option('main_page', 'upg_gallery', '0');
            if ($main_upg_page != '0') {
                $linku = get_permalink($main_upg_page);
                $main_upg_page = "<a href='" . $linku . "' target='_blank'>" . __("View Page", "wp-upg") . "</a>";
            } else {
                $main_upg_page = '';
            }

            //Link My Gallery Page
            $my_gallery_page = upg_get_option('my_gallery', 'upg_gallery', '0');
            if ($my_gallery_page != '0') {
                $linku = get_permalink($my_gallery_page);
                $my_gallery_page = "<a href='" . $linku . "' target='_blank'>" . __("View Page", "wp-upg") . "</a>";
            } else {
                $my_gallery_page = '';
            }

            //Image Submission form
            $post_image_page = upg_get_option('post_image_page', 'upg_form', '0');
            if ($post_image_page != '0') {
                $linku = get_permalink($post_image_page);
                $post_image_page = "<a href='" . $linku . "' target='_blank'>" . __("View Page", "wp-upg") . "</a>";
            } else {
                $post_image_page = '';
            }

            //URL submission form
            $post_youtube_page = upg_get_option('post_youtube_page', 'upg_form', '0');
            if ($post_youtube_page != '0') {
                $linku = get_permalink($post_youtube_page);
                $post_youtube_page = "<a href='" . $linku . "' target='_blank'>" . __("View Page", "wp-upg") . "</a>";
            } else {
                $post_youtube_page = '';
            }

            //Edit/Modify page
            $edit_upg_page = upg_get_option('edit_upg_page', 'upg_form', '0');
            if ($edit_upg_page != '0') {
                $linku = get_permalink($edit_upg_page);
                $edit_upg_page = "<a href='" . $linku . "' target='_blank'>" . __("View Page", "wp-upg") . "</a>";
            } else {
                $edit_upg_page = '';
            }

            function custom_post_list()
            {
                $args_q = array(
                    'public'   => true,
                    '_builtin' => false,
                    'publicly_queryable' => true
                );

                $output = 'names'; // names or objects, note names is the default
                $operator = 'and'; // 'and' or 'or'

                $post_types = get_post_types($args_q, $output, $operator);
                $a = array('post' => 'post');
                $b = array('page' => 'page');
                $post_types = array_merge($post_types, $a);
                $post_types = array_merge($post_types, $b);

                return $post_types;
            }
            $settings_fields = array(
                'upg_general' => array(

                    array(
                        'name'    => 'my_login',
                        'label'   => __('Select Login page', 'wp-upg'),
                        'desc'    => __('Login page where user enters username & passwords.', 'wp-upg') . " " . $login_page,
                        'type'    => 'pages',
                        'default' => upg_get_option('my_login', 'upg_general', '0'),
                    ),
                    array(
                        'name'    => 'after_content',
                        'label'   => __('"After Content" Shortcode', 'wp-upg'),
                        'desc'    => __('Shortcode to display on selected location.<br>Eg. Social Share, Buttons, Attach Gallery', 'wp-upg') . ' <code>[upg-attach button="off" form_layout="simple" gallery_layout="photo" popup="on"]</code><br>' . __('You can hide from specific post by editing.<br><b>Note:</b> Do not use [upg-list] here.', 'wp-upg'),
                        'type'    => 'textarea',
                        'default' => upg_get_option('after_content', 'upg_general', '[upg-attach button="off" form_layout="simple" gallery_layout="photo" popup="on"]'),
                    ),
                    array(
                        'name'    => 'after_content_post',
                        'label'   => __('Display "After Content" at', 'wp-upg'),
                        'desc'    => __('Select where you like to show shortcode mentioned in "After Content".', 'wp-upg'),
                        'type'    => 'multicheck',
                        'default' => upg_get_option('after_content_post', 'upg_general', array()),
                        'options' => custom_post_list(),
                    ),

                ),
                'upg_gallery' => array(
                    array(
                        'name'    => 'main_page',
                        'label'   => 'UPG ' . __('main page', 'wp-upg'),
                        'desc'    => __('Page cannot be static front page and it must include <code>[upg-list]</code> shortcode.', 'wp-upg') . " " . $main_upg_page,
                        'type'    => 'pages',
                        'default' => upg_get_option('main_page', 'upg_gallery', '0'),
                    ),
                    array(
                        'name'    => 'my_gallery',
                        'label'   => __('Members "My Gallery" page', 'wp-upg'),
                        'desc'    => __('Page must contain <code>[upg-list user="show_mine"]</code> shortcode.', 'wp-upg') . " " . $my_gallery_page,
                        'type'    => 'pages',
                        'default' => upg_get_option('my_gallery', 'upg_gallery', '0'),
                    ),
                    array(
                        'name'  => 'gallery_tags',
                        'label' => __('Gallery Tags', 'wp-upg'),
                        'desc'  => __('Shows tags above the gallery, if few tag presets. <code>[upg-list tag_show="on"]</code>', 'wp-upg'),
                        'type'  => 'checkbox',
                        'default' => upg_get_option('gallery_tags', 'upg_gallery', 'off'),
                    ),
                    array(
                        'name'    => 'global_layout',
                        'label'   => __('Select Gallery/Grid Template', 'wp-upg'),
                        'desc'    => __('It is applied if "layout" parameter in shortcode is not specified.', 'wp-upg'),
                        'type'    => 'layout',
                        'param1' => 'grid',
                        'default' => upg_get_option('global_layout', 'upg_gallery', 'photo'),
                    ),

                    /*  array(
                    'name'        => 'heading2',
                    'label'             => __( 'My Heading2', 'wp-upg' ),
                    'desc'        => __( 'This is heading description' ),
                    'type'        => 'subheading'
                ), */

                ),
                'upg_form' => array(
                    array(
                        'name'  => 'publish',
                        'label' => __('Auto approve post', 'wp-upg'),
                        'desc'  => __('Automatically publish Post as soon as user submit.', 'wp-upg'),
                        'type'  => 'checkbox',
                        'default' => upg_get_option('publish', 'upg_form', 'on'),
                    ),
                    array(
                        'name'    => 'post_image_page',
                        'label'   => __('Select image submission form', 'wp-upg'),
                        'desc'    => __('Page must contain <code>[upg-post type="image"]</code> or full <code>[upg-form]</code> shortcode.', 'wp-upg') . " " . $post_image_page,
                        'type'    => 'pages',
                        'default' => upg_get_option('post_image_page', 'upg_form', '0'),
                    ),
                    array(
                        'name'    => 'post_youtube_page',
                        'label'   => __('Select embed,url submission form', 'wp-upg'),
                        'desc'    => __('Page must contain <code>[upg-post type="embed"]</code> or full <code>[upg-form]</code> shortcode.', 'wp-upg') . " " . $post_youtube_page,
                        'type'    => 'pages',
                        'default' => upg_get_option('post_youtube_page', 'upg_form', '0'),
                    ),
                    array(
                        'name'    => 'edit_upg_page',
                        'label'   => __('Submission form Edit/Modify page', 'wp-upg'),
                        'desc'    => __('Page must contain <code>[upg-edit]</code> shortcode.', 'wp-upg') . " " . $edit_upg_page,
                        'type'    => 'pages',
                        'default' => upg_get_option('edit_upg_page', 'upg_form', '0'),
                    ),

                    array(
                        'name'    => 'global_form_layout',
                        'label'   => __('Select Form Template', 'wp-upg'),
                        'desc'    => __('Only for <code>[upg-post]</code>', 'wp-upg'),
                        'type'    => 'layout',
                        'param1' => 'form',
                        'default' => upg_get_option('global_form_layout', 'upg_form', 'basic'),
                    ),
                ),
                'upg_preview' => array(
                    array(
                        'name'  => 'global_popup',
                        'label' => __('Enable Lightbox Popup', 'wp-upg'),
                        'desc'  => __('Image will get enlarged at same page. There is no change in page hence no preview layout is used.', 'wp-upg'),
                        'type'  => 'checkbox',
                        'default' => upg_get_option('global_popup', 'upg_preview', 'on'),
                    ),
                    array(
                        'name'    => 'global_media_layout',
                        'label'   => __('Select Preview/Media Template', 'wp-upg'),
                        'desc'    => __('If lightbox/popup is enabled, this layout has no use. It is applied only to newly submitted post.', 'wp-upg'),
                        'type'    => 'layout',
                        'param1' => 'media',
                        'default' => upg_get_option('global_media_layout', 'upg_preview', 'basic'),
                    ),
                    array(
                        'name'    => 'global_media_shortcode_1',
                        'label'   => __('Shortcode Position 1st', 'wp-upg'),
                        'desc'    => __('Insert or copy/paste other plugins shortcode here. Eg.', 'wp-upg') . '[upg-breadcrumb]',
                        'type'    => 'textarea',
                        'default' => upg_get_option('global_media_shortcode_1', 'upg_preview', ''),
                    ),
                    array(
                        'name'    => 'global_media_shortcode_2',
                        'label'   => __('Shortcode Position 2nd', 'wp-upg'),
                        'desc'    => __('Shortcode Eg. social share, buttons, notices', 'wp-upg'),
                        'type'    => 'textarea',
                        'default' => upg_get_option('global_media_shortcode_2', 'upg_preview', ''),
                    ),
                ),
            );

            if (has_filter('upg_setting_add_field')) {
                $settings_fields = apply_filters('upg_setting_add_field', $settings_fields);
                // var_dump($settings_fields);
                // print_r($settings_fields);
            }

            return $settings_fields;
        }

        public function plugin_page()
        {
            settings_errors();

            echo '<div class="wrap">';

            do_action("upg_admin_top_menu");

            //echo upg_get_option( 'global_form_layout','upg_form', 'basic' )."-----";

            echo "<h3>UPG " . __('Basic Settings', 'wp-upg') . "</h3>";
            $this->settings_api->show_navigation();

            $this->settings_api->show_forms();
            flush_rewrite_rules();

            echo '</div>';
        }
    }
endif;

if (is_admin()) {
    new upg_quick_setting();
}
