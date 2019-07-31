<div id="upg_<?php echo get_the_ID(); ?>" style="text-align:center;">
<?php

		if($popup=="on")
			{
			
			echo '<div class="upg_image-frame"><a data-fancybox="'.$preview_type.'" '.$extra_param.' href="'.$preview_large.'" title="'.$thetitle.'" data-caption="'.$thetitle.'" border=0><img src="'.upg_image_src('odude-'.$image_size,$post).'"></a></div>';
			}
			else
			{
			echo '<div class="upg_image-frame"><a href="'.$permalink.'" border=0><img src="'.upg_image_src('odude-'.$image_size,$post).'"></a></div>';
			}
		

			?>
  </div>