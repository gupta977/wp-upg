<div class="pure-g">
<div class="pure-u-1 pure-u-md-1-2" id="upg_<?php echo get_the_ID(); ?>">

     <div class="obox upg_box">
 <div class="upg_ribbon upg_blue"><span><?php echo $notice; ?></span></div>
     <div class="body" style="text-align:center" >
	 	 
	
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
				
	 <?php echo upg_show_icon_grid(); ?>
	 </div>
   
    <div class="footer" style="text-align:center">

	<?php echo $thetitle; ?>
	
	</div>
  </div>
  
  </div>

</div>