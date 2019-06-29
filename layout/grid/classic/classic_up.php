<style>
div.upg_classic_gallery {
  border: 1px solid #ccc;
  margin: 2px;
}

div.upg_classic_gallery:hover {
  border: 1px solid #777;
}

div.upg_classic_gallery img {
  width: 100%;
  height: auto;
   margin: 0px;
}

div.upg_classic_desc {
  padding: 15px;
  text-align: center;
}

* {
  box-sizing: border-box;
}

.upg_classic_responsive {
  padding: 0 6px;
  float: left;
  width: 24.99999%;
}

@media only screen and (max-width: 700px) {
  .upg_classic_responsive {
    width: 49.99999%;
    margin: 6px 0;
  }
}

@media only screen and (max-width: 500px) {
  .upg_classic_responsive {
    width: 100%;
  }
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}
</style>

<?php
		do_action( "upg_grip_top");
?>

<?php
if($author_show)
if($user!="")
echo upg_author($author)."<br>";

//var_dump($tags_array);
if(isset($params['tags']) && $params['tags']=="on")
echo upg_generate_tags($tags_array,'upg_tags','filter_tag')."<br>";
?>

 <div class="upg_classic_wrap">
 <div class="jquery-script-clear"></div>

 <div id="upg_gallery">