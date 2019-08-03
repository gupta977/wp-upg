<style>
figure {
  display: block;
  position: relative;
  float: left;
  overflow: hidden;
  margin: 0 20px 20px 0;
}
figcaption {
  position: absolute;
  background: black;
  background: rgba(0,0,0,0.75);
  color: white;
  padding: 10px 20px;
  opacity: 0;
  -webkit-transition: all 0.6s ease;
  -moz-transition:    all 0.6s ease;
  -o-transition:      all 0.6s ease;
}
figure:hover figcaption {
  opacity: 1;
}


.cap-left figcaption { top: 0; left: -30%; }
.cap-left:hover figcaption { left: 0; }


.cap-right figcaption { bottom: 0; right: -30%; }
.cap-right:hover figcaption { right: 0; }


.cap-top figcaption { left: 0; top: -30%; }
.cap-top:hover figcaption { top: 0; }

.cap-bot figcaption { left: 0; bottom: -30%;}
.cap-bot:hover figcaption { bottom: 0; }
</style>

<?php
if($author_show)
if($user!="")
echo upg_author($author)."<br>";

?>
<?php
    do_action( "upg_grip_top");
    if($show_tag=="on")
echo upg_generate_tags($tags_array,'upg_tags','filter_tag')."<br><div style='clear:both;'></div>";
?>
<div id="upg_gallery">
<div class="pure-g">