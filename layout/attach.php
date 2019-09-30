<?php
//It attach UPG post only to Wordpress Post. WordPress post only show the images/video submitted on current post.
//
if (is_single() || is_page()) {
	global $post;
	global $wp_query;
	$post_status = array('publish');
	$author_show = false;
	$postsperpage = $options['global_perpage'];
	$show_tag = upg_get_option('gallery_tags', 'upg_gallery', 'off');
	$show_button = "on";
	if (isset($options['button_check_capability']) && $options['button_check_capability'] == "1") $show_button = "off";
	if (isset($params['button'])) $show_button = $params['button'];


	if (isset($params['form_layout']))
		$form_layout  = $params['form_layout'];
	else
		$form_layout = upg_get_option('global_form_layout', 'upg_form', 'simple');

	if (isset($params['popup']))
		$popup  = $params['popup'];
	else
		$popup = upg_get_option('global_popup', 'upg_preview', 'on');


	if (isset($params['preview']))
		$preview_layout = $params['preview'];
	else
		$preview_layout = upg_get_option('global_media_layout', 'upg_preview', 'basic');

	if (isset($params['type']))
		$type = $params['type'];
	else
		$type = 'image';

	if (isset($params['list_name']))
		$list_name = $params['list_name'];
	else
		$list_name = "";

	if (isset($params['private']) && $params['private'] == 'false')
		$media_private = "false";
	else
		$media_private = "true";

	$perrow = $options['global_perrow'];
	if (isset($params['perrow']) && $params['perrow'] > 0) $perrow = $params['perrow'];

	$args = array(
		'post_type' => 'upg',
		'post_status' => $post_status,
		'posts_per_page' => $postsperpage,
		'meta_query'     => array(
			array(
				'key'     => 'form_attach',
				'value'   => get_the_ID(),
			),
		),
	);

	$query = new WP_Query($args);
	if ($query->have_posts())
		$count = 1;
	else
		$count = 0;

	//Get the tags only 
	$tags_array = array();
	while ($query->have_posts()) : $query->the_post();
		foreach (wp_get_post_terms($post->ID, 'upg_tag') as $t)
			$tags_array[$t->slug] = $t->name; // this adds to the array in the form ['slug']=>'name'
	endwhile;
	// de-dupe
	$tags_array = array_unique($tags_array);
	natcasesort($tags_array);
	//print_r($tags_array);
	wp_reset_query();
	//	echo get_the_ID();		
	$put = "";

	if (isset($params['gallery_layout']))
		$gallery_layout = $params['gallery_layout'];
	else
		$gallery_layout = upg_get_option('global_layout', 'upg_gallery', 'flat');



	ob_start();

	if (file_exists(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . $gallery_layout . "_config.php"))
		include(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . $gallery_layout . "_config.php");



	if ($gallery_layout == "personal") {
		if (file_exists(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . get_current_blog_id() . "_" . $gallery_layout . "_up.php")) {
			include(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . get_current_blog_id() . "_" . $gallery_layout . "_up.php");
		} else {
			echo "Updating personal grid file. Refresh page.<br>";
			//create this file
			upg_auto_create_file('personal', 'grid', 'personal_up');
			//create pick file too
			upg_auto_create_file('personal', 'grid', 'personal_pick');
		}
	} else {
		if (file_exists(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . $gallery_layout . "_up.php"))
			include(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . $gallery_layout . "_up.php");
		else
			echo __('Layout Not Found. Check settings.', 'wp-upg') . ": " . $gallery_layout;
	}

	//The main container loop area
	?>
	<div id="upg_main_loop" style="width:100%"></div>
	<div id='upg_loader' style='display: none;text-align:center;' class="pure-u-1-1">
		<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
		<br>
		<?php echo __("Uploading", "wp-upg"); ?>
		<div class="upg_progress-bar">
			<span id="upg_progress" class="upg_progress-bar-load" style="width: 0%;text-align: center;"></span>
		</div>
		<br>
		<?php echo __("Processing", "wp-upg"); ?>
		<div class="upg_progress-bar">
			<span id="upg_progress_process" class="upg_progress-bar-process" style="width: 0%;text-align: center;"></span>
		</div>

	</div>

	<?php
		if ($gallery_layout == "personal") {
			if (file_exists(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . get_current_blog_id() . "_" . $gallery_layout . "_down.php")) {
				include(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . get_current_blog_id() . "_" . $gallery_layout . "_down.php");
			} else {
				upg_auto_create_file('personal', 'grid', 'personal_down');
				upg_auto_create_file('personal', 'grid', 'personal_main');
			}
		} else {


			if (file_exists(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . $gallery_layout . "_down.php"))
				include(upg_BASE_DIR . "/layout/grid/" . $gallery_layout . "/" . $gallery_layout . "_down.php");
		}

		//if condition not required as ajax in clicking on link as soon as page loaded
		//if (  $query->max_num_pages > 1 )
		echo "<div style='clear:both;'></div>";
		echo "<div id='upg_load_more' style='text-align:center'><a id='load_more_link' class='upg_load_more pure-button pure-button-primary' style='margin:5px; font-size: 80%;' href='admin-ajax.php?action=upg_load_more' data-post_id='" . get_the_ID() . "' data-paged='" . $query->max_num_pages . "' data-reset='false' gallery_layout='" . $gallery_layout . "' popup='" . $popup . "'>Load More</a></div>";
		echo "<a id='load_more_reset' class='upg_load_more' style='margin:5px; font-size: 80%;' href='admin-ajax.php?action=upg_load_more' data-post_id='" . get_the_ID() . "' data-paged='" . $query->max_num_pages . "' data-reset='true' gallery_layout='" . $gallery_layout . "' popup='" . $popup . "'></a>";

		?>
	<script>
		//Load first record on page load
		jQuery(document).ready(function() {

			jQuery('#load_more_link').click();
		})
	</script>

<?php
	//Show ajax submission form
	$post_button = "<button id='upg_submit_form' class='pure-button' style='margin:5px; font-size: 80%;'> <i class='fas fa-cloud-upload-alt'></i> " . __('Post', 'wp-upg') . "</button> ";
	if (isset($options['button_check_login']) && $options['button_check_login'] == "1") {
		if (is_user_logged_in()) {
			echo $post_button;
		}
	} else if ($show_button == "off") {
		if (is_user_logged_in() && current_user_can('edit_post', get_the_ID())) {
			echo "<small>";
			echo __("This post button is only visible to you.", "wp-upg");
			echo "</small><br>";
			echo $post_button;
		}
	} else {

		echo $post_button;
	}


	echo "<div style='clear:both;'></div><div id='upg_toggle_form' style='display: none;'>";
	echo do_shortcode('[upg-post type="' . $type . '" layout="' . $form_layout . '" preview="' . $preview_layout . '" private="' . $media_private . '" attach="true" ajax="true"] ');
	echo "</div>";

	$put = ob_get_clean();
	//wp_reset_query();
	return $put;
} else {
	return '';
}
?>