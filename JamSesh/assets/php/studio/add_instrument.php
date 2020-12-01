<?php
 if( isset($_POST['submit']) ) {
   //-Form Validation---------------------------------------------------------
   if( isset($_POST['name']) == false || $_POST['name'] == "" ) { // If no name was given for the file
     echo "<script>alert( 'Please name the file' );</script>";
   }
   else if( isset($_FILES['fileToUpload']) == false ||
    @mime_content_type($_FILES["fileToUpload"]["tmp_name"]) != "audio/x-m4a" ) { // If no file was uplaoded or a file of the wrong type
     echo "<script>alert( 'Please upload a file of type: mp3' );</script>";
   }
   else {
     //-Check that the filename is not already in use-------------------------
     $studioID = 1; //TO DO: find the proper ID for the studio
     $studioPath = "studios/".$studioID;
     $mp3s = scandir( $studioPath );
     array_shift( $mp3s ); array_shift( $mp3s ); // Remove the . and ..
     $match = false;
     foreach( $mp3s as $mp3 ) {
       $name = substr( $mp3, 0, -4 );
       if( $name == $_POST['name'] ) {
         $match = true;
       }
     }
     if( $match == false ) {
       // If everything was inputted correctly, upload the file
       $file_name = $_FILES['fileToUpload']['name'];
       $target_file = $studioPath . "/" . $_POST['name'] . ".mp3";
       move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"], $target_file );
     }
     else { // If the filename is not unique
       echo "<script>alert( 'Please choose a unique file name' );</script>";
     }
   }
   $_POST = array(); // Reset inputs to be blank
 }
 ?>
