<?php
		do_action( "upg_grip_top");
?>
<style>
.upg_list_title{
	word-wrap: break-word;
	font-size: 1.1em;
	text-decoration: none;
	letter-spacing: 0.05em;
	text-shadow: 2px 4px 3px rgba(0,0,0,0.3);
}
</style>
<?php
if($author_show)
if($user!="")
echo upg_author($author)."<br>";
if(isset($params['tags']) && $params['tags']=="on")
echo upg_generate_tags($tags_array,'upg_tags','filter_tag')."<br>";
?>
<div id="upg_gallery">
<div class="pure-g">