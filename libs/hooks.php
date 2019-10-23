<?php
add_action('wp_head', 'upg_metatag_facebook_head');
add_action('init', 'upg_post_types');
add_action('init', 'register_upg_taxonomies');
add_filter("the_content", "upg_the_content");
add_shortcode("upg-pick", "upg_pick");
add_shortcode("upg-list", "upg_list");
add_shortcode("upg-attach", "upg_attach");
add_shortcode("upg-datatable", "upg_datatable_shortcode");

//List Albums
add_shortcode("upg-album", "upg_album");
//Shortocde for magic form
add_shortcode("upg-form", "upg_magic_form");
add_shortcode("upg-form-tag", "upg_magic_form_tag");
add_shortcode("upg-post", "upg_user_post_form");
add_shortcode("upg-edit", "upg_user_edit_form");
add_shortcode("upg-video", "upg_showyoutube");
add_action('wp_enqueue_scripts', 'upg_enqueue_scripts');
add_action('admin_enqueue_scripts', 'upg_admin_enqueue_scripts');
add_action('plugins_loaded', 'upg_languages');
add_action('init', 'upg_languages');
add_action('init', 'upg_plugin_check_version');
if (is_admin()) {

	//wp_enqueue_script('post_img', upg_PLUGIN_URL.'/js/post_img.js');
	add_action('admin_init', 'upg_meta_boxes', 0);
	//Update values in meta box
	add_action('save_post', 'upg_save_meta_data', 10, 2);
	add_action('admin_menu', 'upg_add_admin_menu');
	add_action('plugins_loaded', array('upg_FormEntries', 'init'));
	add_action('admin_init', 'upg_settings_init');
}
