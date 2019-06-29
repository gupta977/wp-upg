<div class="pure-u-1 pure-u-md-1-<?php echo $perrow; ?>" id="upg_<?php echo get_the_ID(); ?>">
<section data-tags="<?php echo $tags; ?>">
<div  class="obox">
<div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-5" style="text-align:center;"> 
	
	<?php
	
			if($permalink=="0")
			{
			echo '<img src="'.$image.'" class="pure-img">';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border="0" ><img src="'.$image.'" style="margin:auto;"></a>';
			
			
			}
			else
			{
			echo '<a href="'.$permalink.'" border=0><img src="'.$image.'" ></a>';
			}
		}
		
				?>
				<?php echo upg_show_icon_grid(); ?>
					<?php 
		if($post_status=="draft")
		echo '<div class="upg_tooltip"><i class="fas fa-eye-slash"></i><span class="upg_tooltiptext">'. __("Under review","wp-upg").'</span></div>'; 
	?>
	
	</div>
    <div class="pure-u-1 pure-u-md-4-5 " style="vertical-align: text-top"> 
		<div style="padding: 0.3em;">
		<div class="upg_list_title">
		
		
		<?php
	
			if($permalink=="0")
			{
			echo $thetitle;
			}
		else
		{
			if($popup=="on")
			{
		// It creating dublicate image on lightbox	
		//	echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0>'.$thetitle.'</a>';
		echo $thetitle;
			
			}
			else
			{
			echo '<a href="'.$permalink.'" border=0>'.$thetitle.'</a>';
			}
		}
		
				?>
		
	</div>
		
		<?php 

		echo upg_breakLongText($text, $length = 200, $maxLength = 250);
		?>
		</div>
	</div>
</div>
</div>
	</section>
</div>