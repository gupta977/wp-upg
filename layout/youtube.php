<?php
global $post; 
if(isset($params['url']))
	$url = $params['url'];
else
	$url="";

$put="";
ob_start ();

if($url=="")
{
	echo "Invalid Embed URL";
}
else
{
	if (strpos($url, 'vimeo') > 0) 
	{
		echo "<br><a href='".upg_video_preview_url($url,$post)."' border='0' class='vimeo'><img src='".upg_getimg_video_url($url,$post)."'></a>";
	}
	else
	{
		echo "<br><a href='".upg_video_preview_url($url,$post)."' border='0' class='youtube'><img src='".upg_getimg_video_url($url,$post)."'></a>";
	}
}


$put=ob_get_clean (); 
return $put;

?>