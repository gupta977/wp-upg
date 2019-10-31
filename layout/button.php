<?php
//Display post button at grid page
//add_action( 'upg_grip_top' , 'upg_show_button', 10 , 0 );

function upg_show_button()
{
	$options = get_option('upg_settings', '');
	$album_name = "";

	$term_slug = get_query_var('upg_cate');
	$term = get_term_by('slug', $term_slug, 'upg_cate');

	if ($term_slug != "")
		$album_name = $term->name;

	//echo $album_name;

	//Check if user is logged in
	$grant_access = true;

	if (isset($options['button_check_login'])) {
		if ($options['button_check_login'] == "1") {
			if (is_user_logged_in())
				$grant_access = true;
			else
				$grant_access = false;
		}
	}


	if (isset($options['primary_show_image_button']) && $grant_access) {

		$image_button = $options['primary_show_image_button'];


		//if($options['post_image_page'])
		//{


		$post_7 = get_post(upg_get_option('post_image_page', 'upg_form', '0'), ARRAY_A);
		$page_title = $post_7['post_title'];

		$arg = get_the_title();

		if ($album_name == "") {
			$linku = esc_url(get_permalink(upg_get_option('post_image_page', 'upg_form', '0')));
		} else {
			$linku = esc_url(add_query_arg('album', $arg, get_permalink(upg_get_option('post_image_page', 'upg_form', '0'))));
		}

		if ($image_button == "1")
			echo "<a href='" . $linku . "' class='pure-button' style='font-size: 80%;' id='upg_button' style='margin:5px'>   <i class='fas fa-file-upload'></i> " . $page_title . "</a> ";
		//}


	}

	if (isset($options['primary_show_youtube_button']) && $grant_access) {
		$image_button = $options['primary_show_youtube_button'];
		//if(isset($options['post_youtube_page']))
		//{

		//$linku=esc_url( get_permalink($options['post_youtube_page']) );

		$post_7 = get_post(upg_get_option('post_youtube_page', 'upg_form', '0'), ARRAY_A);
		$page_title = $post_7['post_title'];

		$arg = get_the_title();

		if ($album_name == "") {
			$linku = esc_url(get_permalink(upg_get_option('post_youtube_page', 'upg_form', '0')));
		} else {
			$linku = esc_url(add_query_arg('album', $arg, get_permalink(upg_get_option('post_youtube_page', 'upg_form', '0'))));
		}


		if ($image_button == "1")
			echo "<a href='" . $linku . "' class='pure-button' id='upg_button' style='margin:5px; font-size: 80%;'>   <i class='fa fa-film'></i> " . $page_title . "</a>";
		//}

	}
}

//Displays nothing
function upg_hide_button()
{
	echo "<style>#upg_button { display: none; }</style>";
}
