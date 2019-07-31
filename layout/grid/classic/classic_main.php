<div class="upg_classic_responsive upg_gallery_child" data-tags="<?php echo $tags; ?>">
  <div class="upg_classic_gallery">
	  
	<?php
	if($post_status=="draft")
		$permalink=0;
	
				
			if($permalink=="0")
			{
			//echo '<img src="'.$image.'" class="pure-img">';
			echo '<div class="upg_image_container"><img src="'.$image.'"> <div class="upg_image_centered">';
			echo '<div class="upg_tooltip"><i class="fas fa-eye-slash fa-2x fa-border"></i><span class="upg_tooltiptext">'. __("Under review","wp-upg").'</span></div>'; 
			echo '</div></div>';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a data-fancybox="'.$preview_type.'" '.$extra_param.' href="'.$preview_large.'" title="'.$thetitle.'" data-caption="'.$thetitle.'" border=0><img src="'.$image.'"></a>';
			
			
			}
			else
			{
			echo '<a href="'.$permalink.'" border="0"><img src="'.$image.'"></a>';
			}
		}
		
		//echo $tags;
				?>
	
  </div>

  </div>