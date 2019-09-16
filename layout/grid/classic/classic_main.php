<li class="upg_list_cards__item upg_gallery_child" id="upg_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
    <div class="upg_list_card">

	<?php
	if($post_status=="draft")
		$permalink=0;
	
				
			if($permalink=="0")
			{
			//echo '<img src="'.$image.'" class="pure-img">';
			echo '<a href="'.$permalink.'" border="0"><div class="upg_list_card__image" style="background-image: url('.$image.');"></div><span class="upg_tooltiptext">'. __("Under review","wp-upg").'</span></a>';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a data-fancybox="'.$preview_type.'" '.$extra_param.' href="'.$preview_large.'" data-caption="'.$thetitle.'" title="'.$thetitle.'" border=0><div class="upg_list_card__image" style="background-image: url('.$image.');"></div></a>';
			}
			else
			{
			echo '<a href="'.$permalink.'" border="0"><div class="upg_list_card__image" style="background-image: url('.$image.');"></div></a>';
			}
		}
		
				?>

      <div class="upg_list_card__content">
        <div class="upg_list_card__title"><?php echo $thetitle; ?></div>
        <p class="upg_list_card__text">
		<?php echo upg_breakLongText($text, $length = 200, $maxLength = 250); ?>
		<div style="width:240px"></div>
		</p>
        <?php echo upg_show_icon_grid(); ?>
      </div>
    </div>
  </li>