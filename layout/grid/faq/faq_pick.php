<style>
.upg_fixed_height{
   height: 200px;
}

.upg_fixed_height img{
  height:100%;
  width:100%;
  object-fit: cover;
}


</style>
<div class="obox" >
     <div class="body" style="text-align:center" >
	 <div class="upg_text_over_image upg_fixed_height">
	<?php
	
	echo '<a href="'.$permalink.'" border=0><img src="'.$image_large.'"></a>';
	
	?>
	 <?php echo $notice; ?>
	</div>
	</div>
	
	 <div class="footer" style="text-align:center">
	
	<div class="upg_headline"><?php echo $thetitle; ?></div>
	
	</div>
</div>