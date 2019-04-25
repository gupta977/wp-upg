<div style="text-align:right">
<div class="update-nag">
<b>Import UPG Layout .zip File</b>
<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">
<input id="upg_layout" name="upg_layout" type="file" size="25" required />
<input type="submit" name="import" class="button button-primary">
</form>
</div>
</div>

<?php
if(isset($_POST['import']))
    {

       if( ! empty( $_FILES ) ) 
       {
          $file=$_FILES['upg_layout'];   // file array
          
		 
		 $uploded_file = basename($file["name"]);
		 $FileType = strtolower(pathinfo($uploded_file,PATHINFO_EXTENSION));
		 
		 //Check if file contains _upg
		 if (strpos($uploded_file, 'upg_') !==false )
		 {	 
    		
		 if($FileType == "zip")
		 {
			 //upload zip file
			 $upload_dir=wp_upload_dir();
			  $path=$upload_dir['basedir'].'/upg/';  //upload dir.
			  if(!is_dir($path)) { mkdir($path); }
			  $attachment_id = upg_upload_file( $file ,$path);
			  
				//unzipping file
				WP_Filesystem();
				$unzipfile = unzip_file( $path.'/'.$uploded_file, $path);
				if ( is_wp_error( $unzipfile ) ) 
				{
					 echo '<div class="error notice is-dismissible"><p>There was an error unzipping the file.</p></div>'; 
			   } 
			   else 
			   {
				  echo "<div class='updated notice is-dismissible'><p>Successfully unzipped the file to media folder!</p></div>";  
				  //Copy to plugin folder
				  $copy_file=copy_dir($path, upg_BASE_DIR."layout/", $skip_list = array() );
				  if($copy_file)
				  {
					  echo "<div class='updated notice is-dismissible'><p>Extracted files copied from ".$path." to ".upg_BASE_DIR."layout/ </p></div>";
				  }
				  else
				  {
					  echo "<div class='error notice is-dismissible'><p>Error copying extracted files to UPG plugin's layout folder :".upg_BASE_DIR."layout/ </p></div>";
					  
				  }
					
				  
			   }
		 }
		 else
		 {
			  echo '<div class="notice notice-error is-dismissible"><p>it\'s not a valid zip file</p></div>';
		 }
		 	  
	   }
	   else
	   {
		   echo '<div class="notice notice-error"><p>This is not a valid UPG layout file</p></div>';
	   }
       }
    }

?>