<?php
  // TO DO: Get settings from the database
  $settings = [
    "Username" => "wildg",
    "Studio Name" => "Bad Guy",
    "Studio Visibility" => "Public",
    "Allow Fork" => "Yes",
    "Studio Description" => "This is an example studio description",
    "Genres" => [ "Alternative", "Indie" ],
  ];

  if( isset( $_POST['update-settings'] ) ) {

    // Studio Name
    if( $_POST['studio-name'] == "" ) {
      echo "<script>alert( 'Please enter a Studio Name' );</script>";
    }
    else {
      $settings['Studio Name'] = $_POST['studio-name'];
    }

    // Studio Visibility, Allow Fork, and Studio Description
    $settings['Studio Visibility'] = $_POST['studio-visibility'];
    $settings['Allow Fork'] = $_POST['allow-fork'];
    $settings['Studio Description'] = $_POST['studio-description'];

    if( $_POST['add-genre'] != "" ) {
      array_push( $settings['Genres'], $_POST['add-genre'] );
    }
  }
?>
