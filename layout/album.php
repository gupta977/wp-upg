<?php
//List album [upg-album filter="image/embed" class="css_class_name"]
$put = "";
$term_slug = get_query_var('upg_cate');
$term = get_term_by('slug', $term_slug, 'upg_cate');
$perrow = $options['global_perrow'];

if (isset($params['perrow']) && $params['perrow'] > 0) $perrow = $params['perrow'];

if (isset($params['filter']))
    $type = trim($params['filter']);
else
    $type = '';

if (isset($params['class']))
    $class = trim($params['class']);
else
    $class = 'upg_album_stack rotated-right  animated pulse';



if ($term_slug != "") {
    $album_name = $term->name;
    $term_id = $term->term_id;
} else {
    $album_name = "";
    $term_id = 0;
}

$root = 'show'; //Default to show album at beginning


if (isset($params['root']) && $params['root'] == 'hide' && $album_name == "") {
    $root = 'hide';
} else {
    $root = 'show';
}

//Hide hidden category
$skip = array();
$skip = upg_hidden_category($type);


$args = array(
    'orderby'      => 'name',
    'order' => 'ASC',
    'hide_empty'   => 0,
    'exclude'            => $skip,
    'parent' => $term_id,

);

$terms = get_terms('upg_cate', $args);

if (isset($params['count']) && $params['count'] == 'show') {
    $count = true;
} else {
    $count = false;
}
ob_start();


if ($root == 'show') {
    //echo "Selected category: ".$album_name."<hr>";
    if (!empty($terms) && !is_wp_error($terms)) {
        echo '<div class="pure-g">';
        foreach ($terms as $term) {
            $upg_cate_thumb_id = get_term_meta($term->term_id, 'category-image-id', true);
            if ($upg_cate_thumb_id) {
                $cate_thumb_pic = wp_get_attachment_image_url($upg_cate_thumb_id, 'thumbnail');
            } else {
                $cate_thumb_pic = plugins_url('../images/pattern.png', __FILE__);
            }


            $count_result = upg_get_listings_count_by_category($term->term_id, true);
            echo '
            <div class="pure-u-1 pure-u-md-1-' . round($perrow / 2) . ' pure-u-lg-1-' . $perrow . '">';
            echo '<a href="' . upg_get_category_page_link($term, 'upg_cate') . '" title="' . $term->name . '">

                <div class="' . $class . '">
                <img src="' . $cate_thumb_pic . '">';

            if (strpos($cate_thumb_pic, 'pattern.png') == true) {
                if ($count) {
                    echo '<div class="upg_text_centered">' . $term->name . ' (' . $count_result . ')</div>';
                } else {
                    echo '<div class="upg_text_centered">' . $term->name . '</div>';
                }
            } else {
                if ($count) {
                    echo '<div class="upg_text_centered">(' . $count_result . ')</div>';
                }
            }

            echo ' </div></a></div>';
        }
        echo '</div>';
    }
}

$put = ob_get_clean();
return $put;
