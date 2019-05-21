<?php

/**
 * ODude.com
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

        if(upg_get_option( 'show_advance_setting', 'upg_general', '0' )=='0')
        add_submenu_page( 'edit.php?post_type=upg', 'Quick Mode Setting', 'Quick Settings', 'manage_options', 'wp_upg', array($this, 'plugin_page')  );
	
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
                    'name' => 'show_advance_setting',
                    'label' => __('Switch setting mode', 'wp-upg'),
                    'desc' => __('If you are a expert user, switch to advanced mode for lots of UPG settings.', 'wp-upg'),
                    'type' => 'radio',
                    'default'=> '0',
                    'options' => array(
                        '1' => 'Advanced',
                        '0' => 'Quick'
                    )
                ),
                array(
                    'name'        => 'heading1',
                    'label'             => __( 'My Heading', 'wp-upg' ),
                    'desc'        => __( 'This is heading description' ),
                    'type'        => 'subheading'
                ),
                array(
                    'name'              => 'text_val2',
                    'label'             => __( 'Next', 'wp-upg' ),
                    'desc'              => __( 'Text input description', 'wp-upg' ),
                    'placeholder'       => __( 'Text Input placeholder', 'wp-upg' ),
                    'type'              => 'text',
                    'default'           => 'Title',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                
            ),
            'upg_gallery' => array(
                array(
                    'name'    => 'color',
                    'label'   => __( 'Cat1', 'wp-upg' ),
                    'desc'    => __( 'Color description', 'wp-upg' ),
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'name'    => 'color2',
                    'label'   => __( 'cat2', 'wp-upg' ),
                    'desc'    => __( 'Color description', 'wp-upg' ),
                    'type'    => 'color',
                    'default' => ''
                ),
               /*  array(
                    'name'        => 'heading2',
                    'label'             => __( 'My Heading2', 'wp-upg' ),
                    'desc'        => __( 'This is heading description' ),
                    'type'        => 'subheading'
                ), */
                
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
        settings_errors();
        $this->settings_api->show_navigation();
       
        $this->settings_api->show_forms();

        
        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;

if( is_admin() )
new upg_quick_setting();