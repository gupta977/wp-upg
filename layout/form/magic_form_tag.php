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
), $params );
$frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax

$abc="";
ob_start ();

if($attr['type'] == 'text')
{
    //if($attr['placeholder']=='')
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']);
    // arguments: type, name, value
    echo $frm->addInput('text', $attr['name'], $attr['value'], array('placeholder'=>$attr['placeholder'],'class'=>$attr['class']));
}
else if($attr['type']=='submit')
{
    //submit
    echo $frm->addInput('submit', $attr['name'], $attr['value'],array('class'=>$attr['class']));
}
else 
{
    echo "Invalid Form tag";
}

$abc=ob_get_clean (); 
return $abc;

?>