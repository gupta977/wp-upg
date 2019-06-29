<?php



add_filter('manage_edit-upg_columns', 'add_new_upg_columns');
function add_new_upg_columns($upg_columns)
{
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = __('Title', 'wp-upg');
    $new_columns['author'] = __('Author','wp-upg');
    $new_columns['upg_cate'] = __('Albums','wp-upg');
    $new_columns['upg_tag'] = __('Tags','wp-upg');
    $new_columns['card_layout'] = __('Layout Name','wp-upg');
    $new_columns['Thumbnail'] = __('Thumbnail','wp-upg');
	$new_columns['comments'] = __('<span class="vers"><div title="Comments" class="comment-grey-bubble">Comments</div></span>','wp-upg');
    $new_columns['date'] = __('Date', 'wp-upg');
 
    return $new_columns;
    
}



add_action('manage_upg_posts_custom_column', 'manage_upg_columns', 10, 2);
function manage_upg_columns($column_name, $id) 
{
    global $wpdb;
	
  $thumb = upg_image_src('thumbnail',get_post($id));
  $layout="basic";
  
   $all_upg_fields= get_post_custom($id);
   
   if(isset($all_upg_fields["upg_layout"][0]))
     $layout = $all_upg_fields["upg_layout"][0];
    
    switch ($column_name) 
	{
    case 'card_layout':
        update_post_meta($id,"_upg_product_card_layout",$layout);
        echo "$layout";
            break;
 
    case 'Thumbnail':
        update_post_meta($id,"_upg_product_Thumbnail",$thumb);
       echo "<img src='$thumb' width='75'>";
        break;
       
    case 'upg_cate':
        global $post;
        $terms = get_the_terms( $id, 'upg_cate' );
        /* If terms were found. */
        if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'upg_cate' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'upg_cate', 'display' ) )
                        );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
        }

        /* If no terms were found, output a default message. */
        else {
                //_e( '--' , 'wp-upg');
                echo "--";
        }

        break;
        case 'upg_tag':
        global $post;
        $terms = get_the_terms( $id, 'upg_tag' );
        /* If terms were found. */
        if ( !empty( $terms ) ) {

                $out = array();

                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ( $terms as $term ) {
                        $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'upg_tag' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'upg_tag', 'display' ) )
                        );
                }

                /* Join the terms, separating them with a comma. */
                echo join( ', ', $out );
        }

        /* If no terms were found, output a default message. */
        else {
                //_e( '--' , 'wp-upg');
                echo "--";
        }

        break;
    
    default:
        break;
    } // end switch
}