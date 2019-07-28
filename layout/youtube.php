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
	echo "Invalid Youtube URL";
}
else
{
	if (strpos($url, 'vimeo') > 0) 
	{
		echo "<br><a href='".upg_video_preview_url($url)."' border='0' class='vimeo'><img src='".upg_getimg_video_url($url)."'></a>";
	}
	else
	{
	//echo upg_video_preview_url($url);
	echo "<br><a href='".upg_video_preview_url($url)."' border='0' class='youtube'><img src='".upg_getimg_video_url($url)."'></a>";
	}
}


$put=ob_get_clean (); 
return $put;

?>