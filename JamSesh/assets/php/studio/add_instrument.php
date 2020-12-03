<?php
 if( isset($_POST['submit']) ) {
   //-Form Validation---------------------------------------------------------
   if( isset($_POST['newFileName']) == false || $_POST['newFileName'] == "" ) { // If no name was given for the file
     echo "<script>alert( 'Please name the file' );</script>";
   }
   else if( isset($_FILES['fileToUpload']) == false ||
    @mime_content_type($_FILES["fileToUpload"]["tmp_name"]) != "audio/x-m4a" ) { // If no file was uplaoded or a file of the wrong type
     echo "<script>alert( 'Please upload a file of type: mp3' );</script>";
   }
   else {
     //-Check that the filename is not already in use-------------------------
     $instruments = json_decode( $instruments );
     $in_names = $instruments->{'names'};
     $in_files = $instruments->{'files'};
     $match = false;
     for( $i=0; $i < count($in_names); $i++ ) {
      if( $_POST['newFileName'] == $in_names[i] ) {
        $match = true;
      }
     }
     if( $match == false ) {
       // If everything was inputted correctly, upload the file
       $file_name = $_FILES['fileToUpload']['name'];
       $target_file = "studios/" . $_POST["studio-clicked"] . "/" . $_POST['newFileName'] . ".mp3";
       move_uploaded_file( $_FILES["fileToUpload"]["tmp_name"], $target_file );
       // update the db
       array_push($in_names, $_POST['newFileName']);
       array_push($in_files, $target_file);
       var_dump($in_names); echo "<br>"; var_dump($in_files);


     }
     else { // If the filename is not unique
       echo "<script>alert( 'Please choose a unique file name' );</script>";
     }
   }
 }
 ?>
