<?php
//List album [upg-album filter="image/embed" class="css_class_name"]
$put="";
$term_slug = get_query_var( 'upg_cate' );
$term = get_term_by('slug', $term_slug, 'upg_cate');
$perrow = $options['global_perrow'];

if(isset($params['perrow'])&&$params['perrow']>0) $perrow = $params['perrow'];

if(isset($params['filter']))
	$type=trim($params['filter']);
else
    $type='';

if(isset($params['class']))
	$class=trim($params['class']);
else
    $class='upg_album_container';


    
    if($term_slug!="")
    {
       $album_name=$term->name;
       $term_id=$term->term_id;
    }
    else
    { 
        $album_name="";
        $term_id=0;
    }

    $root='show'; //Default to show album at beginning
    

    if(isset($params['root']) && $params['root']=='hide' && $album_name=="")
    {
        $root='hide';
    }
    else
    {
        $root='show';
    }
    
    //Hide hidden category
    $skip=array();
    $skip=upg_hidden_category($type);
    
     
    $args = array(
        'orderby'      => 'name', 
        'order' => 'ASC',
        'hide_empty'   => 0, 
        'exclude'            => $skip,
        'parent' =>$term_id,
        
      );
    
    $terms = get_terms( 'upg_cate', $args );

    if(isset($params['count']) && $params['count']=='show')
    {
    $count=true;
    
    }
    else 
    {   
      $count=false;
    }
ob_start ();
?>
<style>

div.wrapper1{
	float:left; /* important */
	position:relative; /* important(so we can absolutely position the description div */
}
div.description{
	position:absolute; /* absolute position (so we can position it where we want)*/
	bottom:0px; /* position will be on bottom */
	left:0px;
	width:100%;
	/* styling bellow */
	background-color:black;
	color:white;
	opacity:0.6; /* transparency */
	filter:alpha(opacity=60); /* IE transparency */
}
p.description_content{
	padding:10px;
	margin:0px;
	font-size: 30px;
}

</style>

<?php

if($root=='show')
    {
//echo "Selected category: ".$album_name."<hr>";
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<div class="pure-g">';
    foreach ( $terms as $term ) 
    {   
        $upg_cate_thumb_id = get_term_meta( $term->term_id, 'category-image-id', true  );
        if($upg_cate_thumb_id)
        {
            $cate_thumb_pic=wp_get_attachment_image_url ( $upg_cate_thumb_id, 'thumbnail' );
        }
        else
        {
            $cate_thumb_pic=plugins_url( '../images/pattern.png', __FILE__ );
        }

       
            $count_result = upg_get_listings_count_by_category( $term->term_id, true );
          

              
                echo '
                <div class="pure-u-1 pure-u-md-1-'.$perrow.'">
                '.($count?'<div class="upg_badge" style="position: absolute;z-index:1;">'.$count_result.'</div>':'').'
                <div class="'.$class.'"> 
                <a href="' .upg_get_category_page_link( $term, 'upg_cate' ) . '"> 
                    <img src="'.$cate_thumb_pic.'"/> 
                    <!-- description div -->
                    
	                    <div class="'.$class.'_levelA">
                            <!-- description content -->
                            
                            <p class="'.$class.'_levelB">'.$term->name.'</p>
                            
		                    <!-- end description content -->
	                    </div> 
                    <!-- end description div -->
                    </a>
                   
                </div>
               
                </div>
                ';
                /*
                echo '
                <div class="pure-u-1 pure-u-md-1-'.$perrow.'">
                <div class="'.$class.'"> 
                <a href="' .upg_get_category_page_link( $term, 'upg_cate' ) . '"> 
                <img src="'.$cate_thumb_pic.'"/> 
                <div class="'.$class.'_title">' . $term->name.' ('.$count_result.')</div>
                </a>
                </div></div>';
                */
          
    }
    echo '</div>';
}
    }

$put=ob_get_clean (); 
return $put;
?>