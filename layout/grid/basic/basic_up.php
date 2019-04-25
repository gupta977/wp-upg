<style>
.obox {
  border: 1px solid #ddd;
  padding: 10px 12px;
  margin-bottom: 15px;
  background: #fff;
  border-radius: 3px;
  overflow: hidden;
  margin: 0px 5px 5px 0px;
}
.obox:hover {
  border: 1px solid #5890FF;
  padding: 10px 12px;
  margin-bottom: 15px;
  background: #fff;
  border-radius: 3px;
  overflow: hidden;
  margin: 0px 5px 5px 0px;
}
.obox.blue {
  border: 1px solid #5890FF;
}
.obox .header {
  position: relative;
  color: #9197a3;
  font-size: 12px;
  line-height: 1.38;
  padding-bottom: 8px;
  margin-bottom: 8px;
  border-bottom: 1px solid #ddd;
}
.obox .header a {
  font-weight: bold;
}
.obox .header .date {
  position: absolute;
  right: 0;
  top: 0;
}
.obox .links {
  margin-top: 8px;
  font-size: 12px;
  line-height: 1.38;
}
.obox .links a {
  color: #5890FF;
  text-decoration: none;
}
.obox .links a:hover {
  text-decoration: underline;
}
.obox .footer {
  color: #444;
  font-size: 12px;
  line-height: 1.38;
  border-top: 1px solid #ddd;
  background: #F6F7F8;
  padding: 5px 12px;
  margin: 8px -12px -10px -12px;
}
</style>

<?php
		do_action( "upg_grip_top");
?>

<?php
if($author_show)
if($user!="")
echo upg_author($author)."<br>";

?>
<div class="pure-g">