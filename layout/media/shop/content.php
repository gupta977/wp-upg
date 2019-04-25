<style>
.upg_product_title{
	font-family: 'Francois One', Tahoma, Verdana, Arial;
	line-height: 1.4em;
	word-wrap: break-word;
	font-size: 1.8em;
	text-decoration: none;
	letter-spacing: 0.05em;
	text-shadow: 2px 4px 3px rgba(0,0,0,0.3);
}
.upg-desp{
	color:#0f0e1b;
	font-size:1.2em;
	
	
}
.upg-profile-name{
	color:#999;
}

.avatar {
border-radius: 50%;
-moz-border-radius: 50%;
-webkit-border-radius: 50%;
}
</style>

	<?php
	
	$mrp=upg_get_value('upg_custom_field_1');
	$sale=upg_get_value('upg_custom_field_2');

	if(is_numeric($mrp) && is_numeric($sale))
	$aftersale=$mrp - ($mrp * ($sale / 100));
else
	$aftersale=0;

	$stock=upg_get_value('upg_custom_field_4');
	
		
			if($sale !='' && intval($sale))
			{
				?>
	<div class="upg_box">
	<div class="upg_ribbon upg_blue"><span><?php echo upg_get_value('upg_custom_field_2'); ?>% Off</span></div>
</div>
<?php
			}
			?>
<div class="pure-g">
	
	 <div class="pure-u-1-1"><?php echo upg_position1(); ?></div>
	
	<div class="pure-u-1 pure-u-md-2-5"> 

	<div class="margin-box" style="text-align:center">

				<div style="width:90%; text-align:center;">
					<span class='upg_zoom' id='<?php echo "ex".$post->ID; ?>'>
					 <img src="<?php echo $image; ?>" class="pure-img">
					</span>
					<p><a href="<?php echo $image; ?>" title="<?php echo $post_title; ?>" class="wp-upg" border=0> <i class="fas fa-search-plus"></i></a></p>
				</div>	 
			
	</div>


	</div>

	
    <div class="pure-u-1 pure-u-md-3-5 "> 
<div style="padding:1em">
	<div class="upg_product_title"><?php echo $post_title; ?></div>
	
	<div class="subProdInfo" style="padding:1em">
	<?php
	
	
	if($stock=='upg_custom_field_4_checked')
		$stock_msg="Available";
	else
		$stock_msg="Not Available";
	
	?>
	
	
			<span class="price"><?php 
			
			if($aftersale==0)
				$asale="$0.00";
			else if($aftersale<0)
				$asale="Free";
			else
				$asale="$".number_format($aftersale);
			
			echo $asale;

			?></span>
			<?php
			if($mrp!=$aftersale)
			{
				?>
			<span class="mrp">$<?php echo number_format($mrp); ?></span>
			<?php
			}
			?>
			<?php 
		if($post_status=="draft")
		echo '<div class="upg_tooltip" ><h1><i class="fas fa-eye-slash"></i></h1><span class="upg_tooltiptext">'. __("Under review","wp-upg").'</span></div>'; 
	?>
			</div>
			
			
	
	<?php do_action( "upg_layout_up"); ?>
	
	<b>Stock</b>: <?php echo $stock_msg; ?><br>
	<b>Delivery</b>: 
	
	<?php 
	if(upg_get_value('upg_custom_field_3')=='upg_custom_field_3_checked')
		echo "Yes in some areas.";
	else
		echo "Collect from store";
	?>
	<br><b>Updated</b>: <?php echo get_post_modified_time('F d, Y g:i a'); ?>
	
	<?php 
	if(upg_get_value('upg_custom_field_5')!='')
	echo "<div style='padding:1em'><pre>".upg_get_value('upg_custom_field_5')."</pre></div>";
?>
	<br>
	<?php do_action( "upg_layout_down"); ?>
	<?php echo upg_position2(); ?>
<?php 
if (function_exists('um_fetch_user'))
{
 um_fetch_user($author->ID);


?>

<ul id="upg_people" style="padding:1em">
	<li>
    <a href="<?php echo um_user_profile_url(); ?>" title="<?php echo um_user('display_name'); ?>"><?php echo get_avatar( $author->ID, $size = '50'); ?></a>
		<h2><?php echo um_user('display_name'); ?></h2>
		<span class="info">
			<em><i class="fas fa-phone"></i> <?php echo um_user('mobile_number'); ?></em>
			<em><?php echo um_user('country'); ?></em>
			<em><div class="upg_badge"><?php echo um_user('role'); ?></div></em>
		</span>
	</li>
	
</ul>
<?php
}
?>


	</div>
	</div>

