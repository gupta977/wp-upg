<?php

/**
 * ODude.com
 * #### Quick Mode backend setting page ###
 */
if ( !class_exists('upg_quick_setting' ) ):
class upg_quick_setting {

    private $settings_api;

    function __construct() {
        $this->settings_api = new upg_admin_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        $options = get_option('upg_settings'); 

    //if(upg_get_option( 'show_advance_setting', 'upg_general', '0' )=='0')
      add_submenu_page( 'edit.php?post_type=upg', 'UPG Settings', 'UPG Settings', 'manage_options', 'wp_upg_quick', array($this, 'plugin_page')  );
	
       // add_options_page( 'edit.php?post_type=upg', 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'upg_general',
                'title' => __( 'General Settings', 'wp-upg' )
            ),
            array(
                'id'    => 'upg_gallery',
                'title' => __( 'Gallery Settings', 'wp-upg' )
            ),
            array(
                'id'    => 'upg_form',
                'title' => __( 'Form Settings', 'wp-upg' )
            ),
            array(
                'id'    => 'upg_preview',
                'title' => __( 'Preview Settings', 'wp-upg' )
            )
        );

        if(has_filter('upg_setting_add_section')) 
        {
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
    function get_settings_fields() {
        $settings_fields = array(
            'upg_general' => array(
               
                array(
                    'name'    => 'my_login',
                    'label'   => __( 'Select Login page', 'wp-upg' ),
                    'desc'    => __( 'Login page where user enters username & passwords.', 'wp-upg' ),
                    'type'    => 'pages',
                    'default' => upg_get_option( 'my_login','upg_settings', '0' ),
                )
                
            ),
            'upg_gallery' => array(
                array(
                    'name'    => 'main_page',
                    'label'   => 'UPG '.__( 'main page', 'wp-upg' ),
                    'desc'    => __( 'Page cannot be static front page and it must include [upg-list] shortcode.', 'wp-upg' ),
                    'type'    => 'pages',
                    'default' => upg_get_option( 'main_page','upg_settings', '0' ),
                ),
                array(
                    'name'    => 'my_gallery',
                    'label'   => __( 'Members "My Gallery" page', 'wp-upg' ),
                    'desc'    => __( 'Page must contain [upg-list user="show_mine"] shortcode.', 'wp-upg' ),
                    'type'    => 'pages',
                    'default' => upg_get_option( 'my_gallery','upg_settings', '0' ),
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
                    'label' => __( 'Auto approve post', 'wp-upg' ),
                    'desc'  => __( 'Automatically publish Post as soon as user submit.', 'wp-upg' ),
                    'type'  => 'checkbox',
                    'default' => upg_get_option( 'publish','upg_settings', 'on' ),
                ),
                array(
                    'name'    => 'post_image_page',
                    'label'   => __( 'Select submission form of Image page', 'wp-upg' ),
                    'desc'    => __( 'Page must contain [upg-post type="image"] shortcode.', 'wp-upg' ),
                    'type'    => 'pages',
                    'default' => upg_get_option( 'post_image_page','upg_settings', '0' ),
                ),
                array(
                    'name'    => 'post_youtube_page',
                    'label'   => __( 'Select submission form of Youtube/Vimeo page', 'wp-upg' ),
                    'desc'    => __( 'Page must contain [upg-post type="youtube"] shortcode.', 'wp-upg' ),
                    'type'    => 'pages',
                    'default' => upg_get_option( 'post_youtube_page','upg_settings', '0' ),
                ),
                array(
                    'name'    => 'edit_upg_page',
                    'label'   => __( 'Submission form Edit/Modify page', 'wp-upg' ),
                    'desc'    => __( 'Page must contain [upg-edit] shortcode.', 'wp-upg' ),
                    'type'    => 'pages',
                    'default' => upg_get_option( 'edit_upg_page','upg_settings', '0' ),
                ),
                
               
            ),
            'upg_preview' => array(
                array(
                    'name'  => 'global_popup',
                    'label' => __( 'Enable Lightbox Popup', 'wp-upg' ),
                    'desc'  => __( 'Image will get enlarged at same page. There is no change in page hence no preview layout is used.', 'wp-upg' ),
                    'type'  => 'checkbox',
                    'default' => upg_get_option( 'global_popup','upg_preview', 'off' ),
                )
            )
        );

        if(has_filter('upg_setting_add_field')) 
        {
            $settings_fields = apply_filters('upg_setting_add_field', $settings_fields);
           // var_dump($settings_fields);
          // print_r($settings_fields);
        }

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';
        echo "<div style='text-align:right'><a href='".admin_url( 'edit.php?post_type=upg&page=wp_upg')."'><b class='button button-primary'>".__("Advance Settings","wp-upg")."</b></a></div>";
        echo "<h3>UPG ".__('Quick Settings','wp-upg')."</h3>";
        settings_errors();
        $this->settings_api->show_navigation();
       
        $this->settings_api->show_forms();

        
        echo '</div>';
    }

}
endif;

if( is_admin() )
new upg_quick_setting();