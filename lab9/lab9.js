// var auto_refresh = setInterval(
// function (){
//   $('#load_tweets').load('lab9.php').fadeIn("slow");}, 1000);

let filter = $('<form method="post" action="lab9.php" id="filters"></form>');
let byRin = $('<input type="submit" class="filterBtn" id="byRin" name="options" value="By RIN"/>')
let byLn = $('<input type="submit" class="filterBtn" id="byLn" name="options" value="By Last Name"/>')
let byRcs = $('<input type="submit" class="filterBtn" id="byRcs" name="options" value="By RCS ID"/>')
let byFn = $('<input type="submit" class="filterBtn" id="byFn" name="options" value="By First Name"/>')
filter.append(byRin).append(byLn).append(byRcs).append(byFn);


// Add form for adding student to students table
let addStudentForm = $('<form method="post" action="lab9.php" id="addStudentForm"></form>');
let rinLabel = $('<label for="RIN">RIN: </label>');
let rinInput = $('<input type="text" name="RIN"/><br><br>');

let rcsLabel = $('<label for="RCS">RCS ID: </label>');
let rcsInput = $('<input type="text" name="RCS"/><br><br>');

let fnLabel = $('<label for="fn">First Name: </label>');
let fnInput = $('<input type="text" name="fn"/><br><br>');

let lnLabel = $('<label for="ln">Last Name: </label>');
let lnInput = $('<input type="text" name="ln"/><br><br>');

let aliasLabel = $('<label for="alias">Alias: </label>');
let aliasInput = $('<input type="text" name="alias"/><br><br>');

let phoneLabel = $('<label for="phone">Phone: </label>');
let phoneInput = $('<input type="text" name="phone"/><br><br>');
addStudentForm.append(rinLabel).append(rinInput);
addStudentForm.append(rcsLabel).append(rcsInput);
addStudentForm.append(fnLabel).append(fnInput);
addStudentForm.append(lnLabel).append(lnInput);
addStudentForm.append(aliasLabel).append(aliasInput);
addStudentForm.append(phoneLabel).append(phoneInput);
addStudentForm.append('<input type="submit" class="dbOp" name="dbOp" value="Add Student"/>');


// Add form for adding column to students table
let addStudentAttr = $('<form method="post" action="lab9.php" id="addStudentAttr"></form>');
let attrLabel = $('<label for="stuAttr">New Student Attribute: </label>');
let attrInput = $('<input type="text" name="stuAttr" placeholder="varchar(100)"/><br><br>');
addStudentAttr.append(attrLabel).append(attrInput);
addStudentAttr.append('<input type="submit" class="dbOp" name="dbOp" value="Add Student Attribute"/>')


// Add form for adding course to courses table
let addCourseForm = $('<form method="post" action="lab9.php" id="addCourseForm"></form>');
let crnLabel = $('<label for="CRN">Course CRN: </label>');
let crnInput = $('<input type="text" name="CRN"/><br><br>');

let prefixLabel = $('<label for="prefix">Course Prefix: </label>');
let prefixInput = $('<input type="text" name="prefix"/><br><br>');

let numberLabel = $('<label for="number">Course Number: </label>');
let numberInput = $('<input type="text" name="number"/><br><br>');

let titleLabel = $('<label for="title">Course Title: </label>');
let titleInput = $('<input type="text" name="title"/><br><br>');

addCourseForm.append(crnLabel).append(crnInput);
addCourseForm.append(prefixLabel).append(prefixInput);
addCourseForm.append(numberLabel).append(numberInput);
addCourseForm.append(titleLabel).append(titleInput);
addCourseForm.append('<input type="submit" class="dbOp" name="dbOp" value="Add Course"/>');


// Add form for adding column to courses table
let addCourseAttr = $('<form method="post" action="lab9.php" id="addCourseAttr"></form>');
let courseattrLabel = $('<label for="addCourseAttr">New Course Attribute: </label>');
let courseattrInput = $('<input type="text" name="addCourseAttr" placeholder="varchar(100)"/><br><br>');
addCourseAttr.append(courseattrLabel).append(courseattrInput);
addCourseAttr.append('<input type="submit" class="dbOp" name="dbOp" value="Add Course Attribute"/>')


// Add form for adding grade to grades table
let addGrade = $('<form method="post" action="lab9.php" id="addGrade"></form>');
let gradeCrnLabel = $('<label for="grdCRN">CRN: </label>');
let gradeCrnInput = $('<input type="text" name="grdCRN"/><br><br>');

let gradeRcsLabel = $('<label for="grdRCS">RCS ID: </label>');
let gradeRcsInput = $('<input type="text" name="grdRCS"/><br><br>');

let gradeLabel = $('<label for="grade">Grade: </label>');
let gradeInput = $('<input type="text" name="grade"/><br><br>');
addGrade.append(gradeCrnLabel).append(gradeCrnInput);
addGrade.append(gradeRcsLabel).append(gradeRcsInput);
addGrade.append(gradeLabel).append(gradeInput);
addGrade.append('<input type="submit" class="dbOp" name="dbOp" value="Add Grade"/>')


$("#tables").append(filter);
$("#modifier").append(addStudentForm);
$("#modifier").append(addStudentAttr);
$("#modifier").append(addCourseForm);
$("#modifier").append(addCourseAttr);
$("#modifier").append(addGrade);
filter.hide();
addStudentForm.hide();
addStudentAttr.hide();
addCourseForm.hide();
addCourseAttr.hide();
addGrade.hide();


$(document).ready( function() {
  
  $("#studentsByOrder").on('click', function() {

    $("#studentBtns").hide();
    $("#courseBtns").hide();
    $('#gradeBtns').hide();
    
    $("#addStudentForm").hide();
    $("#addStudentAttr").hide();
    $("#addCourseForm").hide();
    $("#addCourseAttr").hide();
    $("#addGrade").hide();
    $('h2').hide();

    if ($(".table") && $(".table").is(":visible")) {
      $(".table").hide();
    }
    if ($("#filters").is(":visible")) {
      $("#filters").hide();
      return true;
    } else {
      if ($("#filters")) {
        $("#filters").show();
      }
      return false;
    }
  });

  $("#addStudent").on('click', function() {
    // $("#modifier").append(addStudentForm);
    $("#addStudentAttr").hide();
    if ($("#addStudentForm").is(":visible")) {
      $("#addStudentForm").hide();
    } else {
       $("#addStudentForm").show();
    }
  });

  $("#addStudentCol").on('click', function() {
    // $("#modifier").append(addStudentAttr);
    $("#addStudentForm").hide();
    if ($("#addStudentAttr").is(":visible")) {
      $("#addStudentAttr").hide();
    } else {
      $("#addStudentAttr").show();
    }
  });

  $("#addCourse").on('click', function() {
    // $("#modifier").append(addCourseForm);
    $("#addCourseAttr").hide();
    if ($("#addCourseForm").is(":visible")) {
      $("#addCourseForm").hide();
    } else {
      $("#addCourseForm").show();
    }
  });

  $("#addCourseCol").on('click', function() {
    $("#addCourseForm").hide();
    if ($("#addCourseAttr").is(":visible")) {
      $("#addCourseAttr").hide();
    } else {
      $("#addCourseAttr").show();
    }
  });

  $("#addGrades").on('click', function() {
    if ($("#addGrade").is(":visible")) {
      $("#addGrade").hide();
    } else {
      $("#addGrade").show();
    }
  });


});