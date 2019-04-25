<div class="obox" >
     <div class="body" style="text-align:center" >
	 <div class="upg_text_over_image">
	<?php

	if($popup=="on")
			{
				echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0><img src="'.$image.'"></a>';
			}
			else
			{
	
			echo '<a href="'.$permalink.'" border=0><img src="'.$image.'"></a>';
			}
	
	?>
	 <p><?php echo $notice; ?></p>
	</div>
	</div>
	
	 <div class="footer" style="text-align:center">

	<?php echo $thetitle; ?>
	
	</div>
</div>