<?php
do_action("upg_grip_top");
?>
<style>
	.upg_hover_content {
		position: relative;

	}

	.upg_hover_content .upg_hover_content-overlay {
		background: rgba(0, 0, 0, 0.7);
		position: absolute;
		height: 99%;
		width: 100%;
		left: 0;
		top: 0;
		bottom: 0;
		right: 0;
		opacity: 0;
		-webkit-transition: all 0.4s ease-in-out 0s;
		-moz-transition: all 0.4s ease-in-out 0s;
		transition: all 0.4s ease-in-out 0s;
	}

	.upg_hover_content:hover .upg_hover_content-overlay {
		opacity: 1;
	}

	.upg_hover_content-image {
		width: 100%;
	}

	.upg_hover_content-details {
		position: absolute;
		text-align: center;
		padding-left: 1em;
		padding-right: 1em;
		width: 100%;
		top: 50%;
		left: 50%;
		opacity: 0;
		-webkit-transform: translate(-50%, -50%);
		-moz-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		-webkit-transition: all 0.3s ease-in-out 0s;
		-moz-transition: all 0.3s ease-in-out 0s;
		transition: all 0.3s ease-in-out 0s;
	}

	.upg_hover_content:hover .upg_hover_content-details {
		top: 50%;
		left: 50%;
		opacity: 1;
	}

	.upg_hover_content-details h3 {
		color: #fff;
		font-weight: 500;
		letter-spacing: 0.15em;
		margin-bottom: 0.5em;
		text-transform: uppercase;
	}

	.upg_hover_content-details p {
		color: #fff;
	}

	.upg_hover_fadeIn-bottom {
		top: 80%;
	}

	.upg_hover_fadeIn-top {
		top: 20%;
	}

	.upg_hover_fadeIn-left {
		left: 20%;
	}

	.upg_hover_fadeIn-right {
		left: 80%;
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