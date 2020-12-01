<?php
  include 'assets/php/db_conn.php';
  include 'assets/php/studio/update_settings.php';
  include 'assets/php/studio/add_instrument.php';
  include 'assets/php/studio/delete_instrument.php';
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>JamSesh - Studio</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/Studio.css">
</head>

<!-- Navigation Bar -->
<body>
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
    <div class="container"><a class="navbar-brand" href="user-profile.html">JamSesh</a>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav mr-auto">
          <!-- <li class="nav-item"><a class="nav-link active" href="user-profile.html">Home</a></li> -->
        </ul>
        <span class="navbar-text actions">
          <a class="btn btn-light action-button" role="button" href="homepage.html">Log Out</a>
        </span>
      </div>
    </div>
  </nav>

  <!-- Display Studio Name and Description -->
  <?php
    include 'assets/php/studio/display_settings.php';
  ?>

  <!-- Navbar Tabs -->
  <ul id="studio-navtabs" class="nav nav-tabs mb-3s" role="tablist">
    <li id="first-tab" class="nav-item">
      <a class="nav-link active" id="composition-tab" data-toggle="tab" href="#composition" role="tab"
        aria-controls="composition" aria-selected="true">Composition</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings"
        aria-selected="false">Settings</a>
    </li>
  </ul>

  <!-- Modal for Uploading new file -->
  <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadFileLabel">Upload New File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="update-instrument-form">
          <div class="modal-body">
            <div class="form-group">
              <label for="choosefile1">Choose File</label>
              <input type="file" class="form-control-file" id="choosefile1">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info" data-dismiss="modal">Submit Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for adding instrument -->
  <div class="modal fade" id="add-instrument" tabindex="-1" role="dialog" aria-labelledby="add-instrumentLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="add-instrumentLabel">Add New Instrument</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="add-instrument-form" method="POST" action="studio.php" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="instrumentInput1">Instrument Name</label>
              <input type="text" class="form-control" id="instrumentInput1" name="name">
              <label for="choosefile2">Choose File</label>
              <input type="file" class="form-control-file" id="choosefile2" name="fileToUpload">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" name="submit" value="Submit" class="btn btn-info">Submit Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Navbar Tab Content -->
  <div class="tab-content" id="myTabContent">
    <!-- Composition -->
    <div class="tab-pane fade show active" id="composition" role="tabpanel" aria-labelledby="composition-tab">
      <div id="studio-composition" class="table-responsive">
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Instrument</th>
              <th scope="col">Composition</th>
            </tr>
          </thead>
          <tbody>
            <?php include 'assets/php/studio/display_instruments.php'; ?>
          </tbody>
        </table>
      </div>
      <button id="add-instrument-btn" type="button" class="btn btn-info" data-toggle="modal"
        data-target="#add-instrument">Add Instrument</button>
      <button id="play-all-btn" type="button" class="btn btn-info">Play All</button>
      <button id="pause-all-btn" type="button" class="btn btn-info">Pause All</button>
      <button id="restart-all-btn" type="button" class="btn btn-info">Restart All</button>
    </div>

    <!-- Settings -->
    <?php include 'assets/php/studio/display_settings_tab.php'; ?>

  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/studio.js"></script>

</body>

</html>
