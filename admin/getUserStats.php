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
    <title>ADMIN | STATS</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">

</head>
<body>
<div class="topnav">
    <a href="../admin/adminhome.php">Home</a>
    <a href="userList.php">Lists</a>
    <a href="../admin/addUser.php">Add User</a>
    <a href="../admin/editCourses.php">Add Course</a>
    <a href="changePassword.php">Change Passwords</a>
    <a href="deactivate.php">Deactivate Users</a>
    <a href="sysParameters.php" >Change System Parameters</a>
    <a href="getUserStats.php" class="active">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>
<?php


$db = new mysqli("127.0.0.1","root","","education_sys");

//IN THESE QUERIES I SELECT ACTIVE AND DEACTIVATED USERS ACCORDING TO THEIR USERTYPE!
?>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:400px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>USER STATISTICS</h1>
    <br><br>
    <div style="width:300px;margin: 0 auto;text-align:left;padding:9px;border-radius:10px;padding:50px;border: 1px solid white;">
    <p>PROFESSORS</p>
        <hr>
    <p>Active:
        <?php   $userStat=$db ->query("SELECT * FROM users WHERE UserType = 'Professor' AND UserStatus='Active'");
        $num_of_active = $userStat->num_rows;

        echo " $num_of_active ";
        ?>
    </p>
    <p>Deactivated:
        <?php   $userStat=$db ->query("SELECT * FROM users WHERE UserType = 'Professor' AND UserStatus='Deactivated'");
        $num_of_active = $userStat->num_rows;
        echo " $num_of_active ";
        ?>
    </p>
        <br>
        <p>STUDENTS</p>
        <hr>
        <p>Active:
            <?php   $userStat=$db ->query("SELECT * FROM users WHERE UserType = 'Student' AND UserStatus='Active'");
            $num_of_active = $userStat->num_rows;
            echo " $num_of_active ";
            ?></p>
        <p>Deactivated:
            <?php   $userStat=$db ->query("SELECT * FROM users WHERE UserType = 'Student' AND UserStatus='Deactivated'");
            $num_of_active = $userStat->num_rows;
            echo " $num_of_active ";
            ?>
        </p>
    </div>
</div>
</body>
</html>
