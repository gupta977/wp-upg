<style>
/* (item margins = 5) */
.upg_masonry {
  -webkit-column-width: 150px;
  -moz-column-width: 150px;
  column-width: 150px;
  /* same with bottom margin for the items */
  -webkit-column-gap: 5px;
  -moz-column-gap: 5px;
  column-gap: 5px;
}

.upg_masonry img {
  display: block;
  /* expand! */
  width: 100%;
  height: auto;
  background-color: silver;
  /* bottom margin */
  margin: 0 0 5px 0;
}

wp-upg div img:hover { 
  width: 100%; 
  height: auto;
  box-shadow: 0.5px 0.5px 2px 0.5px rgba(0,0,0,0.9);
	cursor: pointer;  
    
}

</style>

<?php
		do_action( "upg_grip_top");
?>

<?php
if($author_show)
if($user!="")
echo upg_author($author)."<br>";
if($show_tag=="on")
echo upg_generate_tags($tags_array,'upg_tags','filter_tag')."<br>";
?>
<div id="upg_gallery">
  <wp-upg>
<div class='upg_masonry'>