<?php
session_start();

if ($_SESSION["UserType"] != "Professor") {
    //if not Admin
    if ($_SESSION["UserType"] == "Admin") {
        header("Location: ../admin/adminhome.php");
    } else if (($_SESSION["UserType"] == "Student")) {
        header("Location: ../student/studentMain.php");
    } else {
        header("Location: index.php");
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PROFESSOR | SUBMIT GRADES</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

    <style>
        button{
            background-color:black;
            font-weight:bolder;
            padding:5px;
        }
    </style>
</head>
<body>


<?php
$db = new mysqli("127.0.0.1","root","","education_sys");

?>
<div class="topnav">
    <a  href="professorMain.php">Home</a>
    <a href ="consents.php" >Consent Requests</a>
    <a href="list.php">Course and Student List</a>
    <a href="submitGrades.php" class="active">Submit Grades</a>
    <a href="changePass.php">Change Password</a>
    <a href="../admin/logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:400px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>SUBMIT GRADES</h1>
    <p>Select the ID and course of the student you want to enter grade.</p><br>
   <?php
   $db = new mysqli("127.0.0.1","root","","education_sys");
   $uvalue= $_SESSION["Username"]; //USERNAME OF THE PRESENT PROF, GET COURSE NAMES
    $courseProfName = $db-> query("SELECT course_professor FROM courses, users WHERE courses.course_professor = users.Surname AND users.Username = '$uvalue';");
    $currProf = $courseProfName->fetch_assoc();
//FIND STUDENTS
    $studentsEnrolled = $db ->query("SELECT u.uid, u.rName, u.Surname, s.Grade, c.course_code FROM users u, studentscourses s, courses c WHERE s.courseid = c.courseid AND s.studentid = u.uid AND  s.Grade = 'Not submitted ' AND c.course_professor = '$currProf[course_professor]' ORDER BY c.course_code ASC");

   echo"<form action='submitGrades.php' method='POST'>";

   echo "<table style='width:320px;margin:0 auto;'>";
        echo  "<tr style='font-size:16px;;'><td>ID</td><td>Course Name</td><td>Grade</td></tr>";

   echo "<tr><td>";
   echo "<select name='studentId' required>";
        while($stud_list=mysqli_fetch_row($studentsEnrolled)) {
                echo  "<option value ='$stud_list[0]'>" . $stud_list[0] . "</option>"; //STUDENT LIST CREATE
        }
#Select id's of students that don't have a submitted grade.
   $coursesEnter = $db ->query("SELECT DISTINCT c.course_code FROM users u, studentscourses s, courses c WHERE s.courseid = c.courseid AND s.studentid = u.uid AND c.course_professor = '$currProf[course_professor]'");
        echo "</select></td>";

   #Select courses.
   echo"<td><select style='width:190px;' name='courseCode' required>";
   while($course_lst=mysqli_fetch_row($coursesEnter)) {
       echo  "<option value ='$course_lst[0]'>" . $course_lst[0] . "</option>";
   }
   echo "</select></td>";

   echo "<td>" . "<select name='grade'><option value='Not Submitted'>Not Submitted</option><option value='Passed'>Passed</option><option value='Failed'>Failed</option></select></form>" . "</td>";
   echo "</tr>";
   echo "</table>";

        echo "<br><input type='submit' name='submitGrade' value='SUBMIT'>";

   if(isset($_POST["submitGrade"]))
   {
       $studentId = $_POST["studentId"];
       $courseCode = $_POST["courseCode"];
       $grade = $_POST["grade"];
//UPDATE THEIR GRADES WITH THIS QUERY!
   $updateGrade = $db -> query("UPDATE studentscourses s,courses co SET s.Grade ='$grade' WHERE s.studentid = '$studentId' AND co.courseid = s.courseid AND co.course_code = '$courseCode';");

   if($updateGrade){
       echo "<p>Grade of the student has been submitted successfully</p>";
       echo "Check 'Course and Student List' page to check the grades.";
   }
   else{
       echo "<p>An error has occured. Please try again. </p>";
   }
   }

    ?>
</div>
</body>
</html>