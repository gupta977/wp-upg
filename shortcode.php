<?php
//Generate shortcode admin page
function upg_shortcode()
{
    ?>
    <div class="wrap">
    <h2>Shortcodes included with UPG</h2>
    <h4>UPG comes with several shortcodes that can be used to insert content inside posts and pages.</h4>

   <script>
    jQuery(document).ready(function($){
        $("#tabs").tabs();
    });
  </script>
  	<div id="tabs">
	<ul>
		
     <li><a href="#tab-1"><?php echo __("[upg-list]","wp-upg");?></a></li>
     <li><a href="#tab-2"><?php echo __("[upg-attach]","wp-upg");?></a></li>
     <li><a href="#tab-3"><?php echo __("[upg-post]","wp-upg");?></a></li>
     <li><a href="#tab-4"><?php echo __("[upg-form]","wp-upg");?></a></li>
	 <li><a href="#tab-5"><?php echo __("[upg-edit]","wp-upg");?></a></li>
     <li><a href="#tab-6"><?php echo __("[upg-pick]","wp-upg");?></a></li>
	       
    </ul>

	 <div id="tab-1">
        <h3>Display Primary Gallery</h3>
        <h4> [upg-list]</h4>
        This will generate gallery of submitted images/video/post. If <code>[upg-list]</code> shortcode is used without parameters,
        the default settings applied at 'UPG settings'. 
        But we can overwrite the settings with parameters into it. 
    <hr>
    <b>Notes:</b>
    <ul>
    <li>Do not use it in post page & widgets, if navigation required.</li>
    <li>You can use it in front page, but page shouldn't be selected as 'main UPG page' in settings.</li>
    <li>Parameters are case sansetive. Write all in lowercase.</li>
    </ul>
   


<h4>Available Attributes:</h4>
The following attributes are available to use in conjunction with the [upg-list] shortcode.
They have been split into sections for primary function for ease of navigation, with examples below.
<br>

<div class="update-nag">
<ul>
    <li> <code>album</code> = "Slug name of album" -  Displays gallery of specific UPG-Post album/category.</li>
    <li> <code>perpage</code> = "No. of total post" -  Number of total post to be displayed per page.</li>
    <li> <code>perrow</code> = "No. of Rows/column" -  Number of post to be displayed per row/horizontally.</li>
    <li> <code>page</code> = "on | off" -  Display page navigation if value is on. Only visible if <code>perpage</code> value is less then the total number of post.</li>
    <li> <code>orderby</code> = "date | title | modified | ID | rand" -  5 different ways the gallery can be sorted.
    <li> <code>layout</code> = "Layout name" -  Each gallery can have their own type of layout. There are several default layouts available (i.e. list, flat , personal, etc.).</li>
    <li> <code>popup</code> = "on | off" -  The post when clicked will have a popup box instead going to another page. (Another page we call it as 'preview page')</li>
    <li> <code>button</code> = "on | off" -  The parameter is used to show a submission button at the gallery page. The submission button selected at UPG settings is displayed. If the shortcode parameter value is off , the buttons are not displayed even if it is set to show at UPG settings.</li>
    <li> <code>author</code> = "on | off" -  The parameter is used to show a author profile avatar at the top of gallery page.</li>
    <li> <code>user</code> = "user's username" -  The parameter is used to show a post gallery submitted by a particular username.<br>
                                                show_mine user is reserved username of UPG.</li>
    <li> <code>login</code> = "true" -  Forces only logged in user can view the gallery.</li>
   
</ul>
<h4>Scenario 1 – I want to display gallery where each column 3, total number of record each page is 6 from album 'fruits'</h4>
<code>[upg-list perrow="3" perpage="6" album="fruits"] </code>

<h4>Scenario 2 – I want only logged in member to view gallery</h4>
<code>[upg-list login="true"]</code>

<h4>Scenario 3 – I want to show gallery of current logged in user</h4>
<code>[upg-list user="show_mine"]</code>

<h4>Scenario 4 – I want to show latest uploded gallery in 'slide' layout with popup enabled.</h4>
<code>[upg-list layout="slide" popup="on" orderby="modified"]</code>
</div>



     </div>
     <div id="tab-2">
     xxxx
     </div>
     <div id="tab-3">
     xxxx
     </div>
     <div id="tab-4">
     xxxx
     </div>
     <div id="tab-5">
     xxxx
     </div>
     <div id="tab-6">
     xxxx
     </div>

    </div>
    <?php
}
?>