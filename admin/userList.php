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
    <title>ADMIN | LISTS</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

    <style>
        .lists{
            font-weight: bold;
            background-color:black;
            border:1px solid white;
            color:white;
            padding:20px;
            width:150px;
        }
        .lists:hover{
            cursor:pointer;
        }
    </style>
</head>
<body>
<div class="topnav">
    <a href="../admin/adminhome.php">Home</a>
    <a href="userList.php" class="active">Lists</a>
    <a href="../admin/addUser.php">Add User</a>
    <a  href="../admin/editCourses.php">Add Course</a>
    <a  href="changePassword.php">Change Passwords</a>
    <a href="deactivate.php">Deactivate Users</a>
    <a href="sysParameters.php">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;border-radius:50px;margin-top:70px;min-height: 400px;">
    <h1>LISTS</h1><br>
    <p>Click on the list name you want to view</p><br>
    <form action="userList.php" method="post">
        <input type="submit" name="submitProf" class="lists" value="PROFESSORS">
        <input type="submit" name="submitStudent" class="lists" value="STUDENTS">
        <input type="submit" name="submitCourse" class="lists" value="COURSES">
    </form>


<?php
//FIND ALL THE PROFESSORS
$db = new mysqli("127.0.0.1","root","","education_sys");
if(isset($_POST["submitProf"])){
    echo '<table style="text-align: center; margin: 0 auto;background-color:black;" border="4"><br>';
    $profList=$db ->query("SELECT * FROM users WHERE UserType = 'Professor'");
    echo  "<tr><td>User Type</td><td>Name</td><td>Surname</td><td>Username</td><td>Password</td><td>User ID</td><td>Status</td>
        </tr>";
    while($fullNames=mysqli_fetch_row($profList)){
        echo "<tr>"
            ."<td height='35'>".$fullNames[0].
            "<td>".$fullNames[1]. "</td>" //prof name
            ."<td>".$fullNames[2]. "</td>"
            ."<td>".$fullNames[3]. "</td>"
            ."<td>".$fullNames[4]. "</td>"
            ."<td>".$fullNames[5]. "</td>"
            ."<td>".$fullNames[6]. "</td>"
            ."</tr>";

    }
}
if(isset($_POST["submitStudent"])){
    echo '<table style="text-align: center; margin: 0 auto;background-color:black;" border="4"><br>';
//FIND ALL THE STUDENTS
    $studList=$db ->query("SELECT * FROM users WHERE UserType = 'Student'");
    echo  "<tr><td>User Type</td><td>Name</td><td>Surname</td><td>Username</td><td>Password</td><td>User ID</td><td>Status</td>
        </tr>";
    while($fullNames=mysqli_fetch_row($studList)){
        echo "<tr>"
            ."<td height='35'>".$fullNames[0].
            "<td>".$fullNames[1]. "</td>" //prof name
            ."<td>".$fullNames[2]. "</td>"
            ."<td>".$fullNames[3]. "</td>"
            ."<td>".$fullNames[4]. "</td>"
            ."<td>".$fullNames[5]. "</td>"
            ."<td>".$fullNames[6]. "</td>"
            ."</tr>";

    }
}

if(isset($_POST["submitCourse"])){
    echo '<table style="text-align: center; margin: 0 auto;background-color:black;" border="4"><br>';
//FIND ALL THE COURSES
    $profList=$db ->query("SELECT * FROM courses ");
    echo  "<tr><td>Course Code</td><td>Professor</td><td>Course Name</td><td>Course Info</td><td>Course Quota</td><td>Course Final Date</td><td>Course Consent</td>
        </tr>";
    while($fullNames=mysqli_fetch_row($profList)){
        echo "<tr>"
            ."<td height='35'>".$fullNames[0].
            "<td>".$fullNames[1]. "</td>" //prof name
            ."<td>".$fullNames[2]. "</td>"
            ."<td>".$fullNames[3]. "</td>"
            ."<td>".$fullNames[4]. "</td>"
            ."<td>".$fullNames[5]. "</td>"
            ."<td>".$fullNames[6]. "</td>"
            ."</tr>";

    }
}


echo '</table>';



?>
</div>
</body>
</html>

