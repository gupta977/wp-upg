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
), $params );
$frm = new upg_HTML_Form(false); // pass false for html rather than xhtml syntax

$abc="";
ob_start ();

if($attr['type'] == 'text')
{
    //if($attr['placeholder']=='')
    // arguments: for (id of associated form element), text
    echo $frm->addLabelFor($attr['name'], $attr['title']).": ";
    // arguments: type, name, value
    echo $frm->addInput('text', $attr['name'], $attr['value'], array('placeholder'=>$attr['placeholder'],'class'=>$attr['class']));
}
else if($attr['type']=='submit')
{
    //submit
    echo $frm->addInput('submit', $attr['name'], $attr['value'],array('class'=>$attr['class']));
}
else if($attr['type']=='radio' || $attr['type']=='checkbox')
{
   
    $values = explode( ',', $attr['value'] );
    echo $frm->addLabelFor($attr['name'], $attr['title']).": ";
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
    echo $frm->addLabelFor($attr['name'], $attr['title']).": ";
    if($attr['placeholder']=='')
    echo $frm->addSelectListArrays('month', $val, $label, '');
    else
    echo $frm->addSelectListArrays('month', $val, $label, '', ' - '.$attr['placeholder'].' - ');
}
else if($attr['type']=='textarea')
{
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

?>