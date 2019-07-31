<div class='upg_gallery_child' data-tags="<?php echo $tags; ?>">
<?php
if($permalink=="0")
			{
			echo '<img src="'.$image_medium.'">';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a data-fancybox="'.$preview_type.'" '.$extra_param.' href="'.$preview_large.'" title="'.$thetitle.'" data-caption="'.$thetitle.'" border=0><img src="'.$image_medium.'"></a>';
			
			
			}
			else
			{
			echo '<a href="'.$permalink.'" border=0><img src="'.$image_medium.'"></a>';
			}
		}
?>
</div>