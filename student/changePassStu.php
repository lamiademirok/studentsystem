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
    <title>STUDENT | CHANGE PASSWORD</title>
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
    <a href ="viewCourse.php">View Course List</a>
    <a href ="changePassStu.php" class="active">Change Password</a>
    <a href ="../admin/logout.php">Logout</a>



</div>

<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:420px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>CHANGE PASSWORD</h1><br>

    <div style="margin: 0 auto;border-radius:10px;padding:50px;border: 1px solid white;">
        <form id="changePassStu" action = "changePassStu.php" method="POST">
            <h5>CURRENT PASSWORD</h5>
            <input type="text" id="oldPass" name="oldPass" placeholder="Current Password" required><br><br>
            <h5>NEW PASSWORD</h5>
            <?php
            $db = new mysqli("127.0.0.1","root","","education_sys");
            //GET MaxPwd AND MinPwd VALUES TO USE AS CONSTRAINT FOR PASSWORD!!
            $getValues = $db -> query("SELECT MinPwd,MaxPwd FROM systemparameters WHERE adminName = 'lamia';");
            $valPwd = $getValues->fetch_assoc();
            //NOW LET'S DEFINE MIN AND MAX !
            $MinPwd = $valPwd['MinPwd'];
            $MaxPwd = $valPwd['MaxPwd'];
            //I ADDED THIS CONSTRAINT ONLY TO THE NEW PASSWORD BECAUSE OLD PASSWORD IS ALREADY IN THE CORRECT FORMAT, IT IS CHECKED LATER ON THIS PAGE
            echo "<input  type='text' name='newPass' id='newPass' placeholder='New Password' maxlength='" . $MaxPwd .  "'minlength='". $MinPwd. "'required>";
            ?>
            <br>
            <br>
            <input id="submit" name="submit" type="submit" value="SUBMIT" style="background-color:black;color:white;font-weight:bolder;padding:5px;">
        </form>
    </div>
    <?php
    if(isset($_POST["submit"])) {
        $oldPassword = $_POST["oldPass"];
        $newPassword = $_POST["newPass"];
        $currUname = $_SESSION["Username"];

        $db = new mysqli("127.0.0.1", "root", "", "education_sys");
        $selectPass = $db->query("SELECT Password FROM users WHERE Username = '$currUname'");
        $row = $selectPass->fetch_assoc();

        if (($oldPassword != $newPassword) && ($oldPassword == $row['Password'])) {
            $result= $db->query("UPDATE users SET Password='$newPassword' WHERE Password = '$oldPassword' AND Username = '$currUname'");
            if($result) {
                echo "<p>Password has been changed successfully.</p>";
            }
        }
        else if($oldPassword != $row['Password']){
            echo "<p>Your current password is not correct.</p>";
        }
        else {
            echo "<p>New password has to be different from the old one.</p>";
        }

    }
    ?>

</div>
</body>
</html>
