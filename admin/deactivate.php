<?php
ob_start();
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
    <title>ADMIN | DEACTIVATE USERS</title>
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
    <a href="deactivate.php" class="active">Deactivate Users</a>
    <a href="sysParameters.php">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>

<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:400px;border-radius:50px;margin-top:70px;">
    <form action="deactivate.php" method="post">
        <h1 style="">DEACTIVATE USERS</h1><br><br>
        <p>PROFESSORS</p><hr><br>
        <td>

            <select id="profName" name="profName" style="width:200px;" required>
                <?php //SELECT ALL ACTIVE PROFESSORS AND LIST THEM
                $db = new mysqli("127.0.0.1","root","","education_sys");
                $profs=$db ->query("SELECT * FROM users WHERE UserStatus = 'Active' AND UserType ='Professor';");
                while($prof_lastname=mysqli_fetch_row($profs)) {
                    echo "<option value='$prof_lastname[5]'>" . $prof_lastname[1] . " " . $prof_lastname[2] . "</option>";
                }
                echo "</select>";

                echo "<input type='submit' name='profSubmit' value='DEACTIVATE'>";
                echo" </form>";


                if(isset($_POST["profSubmit"])){
                    $profId = $_POST['profName'];  //CHECK IF THERE ARE ACTIVE COURSES !
                     $checkProf = $db -> query("SELECT c.course_name FROM courses c, users u WHERE u.uid = '$profId' AND u.Surname = c.course_professor;");
                     $check= $checkProf->fetch_assoc();

                     if ($check>0){
                         echo "You can't deactivate this professor because there are active courses given by him/her.";
                     }
                     else{
                         $result=$db ->query("UPDATE users  SET UserStatus='Deactivated' WHERE uid = '$profId'; ");
                         if($result){
                             echo "<p> This professor has been deactivated successfully.</p>";
                         }
                     }
                }
                ?>


        </td>
                <br><br><p>STUDENTS</p><hr><br>

        <td>
            <form action="deactivate.php" method="post">
            <select id="studentName" name="studentName"  style="width:200px;" required>
                <?php  //SELECT ACTIVE STUDENTS
                $db = new mysqli("127.0.0.1","root","","education_sys");
                $profs=$db ->query("SELECT * FROM users WHERE UserStatus = 'Active' AND UserType ='Student';");
                while($prof_lastname=mysqli_fetch_row($profs)){
                    echo "<option  value='$prof_lastname[5]'>" . $prof_lastname[1]. " " . $prof_lastname[2].  "</option>";
                }
                echo "<input type='submit' name='studSubmit' value='DEACTIVATE'>";
                echo" </form>";
                if(isset($_POST["studSubmit"])){
                    $studId = $_POST['studentName'];  //CHECK IF THERE ARE ACTIVE COURSES THEY ARE TAKING
                    $checkStud = $db -> query("SELECT s.courseid FROM studentscourses s WHERE s.studentid = '$studId';");
                    $check= $checkStud->fetch_assoc();
                    if ($check>0){
                        echo "You can't deactivate this student because there are courses present on his/her course list.";
                    }
                    else{
                        $result=$db ->query("UPDATE users  SET UserStatus='Deactivated' WHERE uid = '$studId'; ");
                        if($result){
                            echo "<p> This student has been deactivated successfully.</p>";
                            header('Refresh:3');
                        }
                    }

                }

                ?>
            </select>
        </td>

    <br><br>
</div>
</body>
</html>
