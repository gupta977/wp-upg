<?php
//Logic inside breadcrumb
function upg_show_breadcrumb($term_slug, $type, $args = array(), $link = false)
{

  $list = "";
  $home = get_bloginfo("url");
  $main_page = upg_get_option('main_page', 'upg_gallery', '0');
  $post_gallery = get_post($main_page, ARRAY_A);
  $gallery_title = $post_gallery['post_title'];
  $gallery_link = esc_url(get_permalink($main_page, '0'));
  $gallery_show = $args['before'] . "<a href='$gallery_link'>" . $gallery_title . "</a>" . $args['after'];

  if ($type && $term_slug) {
    $ans = get_term_by('slug', $term_slug, $type);
    if ($ans) {
      $parentID = $ans->parent;
      while ($parentID > 0) {
        $parent = get_term_by('id', $parentID, $type);
        $url = upg_get_category_page_link($parent, 'upg_cate');
        $list = $args['delimiter'] . "" . $args['before'] . "<a href='" . $url . "'>" . $parent->name . "</a>" . $args['after'] . "" . $list;
        $parentID = $parent->parent;
      }

      if ($link) {
        $url = upg_get_category_page_link($ans, 'upg_cate');
        $list = $list . "" . $args['delimiter'] . "" . $args['before'] . "<a href='" . $url . "'>" . $ans->name . "</a>" . $args['after'] . "";
      } else {
        $list = $list . "" . $args['delimiter'] . "" . $args['before'] . "" . $ans->name . "" . $args['after'] . "";
      }
    }
  }

  if ($list || $link) {
    echo $args['before'] . "<a href='$home'>" . __('Home', 'wp-upg') . "</a>" . $args['after'] . "" . $args['delimiter'] . "" . $gallery_show . "" . $list;
  } else {
    echo $args['before'] . "<a href='$home'>" . __('Home', 'wp-upg') . "</a>" . $args['after'] . "" . $args['delimiter'] . "" . $args['before'] . "" . $gallery_title . "" . $args['after'];
  }
}


//Display breadcrumb
function upg_breadcrumb($args = array())
{
  $put = "";
  ob_start();
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
        'home'        => _x('Home', 'breadcrumb', 'wp-upg'),
      )
    )
  );

  echo $args['wrap_before'];

  if (is_upg_gallery()) {
    global $wp_query;
    if (isset($wp_query->query_vars['user'])) {
      upg_show_breadcrumb('', "upg_cate", $args, true);
      echo $args['delimiter'] . "" . $args['before'] . "" . $wp_query->query_vars['user'] . "" . $args['after'];
    } else if (isset($wp_query->query_vars['upg_tag'])) {
      upg_show_breadcrumb('', "upg_cate", $args, true);
      echo $args['delimiter'] . "" . $args['before'] . "" . $wp_query->query_vars['upg_tag'] . "" . $args['after'];
    } else {
      $term_slug = get_query_var('upg_cate');
      upg_show_breadcrumb($term_slug, "upg_cate", $args);
    }
  }

  if (is_upg_preview()) {
    global $post;
    $term_list = wp_get_post_terms($post->ID, 'upg_cate', array("fields" => "all"));
    if (count($term_list) > 0) {
      $asso_cate_name = $term_list[0]->slug;
      upg_show_breadcrumb($asso_cate_name, "upg_cate", $args, true);
    }
    echo $args['delimiter'] . "" . $args['before'] . "" . $post->post_title . "" . $args['after'];
  }

  echo $args['wrap_after'];
  $put = ob_get_clean();
  return $put;
}
