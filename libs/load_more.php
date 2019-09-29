<?php
//Load more content ajax call 
add_action("wp_ajax_upg_load_more", "upg_load_more");
add_action("wp_ajax_nopriv_upg_load_more", "upg_load_more");

function upg_load_more()
{
	global $wp_query;
	global $post;
	$post_id = $_REQUEST["post_id"];
	$paged = $_REQUEST["paged"];
	$layout = $_REQUEST['gallery_layout'];
	$popup = $_REQUEST['popup'];
	//$layout = upg_get_option('global_layout', 'upg_gallery', 'photo');
	//$popup = upg_get_option('global_popup', 'upg_preview', 'on');

	ob_start();
	//$post = get_post( $post_id ); 
	$options = get_option('upg_settings', '');

	// A default response holder, which will have data for sending back to our js file
	$response = array(
		'error' => false,
		'msg' => 'No Message'
	);

	//var_dump($response);

	//Default settings 
	$postsperpage = $options['global_perpage'];
	$perrow = $options['global_perrow'];
	$orderby = $options['global_order'];
	$page = $options['global_page'];



	$post_status = array('publish');
	$author_show = false;


	$args = array(
		'post_type' => 'upg',
		'posts_per_page' => $postsperpage,
		'paged' => $paged,
		'post_status' => $post_status,
		'meta_query'     => array(
			array(
				'key'     => 'form_attach',
				'value'   => $post_id,
			),
		),
	);
	//echo $post_id;

	$query = new WP_Query($args);

	$put = "";


	//var_dump($args);
	//echo "----";

	$count = 0;
	while ($query->have_posts()) : $query->the_post();
		$count++;
		$permalink = get_permalink();
		$thetitle = get_the_title();
		$theauthor = get_the_author();
		$image = upg_image_src('odude-thumb', $post);
		//echo $post_id;
		$image_large = upg_image_src('odude-large', $post);
		$image_medium = upg_image_src('odude-medium', $post);
		$tags = upg_get_taxonony_raw($post->ID, 'upg_tag');
		$post_status = get_post_status();
		$image_size = 'thumb';
		$text = wpautop(stripslashes($post->post_content));
		$text_excerpt = wpautop(stripslashes($post->post_excerpt));

		if (upg_isVideo($post)) {
			$nonce = wp_create_nonce("upg_oembed");
			$oembed_url = upg_video_preview_url(upg_isVideo($post), $post);
			$extra_param = "";
			$preview_type = '';

			if (strpos($oembed_url, 'vimeo') > 0) {
				$preview_large = $oembed_url;
			} else if (strpos($oembed_url, 'yout') > 0) {

				$preview_large = $oembed_url;
			} else if (strpos($oembed_url, 'facebook') > 0) {

				$preview_large = admin_url('admin-ajax.php?action=upg_oembed&oembed_url=' . $oembed_url . '&nonce=' . $nonce);

				$extra_param = 'data-type="iframe"';
			} else {
				$preview_large = admin_url('admin-ajax.php?action=upg_oembed&oembed_url=' . $oembed_url . '&nonce=' . $nonce);
				$extra_param = 'data-type="ajax"';
			}
		} else {
			$preview_large = $image_large;
			$preview_type = 'images';
			$extra_param = "";
		}


		if ($layout == "personal") {
			if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_main.php")) {

				include(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_main.php");
			}
		} else {
			if (file_exists(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_main.php"))
				include(upg_BASE_DIR . "/layout/grid/" . $layout . "/" . $layout . "_main.php");
		}


	endwhile;

	$put = ob_get_clean();
	//$response['msg'] = "hii";
	$response['msg'] = $put;

	$result = json_encode($response);
	echo $result;
	wp_reset_query();
	die();
}
