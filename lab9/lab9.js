// var auto_refresh = setInterval(
// function (){
//   $('#load_tweets').load('lab9.php').fadeIn("slow");}, 1000);

let filter = $('<form method="post" action="lab9.php" id="filters"></form>');
  let byRin = $('<input type="submit" class="filterBtn" id="byRin" name="options" value="By RIN"/>')
  let byLn = $('<input type="submit" class="filterBtn" id="byLn" name="options" value="By Last Name"/>')
  let byRcs = $('<input type="submit" class="filterBtn" id="byRcs" name="options" value="By RCS ID"/>')
  let byFn = $('<input type="submit" class="filterBtn" id="byFn" name="options" value="By First Name"/>')
  filter.append(byRin).append(byLn).append(byRcs).append(byFn);
  $("#tables").append(filter);
  
  filter.hide();
$(document).ready( function() {
  


  $("#studentsByOrder").on('click', function() {
    
    $('h2').hide();
    if ($(".table") && $(".table").is(":visible")) {
      $(".table").hide();
    }
    if ($("#filters").is(":visible")) {
      $("#filters").hide();
      return true;
    } else {
      if ($("#filters"))
      $("#filters").show();
      return false;
    }
  });
});