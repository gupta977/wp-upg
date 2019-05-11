<?php
$attr = shortcode_atts( array(
    'type' => 'text',
    'class' => '',
    'title' => '',
    'name' => '',
    'id' => '',
    'placeholder' => '',
    'value' => '',
    'required' => '',
    'editor' => '',
    'type' => '',
    'rows' => '4',
    'cols' => '40',
    'checked' => '',
    'disabled' => '',
    'readonly' => '',
    'formnovalidate' => '',
    'novalidate' => ''


), $params );
$frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax

$abc="";
ob_start ();
if($attr['type'] == 'title')
{
    echo $frm->addLabelFor("user-submitted-title", $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', "user-submitted-title", $attr['value'], array('placeholder'=>$attr['placeholder'],'class'=>$attr['class'],'required'=>$attr['required']));

}
else if($attr['type'] == 'album')
{
    echo $frm->addLabelFor('cat', $attr['title']);
    echo upg_droplist_category();

}
else if($attr['type'] == 'file')
{
    echo $frm->addLabelFor('user-submitted-image[]', $attr['title']);
    echo $frm->addInput('file', "user-submitted-image[]", '', array('id'=>'file','class'=>$attr['class'],'accept'=>'image/*','required'=>$attr['required']));
}
else if($attr['type'] == 'content')
{
    echo $frm->addLabelFor('user-submitted-content', $attr['title']);

    //Toggle GUI editor
    if($attr['editor']=="true")
    {
      
        ?>
            <div class="upg_text-editor">
			<?php $settings = array(
				    'wpautop'          => true,  // enable rich text editor
				    'media_buttons'    => false,  // enable add media button
				    'textarea_name'    => 'user-submitted-content', // name
				    'textarea_rows'    => '10',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'usp-rich-textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => true,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => true, // enable drag-drop
				);
				wp_editor('', 'upgcontent', apply_filters('upg_editor_settings', $settings)); ?>
				
				</div>
        <?php
    }
    else 
    {
        // arguments: name, rows, cols, value, optional assoc. array 
      echo $frm->addTextArea('user-submitted-content', $attr['rows'], $attr['cols'], '',
      array('id'=>$attr['id'], 'placeholder'=> $attr['placeholder'],'required'=>$attr['required']) );
  
    }
    
}
else if($attr['type'] == 'text')
{
    //if($attr['placeholder']=='')
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', $attr['name'], $attr['value'], array('placeholder'=>$attr['placeholder'],'class'=>$attr['class'],'required'=>$attr['required']));
}
else if($attr['type']=='submit')
{
    //submit
    echo $frm->addInput('submit', $attr['name'], $attr['value'],array('class'=>$attr['class']));
}
else if($attr['type']=='radio' || $attr['type']=='checkbox')
{
   
    $values = explode( ',', $attr['value'] );
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    foreach ( $values as $option ) 
    {
        $val = explode( ":", $option );
        $caption = isset( $val[1] ) ? $val[1] : $val[0];
        
        if($attr['type']=="radio")
        echo $frm->addInput('radio', $attr['name'], $val[0]).' '.$caption.' ';
        
        if($attr['type']=="checkbox")
        echo $frm->addInput('checkbox', $val[0], $val[0]).' '.$caption.' ';

    }
}
else if($attr['type']=='select')
{
    $val=array();
    $label=array();

    $values = explode( ',', $attr['value'] );
    foreach ( $values as $option ) 
    {
        $cap = explode( ":", $option );
        array_push($val,$cap[0]);
        array_push($label,$cap[1]);
    }
    //var_dump($values);
    //var_dump($val);
    //var_dump($label);

    /** addSelectListArrays arguments:
        *   name, array containing option values, array containing option text,
        *   optional: selected option's value, header, additional attributes in associative array
    */
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    if($attr['placeholder']=='')
    echo $frm->addSelectListArrays('month', $val, $label, '');
    else
    echo $frm->addSelectListArrays('month', $val, $label, '', ' - '.$attr['placeholder'].' - ');
}
else if($attr['type']=='textarea')
{
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: name, rows, cols, value, optional assoc. array 
    echo $frm->addTextArea($attr['name'], $attr['rows'], $attr['cols'], '',
    array('id'=>$attr['id'], 'placeholder'=> $attr['placeholder']) );

}
else 
{
    echo "Invalid Form tag";
}

$abc=ob_get_clean (); 
return $abc;

/* [upg-form class="pure
-form" title="Upload your media" name="my_form"] 

[upg-form-tag type="title" title="Main Title" value="" placeholder="main title" required="true"]

[upg-form-tag type="content" title="Main Desp"  placeholder="Content Plz" editor="true"]

[upg-form-tag type="text" name="other_title" title="My other Title" value="" placeholder="my placeholder111"]

[upg-form-tag type="textarea" name="desp" title="Description" placeholder="tell me" rows="3" cols="20"]

[upg-form-tag type="select" name="month" title="Select Month" value="mon:Monday,feb:February" placeholder="Month"]

[upg-form-tag type="radio" name="fruits" title="Choose fruits" value="cherry:Cherry,banana:Banana"]

[upg-form-tag type="checkbox" title="Which colors you like ?" value="blue:Blue,black:Black"]

[upg-form-tag type="submit" name="submit" value="Submit Now"]

[/upg-form] */
?>