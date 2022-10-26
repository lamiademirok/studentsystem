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
    <title>PROFESSOR | LISTS</title>
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
    <a href="list.php" class="active">Course and Student List</a>
    <a href="submitGrades.php">Submit Grades</a>
    <a href="changePass.php">Change Password</a>
    <a href="../admin/logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:400px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>YOUR COURSES</h1><br>
    <table style="text-align: center; margin: 0 auto;background-color:black;" border="4">
        <?php
        $db = new mysqli("127.0.0.1","root","","education_sys");

        $uvalue= $_SESSION["Username"]; //GET USERNAME AND SELECT COURSES THAT BELONG TO THIS PROFESSOR
        $courses=$db ->query("SELECT DISTINCT c.course_code, c.course_name FROM studentscourses s, courses c, users u WHERE c.course_professor = u.Surname AND u.Username = '$uvalue';");
        echo  "<tr><td>Course Code</td><td>Course Name</td>
        </tr>";

        while($course_list=mysqli_fetch_row($courses)){ // SHOW COURSES
            echo "<tr>"
                ."<td height='35'>".$course_list[0].
                "<td>".$course_list[1]. "</td>" //COURSE NAME
                ."</tr>";
        }
        echo "</table>";
        echo "<br><p>STUDENTS ENROLLED</p><hr>";

        //GET NAME OF PROFESSOR
        $courseProfName = $db-> query("SELECT course_professor FROM courses, users WHERE courses.course_professor = users.Surname AND users.Username = '$uvalue';");
        $currProf = $courseProfName->fetch_assoc();

        //GET STUDENTS ENROLLED
        $studentsEnrolled = $db ->query("SELECT u.uid, u.rName, u.Surname, s.Grade, c.course_code FROM users u, studentscourses s, courses c WHERE s.courseid = c.courseid AND s.studentid = u.uid AND c.course_professor = '$currProf[course_professor]' ORDER BY c.course_code ASC");
        echo "<table style='width:380px;padding:5px;margin:0 auto;'>";
        echo  "<tr style='text-decoration: underline; font-size:16px;'><td>ID</td><td>Name</td><td>Surname</td><td>Course</td><td>Grades</td></tr>";
        while($stud_list=mysqli_fetch_row($studentsEnrolled)){
                       echo "<tr>"
                           ."<td>" .$stud_list[0]. "</td>"
                      ."<td>" .$stud_list[1]. "</td>"
                     ."<td>" .$stud_list[2]. "</td>"
                      ."<td>" .$stud_list[4]. "</td>"
                           ."<td>" .$stud_list[3]. "</td>"
                      ."</tr>";
              }
        echo "</table>";
        ?>

</div>
</body>
</html>