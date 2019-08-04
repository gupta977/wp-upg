<?php
//List album [upg-album]
$put="";
$term_slug = get_query_var( 'upg_cate' );
$term = get_term_by('slug', $term_slug, 'upg_cate');

if(isset($params['type']))
	$type=trim($params['type']);
else
    $type='';

if(isset($params['class']))
	$class=trim($params['class']);
else
    $class='';


    
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

    if(isset($params['count']) && $params['count']=='true')
	$count=true;
else    
      $count=false;

ob_start ();

echo "Selected category: ".$album_name."<hr>";
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<ul>';
    foreach ( $terms as $term ) 
    {   
        $upg_cate_thumb_id = get_term_meta( $term->term_id, 'category-image-id', true  );
        if($upg_cate_thumb_id)
        {
            $cate_thumb_pic=wp_get_attachment_image_url ( $upg_cate_thumb_id, 'thumbnail' );
        }
        else
        {
            $cate_thumb_pic='x';
        }

        if($count)
        {
            echo '<li>' . $term->name . ' ('.$term->count.')</li>';
        }
        else 
        {
            echo '<li>' . $term->name.' '.$cate_thumb_pic.'</li>';
        }
    }
    echo '</ul>';
}

$put=ob_get_clean (); 
return $put;
?>