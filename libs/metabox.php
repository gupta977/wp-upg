<?php
//Add meta boxes admin
function upg_meta_boxes()
{
	$prefix = 'upg_';
	$post_type_selected = upg_get_option('after_content_post', 'upg_general', '');
	$meta_boxes = array(
		'post_img' => array('id' => $prefix . 'image', 'title' => 'UPG ' .  __('Media', 'wp-upg'), 'callback' => 'upg_meta_box_image', 'screen' => 'upg', 'position' => 'advanced', 'priority' => 'high'),

		'upg-layout' => array('title' => 'UPG ' . __('Preview template', "wp-upg"), 'callback' => 'upg_meta_box_layout', 'screen' => 'upg', 'position' => 'side', 'priority' => 'core'),

		'upg-extra-fields' => array('title' => 'UPG ' . __('Extra Form Fields', "wp-upg"), 'callback' => 'upg_meta_box_extra_field', 'screen' => 'upg', 'position' => 'side', 'priority' => 'core'),
		'upg-settings' => array('title' => 'UPG ' . __('Settings', "wp-upg"), 'callback' => 'upg_meta_box_settings', 'screen' => $post_type_selected, 'position' => 'side', 'priority' => 'core'),
	);




	$meta_boxes = apply_filters("upg_meta_box", $meta_boxes);
	foreach ($meta_boxes as $id => $meta_box) {
		extract($meta_box);
		add_meta_box($id, $title, $callback, $screen, $position, $priority);
	}
}

//Options to remove after content
function upg_meta_box_settings($post)
{
	global $post;
	$all_upg_fields = get_post_custom($post->ID);

	if (isset($all_upg_fields["upg_hide_after_content"][0]))
		$upg_hide_after_content = "hide";
	else
		$upg_hide_after_content = "";

	if ($upg_hide_after_content == 'hide')
		$checked = 'checked=checked';
	else
		$checked = "";
	wp_nonce_field('nonce_action', 'nonce_name');
	$html = __('Remove "After content" for this post.', 'wp-upg');
	$html .= '<p>Yes: <input type="checkbox" name="upg_hide_after_content" ' . $checked . ' value="hide" >';
	echo $html;
}

//Preview Layout List meta box
function upg_meta_box_layout()
{
	global $post;
	$all_upg_fields = get_post_custom($post->ID);
	if (isset($all_upg_fields["upg_layout"][0]))
		$upg_layout = $all_upg_fields["upg_layout"][0];
	else
		$upg_layout = "basic";

	$dir    = upg_BASE_DIR . 'layout/media/';
	$filelist = "";
	$files = array_map("htmlspecialchars", scandir($dir));

	foreach ($files as $file) {
		if ($upg_layout == $file)
			$checked = 'checked=checked';
		else
			$checked = "";

		if (!strpos($file, '.') && $file != "." && $file != "..")
			$filelist .= sprintf('<input type="radio" ' . $checked . ' name="upg_layout" value="%s"/>%s layout<br>' . PHP_EOL, $file, $file);
	}
	echo $filelist;
}
function upg_meta_box_extra_field($post)
{
	$all_upg_extra = get_post_custom($post->ID);
	$options = get_option('upg_settings');


	//Display 5 custom fields loop
	for ($x = 1; $x <= 5; $x++) {
		if (isset($all_upg_extra["upg_custom_field_" . $x][0]))
			$upg_custom_field[$x] = $all_upg_extra["upg_custom_field_" . $x][0];
		else
			$upg_custom_field[$x] = "";
		if ($options['upg_custom_field_' . $x . '_show'] == 'on') {
			if ($options['upg_custom_field_type_' . $x] == 'checkbox') {
				?>
				<?php echo $options['upg_custom_field_' . $x]; ?>:
				<input type="checkbox" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo 'upg_custom_field_' . $x . '_checked'; ?>" <?php if (!empty($upg_custom_field[$x]) && $upg_custom_field[$x] == $upg_custom_field[$x])
																																									echo 'checked';	?>>
				<hr>
			<?php
						} else {
							?>

				<?php echo $options['upg_custom_field_' . $x]; ?><br> <input type="text" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo $upg_custom_field[$x]; ?>"><br><br>

	<?php
				}
			}
		}
	}

	//Save data typed in post type
	function upg_save_meta_data($post_id, $post)
	{


		if (!isset($_POST['nonce_name'])) //make sure our custom value is being sent
			return;
		if (!wp_verify_nonce($_POST['nonce_name'], 'nonce_action')) //verify intent
			return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) //no auto saving
			return;
		if (!current_user_can('edit_post', $post_id)) //verify permissions
			return;

		if (isset($_POST['meta-box-media'])) {
			if ($_POST['meta-box-media'] != "pic_name") {
				$new_value = array_map('intval', $_POST['meta-box-media']); //sanitize


				foreach ($new_value as $k => $v) {

					if ($v != '0')
						update_post_meta($post_id, $k, $v); //save
					//$_SESSION["favcolor"] .= "green_".$v."<hr>";
				}
			}
		}
		if (isset($_POST["upg_layout"]))
			update_post_meta($post->ID, "upg_layout", $_POST["upg_layout"]);

		if (isset($_POST["youtube_url"]))
			update_post_meta($post->ID, "youtube_url", sanitize_text_field($_POST["youtube_url"]));

		if (isset($_POST["upg_hide_after_content"]))
			update_post_meta($post->ID, "upg_hide_after_content", $_POST["upg_hide_after_content"]);


		for ($x = 1; $x <= 5; $x++) {
			if (isset($_POST["upg_custom_field_" . $x])) {
				update_post_meta($post->ID, "upg_custom_field_" . $x, sanitize_text_field($_POST["upg_custom_field_" . $x]));
			} else {
				update_post_meta($post->ID, "upg_custom_field_" . $x, '');
			}
		}
	}

	//Image upload in post type
	function upg_meta_box_image($post)
	{
		$all_upg_extra = get_post_custom($post->ID);
		//print_r($all_upg_extra);
		if (isset($all_upg_extra["form_attach"][0])) {
			if ($all_upg_extra["form_attach"][0] == '0') {
				echo __("Attached at: ", "wp-upg");
				echo __("Primary Gallery", "wp-upg");
			} else {
				echo __("Attached at: ", "wp-upg");
				echo '<a href="' . get_permalink($all_upg_extra["form_attach"][0]) . '">' . get_the_title($all_upg_extra["form_attach"][0]) . '</a><hr>';
			}
		}


		?>

	<script>
		jQuery(document).ready(function($) {
			$("#tabs").tabs();
		});
	</script>

	<div id="tabs">
		<ul>

			<li><a href="#tab-1"><?php echo __("Upload Image", "wp-upg"); ?></a></li>

			<li><a href="#tab-2"><?php echo __("Embed URL", "wp-upg"); ?></a></li>


		</ul>
		<div id="tab-1">
			<?php include(dirname(__FILE__) . '/admin_post_img.php'); ?>
		</div>
		<div id="tab-2">
			<?php include(dirname(__FILE__) . '/admin_video_url.php'); ?>
		</div>
	</div>

<?php
}

?>