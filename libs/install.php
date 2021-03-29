<?php
$options = get_option('upg_settings');

/* if(!isset($options['show_advance_setting']))
	{
		$options['show_advance_setting']='0';
		update_option( 'upg_settings', $options );	
	} */

if (!isset($options['global_page'])) {
	$options['global_page'] = 'off';
	update_option('upg_settings', $options);
}

if (!isset($options['global_popup'])) {
	$options['global_popup'] = 'off';
	update_option('upg_settings', $options);
}

if (!isset($options['global_perrow'])) {
	$options['global_perrow'] = '3';
	update_option('upg_settings', $options);
}
if (!isset($options['global_perpage'])) {
	$options['global_perpage'] = '15';
	update_option('upg_settings', $options);
}

if (!isset($options['global_order'])) {
	$options['global_order'] = 'date';
	update_option('upg_settings', $options);
}


if (!isset($options['global_album'])) {
	$options['global_album'] = '';
	update_option('upg_settings', $options);
}
if (!isset($options['approve_show'])) {
	$options['approve_show'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['post_types']['upg'])) {
	$options['post_types']['upg'] = 'on';
	update_option('upg_settings', $options);
}
if (!isset($options['sub_show_formshow_desp'])) {
	$options['sub_show_formshow_desp'] = "0";
	update_option('upg_settings', $options);
}
if (!isset($options['primary_show_formshow_desp'])) {
	$options['primary_show_formshow_desp'] = "0";
	update_option('upg_settings', $options);
}

if (!isset($options['image_required'])) {
	$options['image_required'] = "0";
	update_option('upg_settings', $options);
}


if (!isset($options['archive'])) {
	$options['archive'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['purecss'])) {
	$options['purecss'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['fontawesome'])) {
	$options['fontawesome'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['fancybox'])) {
	$options['fancybox'] = '0';
	update_option('upg_settings', $options);
}


if (!isset($options['primary_show_image_button'])) {
	$options['primary_show_image_button'] = '1';
	update_option('upg_settings', $options);
}

if (!isset($options['primary_show_youtube_button'])) {
	$options['primary_show_youtube_button'] = '1';
	update_option('upg_settings', $options);
}
if (!isset($options['button_check_login'])) {
	$options['button_check_login'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['show_trash_icon'])) {
	$options['show_trash_icon'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['show_edit_icon'])) {
	$options['show_edit_icon'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['show_user_icon'])) {
	$options['show_user_icon'] = '0';
	update_option('upg_settings', $options);
}

if (!isset($options['main_page'])) {
	$options['main_page'] = '0';
	update_option('upg_settings', $options);
}

//Custom extra fields

for ($x = 1; $x <= 10; $x++) {
	//echo $x;
	if (!isset($options['upg_custom_field_' . $x])) {
		$options['upg_custom_field_' . $x] = 'Field ' . $x;
		update_option('upg_settings', $options);
	}
	//echo $options['upg_custom_field_'.$x];

	if (!isset($options['upg_custom_field_' . $x . '_show'])) {
		$options['upg_custom_field_' . $x . '_show'] = 'off';
		update_option('upg_settings', $options);
	}

	if (!isset($options['upg_custom_field_' . $x . '_show_front'])) {
		$options['upg_custom_field_' . $x . '_show_front'] = 'off';
		update_option('upg_settings', $options);
	}

	if (!isset($options['upg_custom_field_type_' . $x])) {
		$options['upg_custom_field_type_' . $x] = "text";
		update_option('upg_settings', $options);
	}
}


