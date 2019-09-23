<?php
do_action("upg_grip_top");
?>
<style>
	.upg_list_title {
		word-wrap: break-word;
		font-size: 1.5em;
		text-decoration: none;
		letter-spacing: 0.05em;
		text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3);
	}
</style>
<?php
if ($author_show)
	if ($user != "")
		echo upg_author($author) . "<br>";
if ($show_tag == "on")
	echo upg_generate_tags($tags_array, 'upg_tags', 'filter_tag') . "<br><div style='clear:both;'></div>";
?>
<div id="upg_gallery">
	<div class="pure-g">