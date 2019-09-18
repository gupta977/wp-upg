<?php
do_action("upg_grip_top");
?>
<?php
if ($author_show)
	if ($user != "")
		echo upg_author($author) . "<br>";
if ($show_tag == "on")
	echo upg_generate_tags($tags_array, 'upg_tags', 'filter_tag') . "<br><div style='clear:both;'></div>";
?>
<div id="upg_gallery">
	<div class="pure-g">