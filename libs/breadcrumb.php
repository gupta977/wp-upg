<?php
//Logic inside breadcrumb
function upg_show_breadcrumb($name,$type,$args = array())
{
    $list = "";
    $home = '-----';
    if ($type && $name)
    {
        $ans = get_term_by('slug', $name, $type);
        if($ans)
        {
        $parentID=$ans->parent;
        while ($parentID > 0)
        {
            $parent = get_term_by('id', $parentID, $type);
            $url = $home."/".$type."/".$parent->slug;
            $list = $args['delimiter']."".$args['before']."<a href='".$url."'>".$parent->name."</a>".$args['after']."".$list;
            $parentID = $parent->parent;
        }
        $url = $home."/".$type."/".$ans->slug;
        $list = $list."".$args['delimiter']."".$args['before']."".$ans->name."".$args['after']."";
    }
    }   
  
    if ($list) echo $args['wrap_before']."".$args['before']."<a href='$home'>Home</a>".$args['after']."".$list."".$args['wrap_after'];
}


//Display breadcrumb
function upg_breadcrumb($args = array())
{
    //echo "1ooo";
    $args = wp_parse_args(
        $args,
        apply_filters(
          'upg_breadcrumb_defaults',
          array(
            'delimiter'   => '&nbsp;&#47;&nbsp;',
            'wrap_before' => '<nav class="upg-breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'wp-upg' ),
          )
        )
      );

      if(is_upg_gallery())
      {
        $term_slug = get_query_var( 'upg_cate' );
        upg_show_breadcrumb($term_slug,"upg_cate",$args);
       // $ans = get_term_by('slug', "ttt", "upg_cate");
       // var_dump($ans);
      }
      //$args['home']

}
?>