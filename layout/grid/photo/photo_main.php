<?php
if($permalink=="0")
			{
			echo '<img src="'.$image_medium.'">';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0><img src="'.$image_medium.'"></a>';
			
			
			}
			else
			{
			echo '<a href="'.$permalink.'" border=0><img src="'.$image_medium.'"></a>';
			}
		}
?>