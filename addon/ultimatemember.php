<?php
/* First we need to extend main profile tabs */
$options = get_option('upg_settings', '');

if (isset($options['upg_ultimatemember_enable']) && '1' == $options['upg_ultimatemember_enable']) {
 add_filter('um_profile_tabs', 'add_upg_profile_tab', 1000);
}
function add_upg_profile_tab($tabs)
{
 $options     = get_option('upg_settings', '');
 $tabs['upg'] = array(
  'name'   => $options['upg_ultimatemember_tabname'],
  'icon'   => $options['upg_ultimatemember_icon'],
  'custom' => true,
 );

 return $tabs;

}

/* Then we just have to add content to that tab using this action */

add_action('um_profile_content_upg_default', 'um_profile_content_upg_default');
function um_profile_content_upg_default($args)
{

 $user_info = get_userdata(um_profile_id());
 echo do_shortcode('[upg-list user="' . $user_info->user_login . '" author="off" ] ');
}
