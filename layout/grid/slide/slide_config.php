<?php
$page="off";

//Sets size of the image for sliding
if(isset($params['image_size']) && $params['image_size']=="medium")
    $image_size='medium';
 else if(isset($params['image_size']) && $params['image_size']=="large")
	$image_size='large';
else
    $image_size='thumb';

    if(isset($params['slide_param']))
    {
        $slide_param=$params['slide_param'];
    }
    else {
        $slide_param="autoplaySpeed: 2000,
        autoplay: true,
        speed: 300,
        infinite: true,
        dots: true
        ";
    }
?>