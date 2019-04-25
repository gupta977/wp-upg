<?php

function upg_cate_add_meta_fields( $taxonomy ) 
{
    ?>
    <div class="form-field term-group">
        <label for="upg_show_cate"><?php _e( 'Hide at Front end during submission', 'upg' ); ?></label>
		<input type="checkbox" name="upg_show_cate" value="1" id="upg_show_cate">
      
    </div>
    <?php
}
add_action( 'upg_cate_add_form_fields', 'upg_cate_add_meta_fields', 10, 2 );


function upg_cate_edit_meta_fields( $term, $taxonomy ) {
    $upg_show_cate = get_term_meta( $term->term_id, 'upg_show_cate', true );
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="upg_show_cate"><?php _e( 'Hide at Front End', 'upg' ); ?></label>
        </th>
        <td>
		
		<input type="checkbox" name="upg_show_cate" value="1" id="upg_show_cate" <?php if($upg_show_cate=="1") echo "checked" ?>>
         
        </td>
    </tr>
    <?php
}
add_action( 'upg_cate_edit_form_fields', 'upg_cate_edit_meta_fields', 10, 2 );

function upg_cate_save_taxonomy_meta( $term_id, $tag_id ) {
    if( isset( $_POST['upg_show_cate'] ) ) 
	{
        update_term_meta( $term_id, 'upg_show_cate', esc_attr( $_POST['upg_show_cate'] ) );
    }
	else
	{
		 update_term_meta( $term_id, 'upg_show_cate', '0' );
	}
}
add_action( 'created_upg_cate', 'upg_cate_save_taxonomy_meta', 10, 2 );
add_action( 'edited_upg_cate', 'upg_cate_save_taxonomy_meta', 10, 2 );

function upg_cate_add_field_columns( $columns ) {
    $columns['upg_show_cate'] = __( 'Hide', 'upg' );

    return $columns;
}
add_filter( 'manage_edit-upg_cate_columns', 'upg_cate_add_field_columns' );


function upg_cate_add_field_column_contents( $content, $column_name, $term_id ) {
    switch( $column_name ) {
        case 'upg_show_cate' :
            $content = get_term_meta( $term_id, 'upg_show_cate', true );
            if($content=="1")
            {
                $content="YES";
            }
                else {
                    $content="NO";
                }
			
            break;
    }

    return $content;
}
add_filter( 'manage_upg_cate_custom_column', 'upg_cate_add_field_column_contents', 10, 3 );

?>