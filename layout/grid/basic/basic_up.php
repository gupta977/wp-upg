<style>
	upg_figcaption {
		display: none;
	}
</style>
<style>
	/* Increase space around image */
	.fancybox-slide--image {
		padding: 50px;
	}

	/* Add shadow around image, but hide it while zooming */
	.fancybox-image {
		box-shadow: rgba(0, 0, 0, 0.8) 0px 5px 25px;
		transition: box-shadow .2s;
	}

	.fancybox-is-scaling .fancybox-image {
		box-shadow: none;
	}

	/* Hide elements while zooming or when zoomed-in */
	.fancybox-is-scaling .fancybox-item,
	.fancybox-can-pan .fancybox-item {
		display: none !important;
	}

	/* Style close button */
	.fancybox-close {
		position: absolute;
		top: -18px;
		right: -18px;
		width: 36px;
		height: 36px;
		background-image: url(https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/images/fancybox/fancybox_sprite.png);
		z-index: 2;
	}

	/* Style navigation elements */
	.fancybox-nav {
		position: absolute;
		top: 0;
		width: 25%;
		height: 100%;
		cursor: pointer;
		text-decoration: none;
		-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	}

	.fancybox-prev {
		left: 0;
	}

	.fancybox-next {
		right: 0;
	}

	.fancybox-nav span {
		position: absolute;
		top: 50%;
		width: 36px;
		height: 34px;
		margin-top: -18px;
		cursor: pointer;
		visibility: hidden;
	}

	.fancybox-prev span,
	.fancybox-next span {
		background-image: url(https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/images/fancybox/fancybox_sprite.png);
	}

	.fancybox-prev span {
		left: 10px;
		background-position: 0 -36px;
	}

	.fancybox-next span {
		right: 10px;
		background-position: 0 -72px;
	}

	.fancybox-nav:hover span {
		visibility: visible;
	}
</style>
<script>
	jQuery(document).ready(function() {
		jQuery('[data-fancybox]').fancybox({
			caption: function(instance, item) {
				return jQuery(this).find('upg_figcaption').html();
			}
		});
	});
</script>
<script>
	jQuery(document).ready(function() {
		jQuery('[data-fancybox]').fancybox({
			toolbar: false,
			smallBtn: false,
			arrows: false,
			idleTime: false,
			loop: true,
			margin: [44, 60],
			transitionEffect: false,
			animationDuration: 333,
			//preventCaptionOverlap : false,
			afterLoad: function(instance, slide) {
				jQuery('<a title="Close" class="fancybox-item fancybox-close" href="javascript:;" data-fancybox-close></a><a title="Previous" class="fancybox-item fancybox-nav fancybox-prev" href="javascript:;" data-fancybox-prev><span></span></a><a title="Next" class="fancybox-item fancybox-nav fancybox-next" href="javascript:;" data-fancybox-next><span></span></a>').appendTo(slide.$content);
			},
			caption: function(instance, item) {
				return jQuery(this).find('upg_figcaption').html();
			}
		});
	});
</script>
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