<?php
//upload form at admin. It is used in widgets. 
wp_enqueue_media();
		wp_enqueue_script( 'meta-box-media', plugins_url('media.js', __FILE__ ), array('jquery') );

		wp_nonce_field( 'nonce_action', 'nonce_name' );

		// one or more
		//$field_names = array( 'meta-box-media-name', 'another-meta-box-media-name' );
		$field_names = array( 'pic_name');
		foreach ( $field_names as $name ) {

			$value = $rawvalue = get_post_meta( get_the_id(), $name, true );

			$name = esc_attr( $name );
			$value = esc_attr( $name );
			//if($rawvalue=='')
			echo "<input type='hidden' id='$name-value'  class='small-text'       name='meta-box-media[$name]'     value='$value' />";
			//if($rawvalue=='')
			echo "<input type='button' id='$name'        class='button meta-box-upload-button'        value='Upload or Select Image' />";
			
			
			echo "<input type='button' id='$name-remove' class='button meta-box-upload-button-remove' value='Hide' />";

			$image = ! $rawvalue ? '' : wp_get_attachment_image( $rawvalue, 'full', false, array('style' => 'max-width:25%;height:auto;') );

			echo "<div class='image-preview'>$image</div>";

			echo '<br />';
			
			//echo "--------".$_SESSION["favcolor"];
			//$_SESSION["favcolor"] .="";

		}


?>