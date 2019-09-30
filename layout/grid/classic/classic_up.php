<?php
do_action("upg_grip_top");
?>
<style>
  #gallery {
    padding: 10px 0 0 10px;
    background-color: white;
    text-align: center;
    margin: 0 auto;
    border: 2px solid blue;
  }

  .gallery-item {
    width: 150px;
    height: 150px;
    float: left;
    margin: 10px;
    overflow: hidden;
    cursor: pointer;
    border: 10px solid #fff;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0px 0px 3px 2px rgba(0, 0, 0, 0.5);
  }
</style>
<?php
if ($author_show)
  if ($user != "")
    echo upg_author($author) . "<br>";
if ($show_tag == "on")
  echo upg_generate_tags($tags_array, 'upg_tags', 'filter_tag') . "<br><div style='clear:both;'></div>";
?>
<div id="upg_gallery">