<?php
function upg_bulk_post_layout($upload_path,$preview,$form_name,$form_attach_id) 
{
    $options = get_option('upg_settings');
    if (!empty($_FILES)) 
    { 
       
    $author = ''; 
    $url = ''; 
    $email = ''; 
    $tags = ''; 
    $captcha = ''; 
    $verify = ''; 
    $content = ''; 
      
    
    if(isset($_POST['form_name'])) $frname=sanitize_text_field($_POST['form_name']); else  $frname="";
    
    if (isset($_POST['user-submitted-title']) && !empty($_POST['user-submitted-title'])) 
        $title=sanitize_text_field($_POST['user-submitted-title']); 
    else 
        $title = 'No Title';

    if (isset($_POST['cat']) && !empty($_POST['cat'])) 
        $category = intval($_POST['cat']); 
    else 
        $category = upg_get_term_id($options['global_album'],'term_id'); 


         if (!empty($_FILES)) 
        { 	
            //$tempFile = $_FILES['user-submitted-image']['tmp_name']; //this is temporary server location
            //$targetFile = $upload_path . $_FILES['user-submitted-image']['name'];
            //return move_uploaded_file($tempFile, $targetFile);
        } 
        $files = array();
		if (isset($_FILES['user-submitted-image']))
	    {
            $files = $_FILES['user-submitted-image'];
		}

        $result = upg_submit($title, $files, $content, $category, $preview);
        //error_log($title." COMPLETE");
    
    return FALSE;
    }
}
?>