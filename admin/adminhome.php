<?php
session_start();
if($_SESSION["UserType"]!="Admin"){ //if not Admin
    if($_SESSION["UserType"]=="Professor"){
        header("Location: ../professor/professorMain.php");
    }
    else if(($_SESSION["UserType"]=="Student")){
        header("Location: ../student/studentMain.php");
    }
    else{
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ADMIN | HOME</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

</head>
<body>
<div class="topnav">
    <a class="active" href="adminhome.php">Home</a>
    <a href="userList.php">Lists</a>
    <a href="../admin/addUser.php">Add User</a>
    <a href="../admin/editCourses.php">Add Course</a>
    <a href="changePassword.php">Change Passwords</a>
    <a href="deactivate.php">Deactivate Users</a>
    <a href="sysParameters.php">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>

<div style="font-weight: bolder">
    <h1 style="font-size:80px;color:dimgrey;">ADMIN</h1>
    <h2 style="font-size:38px;">USER MANUAL</h2>
<br>
    <div style="text-align:left;border-radius:50px;background-color:#ababab;margin-left:500px;margin-right:500px;color:black;padding:45px;">
        <br>| LIST OF USERS
        <br>You can access to list of all users including professors and students<br>
        <br>| ADD USER
        <br>You can add a new professor or student<br>
        <br>| ADD COURSE
        <br>You can add a new course<br>
        <BR>| CHANGE USER PASSWORDS
        <br>You can change user passwords according to limitations. <br>
        <BR>| DEACTIVATE USERS
        <br>You can deactivate users if they don't have a course on their list or don't teach a course. <br>
        <BR>| CHANGE SYSTEM PARAMETERS
        <br>You can change limitation criteria.<br>
        <BR>| GET USER STATISTICS REPORT
        <br>You can access to numerical data for active and deactivated users.<br>
    </div>
</div>

<script src="script.js"></script>


</body>
</html>