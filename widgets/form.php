<?php
add_action( 'widgets_init', function(){
    register_widget( 'upg_form_Widget' );
});

class upg_form_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'upg_form_widget',
            'description' => 'Auto generated UPG submission form for the selected settings.',
        );

        parent::__construct( 'upg_form_widget', 'UPG AJax Form', $widget_ops );
    }


    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
	{
        // outputs the content of the widget
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) 
		{
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];

            echo do_shortcode('[upg-post type="'.$instance['form_type'].'" ajax="true" layout="'.$instance['form_layout_name'].'" preview="'.$instance['preview_layout_name'].'" form_name="'.$args['id'].'"]');
        }
        
        //var_dump($args);
        //echo $args['form_type'].".......<hr>";
        //echo __( 'Hello, World!', 'text_domain' );
        echo $args['after_widget'];
    }
	
	


    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'wp-upg' );
        $form_type = ! empty( $instance['form_type'] ) ? $instance['form_type'] : 'image';
        $form_layout_name = ! empty( $instance['form_layout_name'] ) ? $instance['form_layout_name'] : 'basic';
        $preview_layout_name = ! empty( $instance['preview_layout_name'] ) ? $instance['preview_layout_name'] : 'basic';
      // var_dump($instance);
       ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><b><?php _e( 'Widget Title:' ); ?></b></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			  <br>
			  <br>
			  <label for="<?php echo $this->get_field_id( 'form_type' ); ?>"><b><?php _e( 'Select form type:' ); ?></b></label>
              <select id="<?php echo $this->get_field_id( 'form_type' ); ?>" name="<?php echo $this->get_field_name( 'form_type' ); ?>" class="widefat">
	<option value="image">— <?php _e( 'Select Parent' ); ?> —</option>
	<option class="level-0" <?php if($form_type=='image') echo 'selected="selected"'; ?> value="image">Meida Form</option>
	<option class="level-0" <?php if($form_type=='embed') echo 'selected="selected"'; ?> value="embed">Embed URL</option>
  
</select>
	<br><br>
    <table border="0">
    <tr>
    <td><b><?php _e( 'Select form layout', 'wp-upg' ); ?> : </b></td>
    <td><?php 
    
    echo upg_grid_layout_list($form_layout_name,$this->get_field_name('form_layout_name' ),"form",false);
    ?></td>
	</tr>
    </table>
    <hr>
    
    <table border="0">
    <tr>
    <td><b><?php _e( 'Select preview layout', 'wp-upg' ); ?> : </b></td>
    <td> <?php 
    
    echo upg_grid_layout_list($preview_layout_name,$this->get_field_name('preview_layout_name'),"media",false);
    ?></td>
    </tr>
    </table>
   
	<?php ( 'Preview layout is used if lightbox/popup is not enabled in grid layout.'); ?>
	<br>
	  </p>

        <?php
    }


    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) 
	{
        // processes widget options to be saved
       /*  foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }

        return $updated_instance; */
		
		
		$instance = $old_instance;
		
		$instance['title']          = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['form_type']= isset( $new_instance['form_type'] ) ? $new_instance['form_type'] : 'image';
		$instance['form_layout_name'] =isset( $new_instance['form_layout_name'] ) ? $new_instance['form_layout_name'] : 'basic';
		$instance['preview_layout_name']=isset( $new_instance['preview_layout_name'] ) ? $new_instance['preview_layout_name'] : 'basic';
		return $instance;
		
		
		
		
    }
}