<div class="pure-u-1"><div class="upg-desp"> 	<?php echo $text; ?> </div> </div>


<div class="pure-u-1"><p><?php upg_list_tags($post); ?></p> </div>
	
</div>	
<style>
		/* styles unrelated to zoom */
		* { border:0; margin:0; padding:0; }
		

		/* these styles are for the demo, but are not required for the plugin */
		.upg_zoom {
			display:inline-block;
			position: relative;
		}
		
		/* magnifying glass icon */
		.upg_zoom:after {
			content:'';
			display:block; 
			width:33px; 
			height:33px; 
			position:absolute; 
			top:0;
			right:0;
			background:url(icon.png);
		}

		.upg_zoom img {
			display: block;
		}

		.upg_zoom img::selection { background-color: transparent; }

	</style>
	<style>
	#upg_people {
  position: relative;
  margin: 10px auto;
  padding: 0;
  font-family: "Helvetica Neue", Helvetica, sans-serif;
  font-size: 16px;
  line-height: 22px;
  color: #3b3b3b;
  -webkit-font-smoothing: antialiased;
  list-style-type: none;
}
#upg_people li {
  position: relative;
  margin: 0 0 40px 0;
  padding: 10px 8px 8px 54px;
  height: 75px;
  border: 1px solid #bbbbbb;
  border-radius: 4px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), inset 0 1px 0 #ffffff;
  background: #f6f6f6;
}
#upg_people li img {
  position: absolute;
  top: -16px;
  left: -16px;
  z-index: 10;
  margin: 0;
  padding: 4px;
  width: 50px;
  height: 50px;
  border: 1px solid #bbbbbb;
  box-shadow: 0 1px 0 #ffffff;
  border-radius: 50%;
  background: #ffffff;
}
#upg_people li h2 {
  margin: 0;
  font-size: 18px;
  line-height: 22px;
  font-weight: 400;
  color: #4b4b4b;
  text-shadow: -1px -1px 0 rgba(255, 255, 255, 0.7);
}
#upg_people li .info {
  margin: 0;
  display: block;
}
#upg_people li .info em {
  margin: 0 18px 0 0;
  font-size: 11px;
  line-height: 20px;
  font-weight: 400;
  font-style: normal;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: #5b5b5b;
  float: left;
}

	</style>
	<style>
	.subProdInfo{
			margin-bottom: 1px;
			font-weight: normal;
			display: flex;
			align-items: center;
	}
			.subProdInfo .price{
				font-size: 42px;
				margin-right: 20px;
				color: blue;
			}
						
			.subProdInfo .mrp{
				font-size: 22px;
				margin-right: 20px;
				text-decoration: line-through;
			}
		
	</style>
	
	<style>
	.onsale-section {
  position: absolute;
  top: -6px;
  right: 15px;
}

.onsale-section:after {
  position: absolute;
  content: '';
  display: block;
  width: 0;
  height: 0;
  border-left: 50px solid transparent;
  border-right: 50px solid transparent;
  border-top: 6px solid #6ec5d5;
}

.onsale {
  position: relative;
  display: inline-block;
  text-align: center;
  color: #fff;
  background: #6ec5d5;
  font-size: 14px;
  line-height: 1;
  padding: 12px 8px 6px;
  border-top-right-radius: 8px;
  width: 84px;
  text-transform: uppercase
}

.onsale:before,
.onsale:after {
  position: absolute;
  content: '';
  display: block;
}

.onsale:before {
  background: #6ec5d5;
  height: 7px;
  width: 6px;
  left: -6px;
  top: 0;
}

.onsale:after {
  background: #96a0a2;
  height: 7px;
  width: 8px;
  border-radius: 8px 8px 0 0;
  left: -8px;
  top: 0;
}

.product img {
  display: block;
}
	</style>

	
<script>
jQuery(document).ready(function($) 
{
	$('<?php echo "#ex".$post->ID; ?>').zoom();
});
</script>	