<?php 
/*
Plugin Name: WP-UPG
Plugin URI: https://odude.com
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


class upgOptionsPage {
	
	private $options_general;
    private $options_gallery;
    private $options_form;
	
	
	public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'upg_options_init' ) );
    }

    public function add_plugin_page(){
        add_submenu_page( 'edit.php?post_type=upg', 'Quick Mode Setting', 'Quick Settings', 'manage_options', 'upg_quick_setting', array( $this,'upg_admin_quick_settings') );
	
        //add_menu_page('edit.php?post_type=upg', 'Kvcodes', 'manage_options', 'kvcodes' , array( $this,'upg_admin_quick_settings') );
    }

     public function upg_admin_quick_settings() {
        $this->options_general = get_option( 'upg_general' );
		$this->options_gallery = get_option( 'upg_gallery' );
        $this->options_form = get_option( 'upg_form' ); 
        
       $gallery_Screen = ( isset( $_GET['action'] ) && 'gallery' == $_GET['action'] ) ? true : false;
       $form_Screen = ( isset( $_GET['action'] ) && 'form' == $_GET['action'] ) ? true : false;    
       $preview_Screen = ( isset( $_GET['action'] ) && 'preview' == $_GET['action'] ) ? true : false;

       ?>
        <div class="wrap">
            <h1>UPG Quick Mode Settings</h1>
            <h2 class="nav-tab-wrapper">
				<a href="<?php echo admin_url( 'edit.php?post_type=upg&page=upg_quick_setting' ); ?>" class="nav-tab<?php if ( ! isset( $_GET['action'] ) || isset( $_GET['action'] ) && 'gallery' != $_GET['action']  && 'form' != $_GET['action'] && 'preview' != $_GET['action'] ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'General' ); ?></a>
				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'gallery' ), admin_url( 'edit.php?post_type=upg&page=upg_quick_setting' ) ) ); ?>" class="nav-tab<?php if ( $gallery_Screen ) echo ' nav-tab-active'; ?>">Gallery</a> 
				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'form' ), admin_url( 'edit.php?post_type=upg&page=upg_quick_setting' ) ) ); ?>" class="nav-tab<?php if ( $form_Screen ) echo ' nav-tab-active'; ?>">Form</a>        
                <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'preview' ), admin_url( 'edit.php?post_type=upg&page=upg_quick_setting' ) ) ); ?>" class="nav-tab<?php if ( $preview_Screen ) echo ' nav-tab-active'; ?>">Preview</a>  
			</h2>
    
        	 <form method="post" action="options.php"><?php //   settings_fields( 'upg_general' );
                 if($gallery_Screen) 
                 { 
					settings_fields( 'upg_gallery' );
					do_settings_sections( 'upg-setting-gallery' );
					submit_button();
                } 
                elseif($form_Screen) 
                {
					settings_fields( 'upg_form' );
					do_settings_sections( 'upg-setting-form' );
					submit_button();
                }
                elseif($preview_Screen) 
                {
					settings_fields( 'upg_preview' );
					do_settings_sections( 'upg-setting-preview' );
					submit_button();
                }
                else 
                { 
					settings_fields( 'upg_general' );
					do_settings_sections( 'upg-setting-admin' );
					submit_button(); 
				} ?>
			</form>
        </div> <?php
	}

  public function upg_options_init() { 
         register_setting(
            'upg_general', // Option group
            'upg_general', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'All Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'upg-setting-admin' // Page
        ); 
		 add_settings_field(
            'logo_image', 
            'Logo Image', 
            array( $this, 'logo_image_callback' ), 
            'upg-setting-admin', 
            'setting_section_id'
        );  
		
        //For grig/gallery
        
		register_setting(
            'upg_gallery', // Option group
            'upg_gallery', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        add_settings_section(
            'setting_section_id', // ID
            'gallery Settings', // Title
            array( $this, 'print_section_gallery_info' ), // Callback
            'upg-setting-gallery' // Page
        );  
		
		 add_settings_field(
            'fb_url', // ID
            'Facebook URL', // Title 
            array( $this, 'fb_url_callback' ), // Callback
            'upg-setting-gallery', // Page
            'setting_section_id' // Section           
        );
		
        //For submission form
        
		register_setting(
            'upg_form', // Option group
            'upg_form', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        add_settings_section(
            'setting_section_id', // ID
            'form Details', // Title
            array( $this, 'print_section_info' ), // Callback
            'upg-setting-form' // Page
        );         

        add_settings_field(
            'hide_more_themes', 
            'Hide Find more themes at Kvcodes.com', 
            array( $this, 'hide_more_themes_callback' ), 
            'upg-setting-form', 
            'setting_section_id'
        );

        //For preview tab
        register_setting(
            'upg_preview', // Option group
            'upg_preview', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        add_settings_section(
            'setting_section_id', // ID
            'preview Details', // Title
            array( $this, 'print_section_info' ), // Callback
            'upg-setting-preview' // Page
        );         

        add_settings_field(
            'hide_more_themes', 
            'yyyyyyyyy', 
            array( $this, 'hide_more_themes_callback' ), 
            'upg-setting-preview', 
            'setting_section_id'
        );

	}


	public function print_section_info(){
			//your code...
    }
    public function print_section_gallery_info()
    {
        echo "oooooooooo";
}


	public function fb_url_callback() {
        printf(
            '<input type="text" id="fb_url" name="upg_gallery[fb_url]" value="%s" />',
            isset( $this->options_gallery['fb_url'] ) ? esc_attr( $this->options_gallery['fb_url']) : ''
        );
    }

    public function hide_more_themes_callback(){
        printf(
            '<input type="checkbox" id="hide_more_themes" name="upg_form[hide_more_themes]" value="yes" %s />',
            (isset( $this->options_form['hide_more_themes'] ) && $this->options_form['hide_more_themes'] == 'yes') ? 'checked' : ''
        );
    }

    public function logo_image_callback() {
        printf(
            '<input type="text" name="upg_general[logo_image]" id="logo_image" value="%s"> <a href="#" id="logo_image_url" class="button" > Select </a>',
            isset( $this->options_general['logo_image'] ) ? esc_attr( $this->options_general['logo_image']) : ''
             );
    }

   public function sanitize( $input )  {
        $new_input = array();
        if( isset( $input['fb_url'] ) )
            $new_input['fb_url'] = sanitize_text_field( $input['fb_url'] );
      
        if( isset( $input['hide_more_themes'] ) )
            $new_input['hide_more_themes'] = sanitize_text_field( $input['hide_more_themes'] );
       
        if( isset( $input['logo_image'] ) )
            $new_input['logo_image'] = sanitize_text_field( $input['logo_image'] );

        return $new_input;
    }
}

if( is_admin() )
 $settings_page = new upgOptionsPage();
 ?>