<div id="upg_<?php echo get_the_ID(); ?>" style="text-align:center;">
<?php

		if($popup=="on")
			{
			
			echo '<div class="upg_image-frame"><a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0><img src="'.upg_image_src('odude-'.$image_size,$post).'"></a></div>';
			}
			else
			{
			echo '<div class="upg_image-frame"><a href="'.$permalink.'" border=0><img src="'.upg_image_src('odude-'.$image_size,$post).'"></a></div>';
			}
		

			?>
  </div>