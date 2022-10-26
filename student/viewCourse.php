<?php
session_start();
if($_SESSION["UserType"]!="Student"){ //if not Admin
    if($_SESSION["UserType"]=="Professor"){
        header("Location: ../professor/professorMain.php");
    }
    else if(($_SESSION["UserType"]=="Admin")){
        header("Location: ../admin/adminhome.php");
    }
    else{
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>STUDENT | COURSES</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

</head>
<body>
<div class="topnav">
    <a  href="../student/studentMain.php">Home</a>
    <a href ="askforconsent.php">Ask for Consent</a>
    <a href ="addRemoveCourse.php">Add/Remove Course</a>
    <a href ="viewCourse.php" class="active">View Course List</a>
    <a href ="changePassStu.php" >Change Password</a>
    <a href ="../admin/logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:420px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>YOUR COURSE LIST</h1><br>

    <table style="text-align: center; margin: 0 auto;background-color:black;" border="4">
                <?php
                $db = new mysqli("127.0.0.1","root","","education_sys");

                $uvalue= $_SESSION["Username"];$courses=$db ->query("SELECT c.course_code, c.course_name,s.Grade FROM studentscourses s, courses c, users u WHERE c.courseid = s.courseid AND u.uid = s.studentid AND u.Username = '$uvalue';");
                echo  "<tr><td>Course Code</td><td>Course Name</td><td>Grade</td>
        </tr>";

                while($course_list=mysqli_fetch_row($courses)){
                    echo "<tr>"
                        ."<td height='35'>".$course_list[0].
                        "<td>".$course_list[1]. "</td>" //prof name
                        ."<td>".$course_list[2]. "</td>"
                        ."</tr>";
                }
                ?>
    </table>
</div>
</div>
</body>
</html>
