<li class="upg_list_cards__item upg_gallery_child" id="upg_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
	<div class="upg_list_card">

		<?php
if ("draft" == $post_status) {
    $permalink = 0;
}

if ("0" == $permalink) {
    echo '<div class="upg_image_container"><img src="' . $image_medium . '"> <div class="upg_image_centered">';
    echo '<div class="upg_tooltip"><i class="fas fa-eye-slash fa-2x fa-border"></i><span class="upg_tooltiptext">' . __("Under review", "wp-upg") . '</span></div>';
    echo '</div></div>';
} else {
    if ("on" == $popup) {

        echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' href="' . $preview_large . '" data-caption="' . $thetitle . '" title="' . $thetitle . '" border=0><div class="upg_list_card__image" style="background-image: url(' . $image_medium . ');"></div>';
        echo ' <upg_figcaption><b>' . $thetitle . '</b><br>' . upg_breakLongText($text, $length = 200, $maxLength = 250) . '</upg_figcaption></a>';
    } else {
        echo '<a href="' . $permalink . '" border="0"><div class="upg_list_card__image" style="background-image: url(' . $image_medium . ');"></div></a>';
    }
}

?>

		<div class="upg_list_card__content">
			<div class="upg_list_card__title"><?php echo $thetitle; ?></div>
			<p class="upg_list_card__text">

				<?php
//Display 5 custom fields loop
for ($x = 1; $x <= 5; $x++) {
    if ('on' == $options['upg_custom_field_' . $x . '_show_front']) {
        if (upg_get_value('upg_custom_field_' . $x) != '') {
            ?>
							<?php echo upg_get_filed_label('upg_custom_field_' . $x); ?> : <?php echo upg_get_value('upg_custom_field_' . $x); ?><br>

				<?php
}
    }
}

?>

				<div style="width:240px"></div>
			</p>
			<?php echo upg_show_icon_grid(); ?>
		</div>
	</div>
</li>