<?php
/* First we need to extend main profile tabs */
$options = get_option( 'upg_settings','' );
if(isset($options['upg_buddypress_enable']) && $options['upg_buddypress_enable']=='1')
add_action( 'bp_setup_nav', 'add_upg_buddypress_tab' );
function add_upg_buddypress_tab( $tabs ) 
{
	$options = get_option( 'upg_settings','' );
	global $bp;
	$options = get_option( 'upg_settings','' );
   $yourtab=$options['upg_ultimatemember_tabname'];
 
      bp_core_new_nav_item( array( 
            'name' => $yourtab, 
            'slug' => 'upg', 
            'screen_function' => 'upg_buddypress_yourtab_screen', 
            'position' => 40,
            'parent_url'      => bp_loggedin_user_domain() . '/upg/',
            'parent_slug'     => $bp->profile->slug,
            'default_subnav_slug' => 'upg'
      ) );
	
}

/* Then we just have to add content to that tab using this action */


function upg_buddypress_yourtab_screen() {
    
    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'upg_buddypress_yourtab_title' );
    add_action( 'bp_template_content', 'upg_buddypress_yourtab_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function upg_buddypress_yourtab_title() {
   $options = get_option( 'upg_settings','' );
   echo $options['upg_ultimatemember_tabname'];
}

function upg_buddypress_yourtab_content() 
{ 
    
	$user_info = bp_get_displayed_user_username();
	echo do_shortcode( '[upg-list user="'.$user_info.'" author="off" ] ' );
}
?>