function upg_post_types()
{
	$settings = maybe_unserialize(get_option('upg_settings'));

	$product = "UPG-Post";

	register_post_type(
		"upg",
		array(

			'labels' => array(
				'name' => __('User Post Gallery', 'wp-upg'),
				'singular_name' => 'UPG ' . __('Post', 'wp-upg'),
				'add_new' => __('Add ' . $product, 'wp-upg'),
				'add_new_item' => __('Add New ' . $product, 'wp-upg'),
				'edit_item' => __('Edit ' . $product, 'wp-upg'),
				'new_item' => __('New ' . $product, 'wp-upg'),
				'view_item' => __('View ' . $product, 'wp-upg'),
				'search_items' => __('Search ' . $product, 'wp-upg'),
				'not_found' =>  __('No ' . $product . ' found', 'wp-upg'),
				'not_found_in_trash' => __('No ' . $product . ' found in Trash', 'wp-upg'),
				'parent_item_colon' => '',
				'featured_image'        => __('Featured image', 'wp-upg'),
				'set_featured_image'    => __('Set featured image', 'wp-upg'),
				'remove_featured_image' => __('Remove featured Image', 'wp-upg'),

			),
			'public' => true,
			'show_in_nav_menus' => false,
			'show_in_menu' => true, //Hide/show from menu
			'publicly_queryable' => true,
			'show_in_rest' => true,
			'has_archive' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'upg', 'with_front' => true),
			'capability_type' => 'post',
			'hierarchical' => true,
			'menu_icon' => upg_PLUGIN_URL . '/images/odude.png',
			//'supports' => array('title','editor','author','excerpt','thumbnail','ptype','comments'/*,'custom-fields'*/) ,            
			'supports' => array('title', 'editor', 'upg_cate', 'upg_tag', 'comments', 'thumbnail', 'author'/*,'custom-fields'*/),
			'taxonomies' => array('upg_cate'),
			'taxonomies' => array('upg_tag')

		)
	);
}




