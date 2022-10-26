<?php
session_start();
if($_SESSION["UserType"]!="Professor"){ //if not PROF
    if($_SESSION["UserType"]=="Admin"){
        header("Location: ../admin/adminhome.php");
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
    <title>PROFESSOR | HOME</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

</head>
<body>
<div class="topnav">
    <a class="active" href="professorMain.php">Home</a>
    <a href ="consents.php">Consent Requests</a>
    <a href="list.php">Course and Student List</a>
    <a href="submitGrades.php">Submit Grades</a>
    <a href="changePass.php">Change Password</a>
    <a href="../admin/logout.php">Logout</a>
</div>

<div style="font-weight: bolder">
    <h1 style="font-size:50px;color:dimgrey;margin-top:50px;">PROFESSOR</h1>
    <h2 style="font-size:40px;">USER MANUAL</h2>
    <br>
    <div style="text-align:left;border-radius:50px;background-color:#ababab;margin-left:500px;margin-right:500px;color:black;padding:45px;">
        <br>| LIST OF USERS
        <br>You can access to list of all users including professors and students<br>
        <br>| CONSENT REQUESTS
        <br>You can accept/reject requests of students<br>
        <br>| SUBMIT GRADES
        <br>You can submit grades according to courses<br>
        <BR>| CHANGE PASSWORD
        <br>You can change your password. <BR>

    </div>
</div>

<script src="script.js"></script>


</body>
</html>