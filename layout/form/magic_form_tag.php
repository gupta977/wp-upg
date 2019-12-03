<?php
$attr = shortcode_atts(array(
    'type' => 'text',
    'new_type' => 'number',
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
    'novalidate' => '',
    'taxonomy' => 'upg_cate',
    'tag_taxonomy' => 'upg_tag',
    'filter' => '',
    'multiple' => ''


), $params);
$frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax

$abc = "";
ob_start();
if ($attr['type'] == 'post_title') {
    echo $frm->addLabelFor("user-submitted-title", $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', "user-submitted-title", $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
} else if ($attr['type'] == 'video_url') {
    echo $frm->addLabelFor("user-submitted-url", $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('url', "user-submitted-url", $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
} else if ($attr['type'] == 'category') {
    if (taxonomy_exists('category')) {
        echo $frm->addLabelFor('cat', $attr['title']);
        if ($attr['taxonomy'] == 'upg_cate') {
            // echo upg_droplist_album('upg_cate','',upg_hidden_category());
            upg_droplist_category('', $attr['filter']);
        } else {
            echo upg_droplist_album($attr['taxonomy'], '', '');
        }
    }
} else if ($attr['type'] == 'tag') {
    echo $frm->addLabelFor("tags", $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('', "tags", $attr['value'], array('id' => 'tags', 'placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
    echo " <script>
        jQuery(document).ready(function () 
        {
            
            jQuery('#tags').tagsInput();
        });
        </script>";
} else if ($attr['type'] == 'captcha') {

    if (function_exists('upg_submit_form_action')) {
        upg_submit_form_action($attr['title']);
    } else {
        echo "<br>reCaptcha spam block is only available in UPG-PRO<br>";
    }
} else if ($attr['type'] == 'file') {
    echo $frm->addLabelFor('user-submitted-image[]', $attr['title']);
    echo $frm->addInput('file', "user-submitted-image[]", '', array('id' => 'file', 'class' => $attr['class'], 'accept' => 'image/*', 'required' => $attr['required']));
} else if ($attr['type'] == 'file_multiple') {
    if (is_upg_pro()) {
        echo $frm->startTag('div', array('class' => $attr['class']));
        echo $frm->addInput('file', "user-submitted-image[]", '', array('id' => 'file', 'class' => $attr['class'] . '_hide', 'accept' => 'image/*', 'required' => $attr['required'], 'multiple' => $attr['multiple']));
        echo "<p>" . $attr['title'] . "</p>";
        echo $frm->endTag('div');
        echo '
    <script>
    jQuery(document).ready(function()
    {
        jQuery("form input").change(function () 
        {
            if(this.files && this.files.length)
            {
                jQuery("form p").text(this.files.length + " file(s) selected");
            }
            
        });
      });
    </script>
    ';
    } else {
        echo "<br>Multiple upload is only available in UPG-PRO<br>";
    }
} else if ($attr['type'] == 'article') {
    echo $frm->addLabelFor('user-submitted-content', $attr['title']);

    //Toggle GUI editor
    if ($attr['editor'] == "true") {

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
    } else {
        // arguments: name, rows, cols, value, optional assoc. array 
        echo $frm->addTextArea(
            'user-submitted-content',
            $attr['rows'],
            $attr['cols'],
            '',
            array('id' => $attr['id'], 'placeholder' => $attr['placeholder'], 'required' => $attr['required'])
        );
    }
} else if ($attr['type'] == 'text') {
    //if($attr['placeholder']=='')
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', $attr['name'], $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
} else if ($attr['type'] == 'other') {
    //if($attr['placeholder']=='')
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput($attr['new_type'], $attr['name'], $attr['value'], array('placeholder' => $attr['placeholder'], 'class' => $attr['class'], 'required' => $attr['required']));
} else if ($attr['type'] == 'submit') {
    //submit
    echo $frm->addInput('submit', $attr['name'], $attr['value'], array('class' => $attr['class']));
} else if ($attr['type'] == 'radio' || $attr['type'] == 'checkbox') {

    $values = explode(',', $attr['value']);
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    foreach ($values as $option) {
        $val = explode(":", $option);
        $caption = isset($val[1]) ? $val[1] : $val[0];

        if ($attr['type'] == "radio")
            echo $frm->addInput('radio', $attr['name'], $val[0], array('required' => $attr['required'])) . ' ' . $caption . ' ';

        if ($attr['type'] == "checkbox")
            echo $frm->addInput('checkbox', $val[0], $caption, array('required' => $attr['required'])) . ' ' . $caption . ' ';
    }
} else if ($attr['type'] == 'select') {
    $val = array();
    $label = array();

    $values = explode(',', $attr['value']);
    foreach ($values as $option) {
        $cap = explode(":", $option);
        array_push($val, $cap[0]);
        array_push($label, $cap[1]);
    }
    //var_dump($values);
    //var_dump($val);
    //var_dump($label);

    /** addSelectListArrays arguments:
     *   name, array containing option values, array containing option text,
     *   optional: selected option's value, header, additional attributes in associative array
     */
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    if ($attr['placeholder'] == '')
        echo $frm->addSelectListArrays($attr['name'], $val, $label, '');
    else
        echo $frm->addSelectListArrays($attr['name'], $val, $label, '', ' - ' . $attr['placeholder'] . ' - ', array('required' => $attr['required']));
} else if ($attr['type'] == 'textarea') {
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: name, rows, cols, value, optional assoc. array 
    echo $frm->addTextArea(
        $attr['name'],
        $attr['rows'],
        $attr['cols'],
        '',
        array('id' => $attr['id'], 'placeholder' => $attr['placeholder'])
    );
} else {
    echo "Invalid Form tag";
}

$abc = ob_get_clean();
return $abc;

/*
[upg-form class="pure-form pure-form-stacked" title="Upload your media" name="my_form" post_type="video_url" taxonomy="upg_cate"] 

[upg-form class="pure-form pure-form-stacked" title="Upload your media" name="my_form" post_type="wp_post" taxonomy="category" tag_taxonomy="post_tag"] 

[upg-form class="pure-form pure-form-stacked" title="Upload your media" name="my_form"] 

[upg-form-tag type="post_title" title="Title" value="" placeholder="main title" required="true"]

[upg-form-tag type="video_url" title="Submit embed URL" placeholder="http://" required="true"]

[upg-form-tag type="file" title="Select file"]

[upg-form-tag type="file_multiple" title="Drag & Drop multiple files" class="upg_drag_file" multiple="true"]

[upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="image"]

[upg-form-tag type="tag" title="Enter tags" value="" placeholder="Tags separated by commas"]

[upg-form-tag type="article" title="Main Desp"  placeholder="Content Plz" editor="true"]

[upg-form-tag type="text" name="upg_custom_field_1" title="My other Title" value="" placeholder="my placeholder111"]

[upg-form-tag type="textarea" name="upg_custom_field_2" title="Description" placeholder="tell me" rows="3" cols="20"]

[upg-form-tag type="select" name="upg_custom_field_3" title="Select Month" value="mon:Monday,feb:February" placeholder="Month"]

[upg-form-tag type="radio" name="upg_custom_field_4" title="Choose fruits" value="cherry:Cherry,banana:Banana"]

[upg-form-tag type="checkbox" title="Which colors you like ?" value="upg_custom_field_5:Blue,upg_custom_field_6:Black"]

[upg-form-tag type="other" new_type="hidden" name="user-submitted-title" value="blank"]

[upg-form-tag type="captcha" title="Security Check"]

[upg-form-tag type="submit" name="submit" value="Submit Now"]

[/upg-form] */
?>