<?php

function upg_cate_add_meta_fields( $taxonomy ) 
{
    $frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax
    echo $frm->addLabelFor('upg_assign_cate', __('Album for: ','wp-upg'));
    echo $frm->addInput('radio', 'upg_assign_cate', 'all',array('checked'=>'true')).' All ';
    echo $frm->addInput('radio', 'upg_assign_cate', 'image').' Images ';
    echo $frm->addInput('radio', 'upg_assign_cate', 'youtube').' Youtube/Vimeo ';
    ?>
    <div class="form-field term-group">
        <label for="upg_show_cate"><?php _e( 'Hide album from frontend', 'wp-upg' ); ?></label>
		<input type="checkbox" name="upg_show_cate" value="1" id="upg_show_cate">
     
    </div>
    <?php
}
add_action( 'upg_cate_add_form_fields', 'upg_cate_add_meta_fields', 10, 2 );


function upg_cate_edit_meta_fields( $term, $taxonomy ) 
{
    $frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax
    $upg_show_cate = get_term_meta( $term->term_id, 'upg_show_cate', true );
    $upg_assign_cate = get_term_meta( $term->term_id, 'upg_assign_cate', true );
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="upg_show_cate"><?php _e( 'Hide at Front End', 'wp-upg' ); ?></label>
        </th>
        <td>
		
		<input type="checkbox" name="upg_show_cate" value="1" id="upg_show_cate" <?php if($upg_show_cate=="1") echo "checked" ?>>
         
        </td>
    
    </tr>
    <tr>
    
    <th scope="row"> <?php echo $frm->addLabelFor('upg_assign_cate', __('Album for: ','wp-upg')); ?> </th>
       <td>
        <?php
                echo $frm->addInput('radio', 'upg_assign_cate', 'all',upg_checked_form('all',$upg_assign_cate)).' All ';
                echo $frm->addInput('radio', 'upg_assign_cate', 'image',upg_checked_form('image',$upg_assign_cate)).' Images ';
                echo $frm->addInput('radio', 'upg_assign_cate', 'youtube',upg_checked_form('youtube',$upg_assign_cate)).' Youtube/Vimeo ';
        ?>
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
    if( isset( $_POST['upg_assign_cate'] ) ) 
	{
        update_term_meta( $term_id, 'upg_assign_cate', esc_attr( $_POST['upg_assign_cate'] ) );
    }
    else
    {
        update_term_meta( $term_id, 'upg_assign_cate', 'all' );
    }
}
add_action( 'created_upg_cate', 'upg_cate_save_taxonomy_meta', 10, 2 );
add_action( 'edited_upg_cate', 'upg_cate_save_taxonomy_meta', 10, 2 );

function upg_cate_add_field_columns( $columns ) {
    $columns['upg_show_cate'] = __( 'Hide', 'wp-upg' );
    $columns['upg_assign_cate'] = __( 'Album for', 'wp-upg' );

    return $columns;
}
add_filter( 'manage_edit-upg_cate_columns', 'upg_cate_add_field_columns' );



function upg_cate_add_field_column_contents( $content, $column_name, $term_id ) {
    switch( $column_name ) 
    {
        case 'upg_show_cate' :
            $content = get_term_meta( $term_id, 'upg_show_cate', true );
            if($content=="1")
            {
                $content="YES";
            }
            else 
            {
                $content="NO";
            }
        
    break;
    }
    switch( $column_name ) 
    {
        case 'upg_assign_cate' :
        $content = get_term_meta( $term_id, 'upg_assign_cate', true );
        break;    
    }


    return $content;
}
add_filter( 'manage_upg_cate_custom_column', 'upg_cate_add_field_column_contents', 10, 3 );

?>