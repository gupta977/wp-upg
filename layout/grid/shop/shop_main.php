<?php
	$mrp=upg_get_value('upg_custom_field_1');
	$sale=upg_get_value('upg_custom_field_2');

	if(is_numeric($mrp) && is_numeric($sale))
		$aftersale=$mrp - ($mrp * ($sale / 100));
	else
		$aftersale=0;


	
	if($aftersale==0)
		$aftersale="$0.00";
	else if($aftersale<0)
		$aftersale="Free";
	else
		$aftersale="$".number_format($aftersale);
	
	if($post_status=="draft")
		$permalink=0;
	
?>
<div class="pure-u-1 pure-u-md-1-<?php echo $perrow; ?>" id="upg_<?php echo get_the_ID(); ?>">
      <div class="obox upg_box">
	 <?php
	 if($sale !='' && intval($sale))
			{
				?>
	 <div class="upg_ribbon upg_blue"><span><?php echo upg_get_value('upg_custom_field_2'); ?>% Off</span></div>
	 <?php
			}
			?>
     <div class="body" style="text-align:center" >
	
	
	<?php
	
			if($permalink=="0")
			{
			echo '<div class="upg_image_container"><img src="'.$image.'"> <div class="upg_image_centered">';
			echo '<div class="upg_tooltip"><i class="fas fa-eye-slash fa-2x fa-border"></i><span class="upg_tooltiptext">'. __("Under review","wp-upg").'</span></div>'; 
			echo '</div></div>';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0><img src="'.$image.'" style="margin:auto;"></a>';
			
			
			}
			else
			{
			echo '<a href="'.$permalink.'" border=0><img src="'.$image.'" style="margin:auto;"></a>';
			}
		}
		
				?>
				
<?php echo upg_show_icon_grid(); ?>
	
	<b><?php echo $aftersale; ?></b>
	</div>
   
    <div class="footer" style="text-align:center">

	<?php echo $thetitle; ?>
	
	</div>
  </div>
  
  </div>