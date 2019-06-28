<section data-tags="<?php echo $tags; ?>">
<div class="upg_classic_responsive">
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
			
			echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0><img src="'.$image.'"></a>';
			
			
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
  </section>