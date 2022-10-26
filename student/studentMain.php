<?php
session_start();
if($_SESSION["UserType"]!="Student"){
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
    <title>STUDENT | HOME</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

</head>
<body>
<div class="topnav">
    <a class="active" href="../student/studentMain.php">Home</a>
    <a href ="askforconsent.php">Ask for Consent</a>
    <a href ="addRemoveCourse.php">Add/Remove Course</a>
    <a href ="viewCourse.php">View Course List</a>
    <a href ="changePassStu.php">Change Password</a>
    <a href ="../admin/logout.php">Logout</a>



</div>

<div style="font-weight: bolder">
    <br><br>
    <h1 style="font-size:60px;color:dimgrey;">STUDENT</h1>
    <h2 style="font-size:38px;">USER MANUAL</h2>
    <br>
    <div style="text-align:left;border-radius:50px;background-color:#ababab;margin-left:500px;margin-right:500px;color:black;padding:45px;">
        <br>| ASK FOR CONSENT
        <br>In case the addition of a course requires the consent of the professor, you can send it from here<br>
        <br>| ADD/REMOVE COURSE
        <br>You can add or remove courses here<br>
        <br>| VIEW COURSE LIST
        <br>All the courses enrolled by you and the corresponding grades<br>
        <BR>| CHANGE PASSWORD
        <br>You can change your password here<BR>
    </div>
</div>

</body>
</html>
