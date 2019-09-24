<div class="pure-u-1 pure-u-md-1-<?php echo $perrow; ?> upg_gallery_child" id="upg_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
	<div class="obox_basic">
		<div class="pure-g">

			<div class="pure-u-1 pure-u-md-1-5" style="text-align:center;">
				<div class="upg_image-frame">
					<?php

					if ($permalink == "0") {
						echo '<img src="' . $image . '" class="pure-img">';
					} else {
						if ($popup == "on") {

							echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' href="' . $preview_large . '" title="' . $thetitle . '" data-caption="' . $thetitle . '" border="0" ><img src="' . $image . '" style="margin:auto;"></a>';
						} else {
							echo '<a href="' . $permalink . '" border=0><img src="' . $image . '" ></a>';
						}
					}

					if ($post_status == "draft")
						echo '<div class="upg_tooltip"><i class="fas fa-eye-slash"></i><span class="upg_tooltiptext">' . __("Under review", "wp-upg") . '</span></div>';
					?>
				</div>
			</div>
			<div class="pure-u-1 pure-u-md-4-5 upg_hover_content" style="vertical-align: text-top">
				<div style="padding: 0.3em; height: 150px;">
					<div style="height:25%;text-align:center;">

						<div class="upg_list_title">
							<?php

							if ($permalink == "0") {
								echo $thetitle;
							} else {
								if ($popup == "on") {

									echo $thetitle;
								} else {
									echo '<a href="' . $permalink . '" border=0>' . $thetitle . '</a>';
								}
							}

							?>
						</div>
					</div>


					<div style="height:65%;">
						<div style='clear:both;'></div>
						<div class="pure-g">
							<?php
							//Display 5 custom fields loop
							$str = '';
							for ($x = 1; $x <= 5; $x++) {
								if ($options['upg_custom_field_' . $x . '_show_front'] == 'on') {

									if (upg_get_value('upg_custom_field_' . $x) != '') {
										$str .= "<b>" . upg_get_filed_label('upg_custom_field_' . $x) . "</b>: " . upg_get_value('upg_custom_field_' . $x) . "<br>";
									}
								}
							}
							if ($str != '') {
								?>

								<div class="pure-u-1 pure-u-md-2-5"><?php echo $str; ?></div>
								<div class="pure-u-1 pure-u-md-3-5"><?php echo upg_breakLongText($text, $length = 200, $maxLength = 250); ?></div>
							<?php
							} else {
								?>

								<div class="pure-u-1 pure-u-md-1-1"><?php echo upg_breakLongText($text, $length = 200, $maxLength = 250); ?></div>

							<?php
							}
							?>
						</div>

					</div>
					<div style="height:10%;text-align:center"><?php echo upg_show_icon_grid(); ?></div>
				</div>
			</div>
		</div>

	</div>

</div>