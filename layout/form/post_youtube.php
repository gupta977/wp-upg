<?php
//[upg-post] include file for youtube
global $post;
$options = get_option('upg_settings');


if (isset($options['editor']) && $options['editor'] == '1')
	$editor = true;
else
	$editor = false;


$title = '';

$abc = "";
ob_start();
if (isset($_POST['user-submitted-title'], $_POST['upg-nonce']) && !empty($_POST['user-submitted-url']) && wp_verify_nonce($_POST['upg-nonce'], 'upg-nonce')) {
	$title = sanitize_text_field($_POST['user-submitted-title']);
	$url = sanitize_text_field($_POST['user-submitted-url']);
}
if ($title == '') {


	if (isset($params['layout']))
		$layout = trim($params['layout']);
	else
		$layout = upg_get_option('global_form_layout', 'upg_form', 'basic');


	if ($layout == "personal") {
		$inc_file = upg_BASE_DIR . "/layout/form/" . $layout . "/" . get_current_blog_id() . "_" . $layout . "_post_youtube.php";

		if (file_exists($inc_file)) {
			if (strpos(file_get_contents($inc_file), '[upg-form') !== false) {

				$file_shortcode = file_get_contents($inc_file, true);
				echo do_shortcode($file_shortcode);
			} else {
				include($inc_file);
			}
		} else {
			echo __('Refresh Page', 'wp-upg') . ": " . $layout;
			upg_auto_create_file('personal', 'form', 'personal_post_youtube');
		}
	} else {
		$inc_file = upg_BASE_DIR . "/layout/form/" . $layout . "/" . $layout . "_post_youtube.php";
		if (file_exists($inc_file)) {
			if (strpos(file_get_contents($inc_file), '[upg-form') !== false) {

				$file_shortcode = file_get_contents($inc_file, true);
				echo do_shortcode($file_shortcode);
			} else {
				include($inc_file);
			}
		} else {
			echo __('Layout Not Found. Check settings.', 'wp-upg') . ": " . $layout;
		}
	}
} else {
	$author = '';;
	$email = '';
	$tags = '';
	$captcha = '';
	$verify = '';
	$content = '';
	$category = '';


	if (isset($_POST['user-submitted-content']))  $content  = upg_sanitize_content($_POST['user-submitted-content']);
	if (isset($_POST['cat'])) $category = intval($_POST['cat']);
	if (isset($_POST['tags'])) $tags = $_POST['tags'];


	$content = str_replace("[", "[[", $content);
	$content = str_replace("]", "]]", $content);


	$result = upg_submit_url($title, $url, $content, $category, $preview, 'upg', 'upg_cate', $tags, 'upg_tag');

	//var_dump($result);

	if (isset($result['error'][1]['id'])) {
		//echo "it is set";
		$result = array('id' => false, 'error' => false);
		$result['error'][] = "";
	}

	$post_id = false;
	if (isset($result['id'])) $post_id = $result['id'];

	//print_r($result);
	$error = false;

	if (isset($result['error']))
		$error = array_filter(array_unique($result['error']));





	if ($post_id) {
		//Submit extra fields data
		for ($x = 1; $x <= 10; $x++) {
			if (isset($_POST['upg_custom_field_' . $x]))
				add_post_meta($post_id, 'upg_custom_field_' . $x, $_POST['upg_custom_field_' . $x]);
		}


		$post   = get_post($post_id);
		//Email Notification 
		do_action("upg_submit_complete");

		if (upg_get_option('publish', 'upg_form', 'on') == 'on') {

			echo "<h2>" . __('Successfully posted.', 'wp-upg') . "</h2>";
			echo "<br><br><a href='" . esc_url(get_permalink($post_id)) . "' class=\"pure-button\">Click here to view</a><br><br>";
		} else {

			echo "<h2>" . __('Your video is under review', 'wp-upg') . "</h2>";
		}


		//echo "<h1 class=\"archive-title\">".$post->post_title."</h1>";
		//echo "<img src='$image'>";
	} else {

		if ($error) {
			$e = implode(',', $error);
			$e = trim($e, ',');
		} else {
			$e = 'issues';
		}

		echo "<h1>$e</h1>";
	}

	?>

	<?php
	}
	$abc = ob_get_clean();
	return $abc;

	?>