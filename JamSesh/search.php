<?php
// Initialize the session
session_start();

// Include config file
include 'assets/php/db_conn.php';

// Checks if a studio was clicked on--------------------------------------------
function checkStudioClicked() {
  if (isset($_POST["studio-clicked"])) {
    $_SESSION["studioID"] = $_POST["studio-clicked"];
    header("Location: studio.php");
  }
}

checkStudioClicked();
?>


<!-- get all studios and their genres into a list excluding privated -->
<!-- select * from studios s left join genres g on s.id = g.studioID where s.settings not like '%Private%'; -->

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>JamSesh - Admin Page</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/Homepage-Nav.css">
  <link rel="stylesheet" href="assets/css/User-Profile.css">
  <link rel="stylesheet" href="assets/css/Search.css">
  <script defer src="assets/js/jquery.min.js"></script>
  <script defer src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
    <div class="container"><a class="navbar-brand" href="user-profile.php">JamSesh</a>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav mr-auto">
          <!-- <li class="nav-item"><a class="nav-link active" href="#">Home</a></li> -->
        </ul>
        <span class="navbar-text actions" style="float: right;">
          <a class="btn btn-link" role="button" href="search_button.php">Search</a>
          <?php
          if (isset($_SESSION["email"])) {
            echo '<a class="btn btn-light action-button" role="button" href="logout.php">Log Out</a>';
          } else {
            echo '<a class="btn btn-light action-button" href="login.php">Log In</a>';
          }
          ?>
        </span>
      </div>
    </div>
  </nav>


  <div class="mainBodyContainer">
    <div class="searchBarContainer">
      <div class="input-group md-form form-sm form-1 pl-0">
        <div class="fa fa-search">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
          </svg>
        </div>
        <div>
          <form action="search.php" method="POST">
            <input class="form-control my-0 py-1 searchBar" type="text" placeholder="Search" name="searchBar" value='<?php echo isset($_POST['searchBar']) ? $_POST['searchBar'] : ''; ?>' aria-label="Search">
          </form>
          <?php
          $stmt = "SELECT * from studios s left join genres g on s.id = g.studioID where s.visibility = 'Public';";
          $filtered = array();
          if ($result = mysqli_query($link, $stmt)) {
            while ($row = mysqli_fetch_array($result)) {
              array_push($filtered, $row);
            }
          }

          if (isset($_POST['searchBar']) && $_POST['searchBar'] != '') {
            $term = $_POST['searchBar'];
            $_SESSION["search_query"] = $term;

            trim($term, " ");
            $term = strtolower($term);
            // Construct the final studio results
            $finalResults = array();
            foreach ($filtered as $e) {
              $title = $e["title"];
              $visibility = $e["visibility"];
              $allowFork = $e['allowFork'];
              $description = $e['description'];


              if ((strpos(strtolower($e['genre']), $term) !== false) || (strpos(strtolower($e['instruments']), $term) !== false) || (strpos(strtolower($e['description']), $term) !== false) || strpos(strtolower($e['title']), $term) !== false) {
                array_push($finalResults, [
                  "id" => $e["id"],
                  "title" => $title,
                  "visibility" => $visibility,
                  "allowFork" => $allowFork,
                  "description" => $description
                ]);
              }
            }
            $_SESSION["search_studios"] = $finalResults;
          }
          ?>
        </div>
      </div>
    </div>
    <div class="studioHeader d-flex">
      <?php
      if ($_SESSION["search_studios"]) {
        if (count($_SESSION["search_studios"]) > 0) {
          $searchTerm = $_SESSION["search_query"];
          echo "<h1>Results for \"" . $searchTerm . "\"</h1>";
          echo "<p>Showing " . count($_SESSION["search_studios"]) . " results</p>";
        }
      }
      ?>
    </div>
    <?php
    if ($_SESSION["search_studios"]) {
      if (@$_SESSION["search_studios"]) {
        foreach ($_SESSION["search_studios"] as $s) {
          echo "<form method='POST' action='search.php'>";
          echo "<button type='submit' name='studio-clicked' value=" . $s["id"] . " class='studio'>";
          echo "<div class='studioTitle text-left'>" . $s["title"] . "</div>";
          echo "<hr />";
          echo "<p class='studioDescription text-left'>" . $s["description"] . "</p>";
          // echo "<div class='studioGenres d-flex flex-row'>";
          // foreach ($s["genres"] as $g) {
          //   echo "<p class='btn btn-light action-button genres'>" . $g . "</p>";
          // }
          // echo "</div>";
          echo "</button>";
          echo "</form>";
        }
      } else {
        if (count($_SESSION["search_studios"]) == 0) {
          echo "<p>No Studios Yet</p>";
        }
      }
    }
    ?>
  </div>
  </div>

</body>

</html>