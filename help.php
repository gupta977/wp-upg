<?php
//function upg_help_page()
//{
$title = "";
if (isset($_POST['subject']))
	$title = sanitize_text_field($_POST['subject']);
?>
<div class="wrap">
	<h2>Contact Us</h2>
	<?php
	$user_info = get_userdata(1);

	$email = $user_info->user_email;
	$url = get_site_url();
	$plugin_version = "UPG-" . get_option('upg_plugin_version');


	?>
	<div class="update-nag">
		<b>Common uses:</b><br>
		Gallery for specific page/post: <code>[upg-attach type="image"]</code>or <code>[upg-attach type="embed"]</code><br>
		All post/images from different post will be shown in primary gallery <code>[upg-list]</code>.
		<br>Use <code>[upg-post] & [upg-form]</code> for submission form.<br>
		If you run with 404 error, check UPG settings with specified pages. Do update wordpress permalink manually.
	</div>
	<?php
	echo "<h3>System Check</h3><ul>";

	$file_personal_up = upg_BASE_DIR . "layout/grid/personal/" . get_current_blog_id() . "_personal_up.php";
	if (is_writeable(dirname($file_personal_up))) {
		echo "<li>" . upg_BASE_DIR . "layout/grid/personal/ is writable.</li>";
	} else {
		echo "<li>" . upg_BASE_DIR . "layout/grid/personal/ is <b>not writable</b>. Please [chmod -R 777] or make this folder writable via FTP/cpanel. You cannot use personal layout unless it is corrected.</li>";
	}

	$file_personal_media = upg_BASE_DIR . "layout/media/personal/" . get_current_blog_id() . "_content.php";
	if (is_writeable(dirname($file_personal_media))) {
		echo "<li>" . upg_BASE_DIR . "layout/media/personal/ is writable.</li>";
	} else {
		echo "<li>" . upg_BASE_DIR . "layout/media/personal/ is <b>not writable</b>. Please [chmod -R 777] or make this folder writable via FTP/cpanel. You cannot use personal layout unless it is corrected.</li>";
	}

	$file_personal_form = upg_BASE_DIR . "layout/form/personal/" . get_current_blog_id() . "_personal_post_form.php";
	if (is_writeable(dirname($file_personal_form))) {
		echo "<li>" . upg_BASE_DIR . "layout/form/personal/ is writable.</li>";
	} else {
		echo "<li>" . upg_BASE_DIR . "layout/form/personal/ is <b>not writable</b>. Please [chmod -R 777] or make this folder writable via FTP/cpanel. You cannot use personal layout for form unless it is corrected.</li>";
	}


	$upload_dir = wp_upload_dir();
	$user_dirname_up = $upload_dir['basedir'] . '/upg_grid_personal_up.php';
	if (is_writeable($user_dirname_up)) {
		echo "<li>" . $upload_dir['basedir'] . "/ is writable.</li>";
	} else {
		echo "<li>" . $upload_dir['basedir'] . "/ may be writable</b> but unable to create some files into it. If you get upload-error when posting image, please [chmod -R 777] or make this folder writable via FTP/cpanel.</li>";
	}




	if (function_exists('exif_imagetype')) {
		echo "<li>exif_imagetype is OK</li>";
	} else {
		echo "<li>exif_imagetype is not available in your server. This is important to check file type uploaded by user.</li>";
	}
	?>
	<li><?php echo _e('Maximum upload file size limit:', 'wp-upg') ?> <b><?php //echo ini_get('post_max_size'); 
																			?> <?php echo size_format(wp_max_upload_size()); ?></b></li>
	<?php
	flush_rewrite_rules();
	echo "<li>Permalink structure updated</li>";
	echo "</ul>";

	echo "<h3>Tips</h3><ul>";

	echo '<li><b>To create Frontend Image Upload Page:</b> Create a page and add it to menu. The Content should be <br>for Image <code>[upg-post type="image"]</code> <br> for Youtube, vimeo & others <code>[upg-post type="embed"]</code></li>';

	?>

	<?php

	echo '<li><b>To change layout of form to your personal layout.</b> Eg. <code>[upg-post type="image" preview="personal" layout="personal"]</code></li>';

	echo '<li><b>To post image directly to given media/preview layout,</b> At post form add parameter with the layout name. Eg. <code>[upg-post type="embed" preview="personal"]</code></li>';

	echo "<li>Click <b><a href='http://odude.com/demo/faq/' target='_blank'>this link</a> </b>for more basic installation questions and available features. </li>";
	echo "</ul>";




	?>
	<hr>
	If you have question,suggestion then you can directly contact us at <b>navneet@odude.com </b>
	<br>
	or
	<br>

	Use <b><a href="https://wordpress.org/support/plugin/wp-upg/">support forum</a></b>

	<br>
	<hr>
	Information required for proper support:

	<?php

	echo "<ul><li><b>Email</b>: If UPG-PRO member, use same email ID used during purchase.</li><li><b>URL</b>: $url</li><li><b>Version</b> : $plugin_version</li></ul>";

	?>
</div>
<?php
//}
?>