function register_upg_taxonomies()
{
	$product = "UPG-Post";

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name' => __($product . ' Albums', 'wp-upg'),
		'singular_name' => __($product . ' Album', 'wp-upg'),
		'search_items' =>  __('Search ' . $product . ' Albums', 'wp-upg'),
		'all_items' => __('All ' . $product . ' Albums', 'wp-upg'),
		'parent_item' => __('Parent ' . $product . ' Album', 'wp-upg'),
		'parent_item_colon' => __('Parent ' . $product, 'wp-upg'),
		'edit_item' => __('Edit ' . $product . ' Album', 'wp-upg'),
		'update_item' => __('Update ' . $product . ' Album', 'wp-upg'),
		'add_new_item' => __('Add New ' . $product . ' Album', 'wp-upg'),
		'new_item_name' => __('New ' . $product . ' Album Name', 'wp-upg'),
		'menu_name' => __($product . ' Albums', 'wp-upg'),
	);

	register_taxonomy('upg_cate', array('upg'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_in_rest' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'wp-upg', 'hierarchical' => true, 'with_front' => true),
		'with_front' => true
	));


	$labels = array(
		'name' => __($product . ' Tags', 'wp-upg'),
		'singular_name' => __($product . ' Tag', 'wp-upg'),
		'search_items' =>  __($product . ' Tags', 'wp-upg'),
		'all_items' => __($product . ' All Tags', 'wp-upg'),
		'parent_item' => __('Parent Tag', 'wp-upg'),
		'parent_item_colon' => __('Parent Tag', 'wp-upg'),
		'edit_item' => __('Edit Tag', 'wp-upg'),
		'update_item' => __('Update Tag', 'wp-upg'),
		'add_new_item' => __('Add New ' . $product . ' Tag', 'wp-upg'),
		'new_item_name' => __('New Tag Name', 'wp-upg'),
		'menu_name' => __($product . ' Tags', 'wp-upg'),
	);

	register_taxonomy('upg_tag', array('upg'), array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'upg_tag'),
	));
}
function upg_install()
{
	update_option('upg_plugin_version', UPG_PLUGIN_VERSION);

	upg_post_types();
	register_upg_taxonomies();
	flush_rewrite_rules();

	global $wpdb;

	if (!$wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[upg-list]%'")) {

		$aid = wp_insert_post(array('post_title' => 'User\'s Photo Gallery', 'post_content' => '[upg-list]', 'post_type' => 'page', 'post_status' => 'publish'));
		upg_set_option('main_page', 'upg_gallery', $aid);
		update_post_meta($aid, "upg_hide_after_content", "hide");

		$str_post_image = '
		[upg-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" ajax="true"]
		[upg-form-tag type="post_title" title="Title" value="" placeholder="main title"]
		[upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="image"]
		[upg-form-tag type="tag" title="Insert tag"]
		[upg-form-tag type="article" title="Description"  placeholder="Content"]
		[upg-form-tag type="file" title="Select file"]
		[upg-form-tag type="submit" name="submit" value="Submit Now"]
		[/upg-form]
		';

		$bid = wp_insert_post(array('post_title' => 'Post Image', 'post_content' => $str_post_image, 'post_type' => 'page', 'post_status' => 'publish'));
		upg_set_option('post_image_page', 'upg_form', $bid);
		update_post_meta($bid, "upg_hide_after_content", "hide");

		$str_post_embed = '
		[upg-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" ajax="true" post_type="video_url"] 
[upg-form-tag type="post_title" title="Video Title" value="" placeholder="main title"]
[upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="embed" ]
[upg-form-tag type="tag" title="Insert tag"]
[upg-form-tag type="article" title="Description"  placeholder="Content"]
[upg-form-tag type="video_url" title="Submit public embed URL" placeholder="http://" required="true"]
[upg-form-tag type="submit" name="submit" value="Submit URL"]
[/upg-form]
		';



		$cid = wp_insert_post(array('post_title' => 'Post Video URL', 'post_content' => $str_post_embed, 'post_type' => 'page', 'post_status' => 'publish'));
		upg_set_option('post_youtube_page', 'upg_form', $cid);
		update_post_meta($cid, "upg_hide_after_content", "hide");

		$did = wp_insert_post(array('post_title' => 'My Gallery', 'post_content' => '[upg-list user="show_mine" layout="filter" perpage="50"]', 'post_type' => 'page', 'post_status' => 'publish'));
		upg_set_option('my_gallery', 'upg_gallery', $did);
		update_post_meta($did, "upg_hide_after_content", "hide");

		$eid = wp_insert_post(array('post_title' => 'Edit UPG Post', 'post_content' => '[upg-edit]', 'post_type' => 'page', 'post_status' => 'publish'));
		upg_set_option('edit_upg_page', 'upg_form', $eid);
		update_post_meta($eid, "upg_hide_after_content", "hide");
	}

	$parent_term = term_exists('', 'upg_cate'); // array is returned if taxonomy is given
	if (isset($parent_term['term_id'])) {
		$parent_term_id = $parent_term['term_id']; // get numeric term id
	} else {
		$parent_term_id = "500";
	}

	wp_insert_term(
		'Fruits', // the term 
		'upg_cate', // the taxonomy
		array(
			'description' => 'Fruits images',
			'slug' => 'fruits',
			'parent' => $parent_term_id
		)
	);
	wp_insert_term(
		'Vegetable', // the term 
		'upg_cate', // the taxonomy
		array(
			'description' => 'Vegetable images',
			'slug' => 'vegetable',
			'parent' => $parent_term_id
		)
	);
}

function upg_drop()
{
	//Function during uninstall

	//Don't delete pages by associated page at UPG settings,
	// User may be mistakenly assigned wrong UPG page.



	global $wpdb;
	//Search for [upg- pages, and delete that. Check 5 places
	for ($x = 1; $x <= 3; $x++) {

		//Delete Main page
		$page_id = $wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[upg-list]%'");
		wp_delete_post($page_id);

		//Delete My Gallery
		$page_id = $wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[upg-list user=\"show_mine\"%'");
		wp_delete_post($page_id);

		//Search for [upg-post pages, and delete that. 
		$page_id = $wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[upg-post%'");
		wp_delete_post($page_id);

		//Search for [upg-edit pages, and delete that. 
		$page_id = $wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[upg-edit]%'");
		wp_delete_post($page_id);

		//Search for [upg-form pages, and delete that. 
		$page_id = $wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[/upg-form]%'");
		wp_delete_post($page_id);
	}
}
