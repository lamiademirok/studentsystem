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
    <title>ADMIN | CHANGE PASSWORDS</title>
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
    <a  href="../admin/editCourses.php">Add Course</a>
    <a class="active" href="changePassword.php">Change Passwords</a>
    <a href="deactivate.php">Deactivate Users</a>
    <a href="sysParameters.php">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>
<?php
//GET DATABASE AND ALSO LISTS OF USERS ACCORDING TO THEIR TYPES.
$db = new mysqli("127.0.0.1","root","","education_sys");
$profList=$db ->query("SELECT * FROM users WHERE UserType = 'Professor'");
$studentList=$db ->query("SELECT * FROM users WHERE UserType = 'Student'");
$admin =$db ->query("SELECT * FROM users WHERE UserType='Admin'");

//GET MaxPwd AND MinPwd VALUES TO USE AS CONSTRAINT FOR PASSWORD!!
$getValues = $db -> query("SELECT MinPwd,MaxPwd FROM systemparameters WHERE adminName = 'lamia';");
$valPwd = $getValues->fetch_assoc();
//NOW LET'S DEFINE MIN AND MAX !
$MinPwd = $valPwd['MinPwd'];
$MaxPwd = $valPwd['MaxPwd'];

?>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;border-radius:50px;margin-top:70px;min-height: 400px;">
    <h1>CHANGE PASSWORD</h1><br>

    <form action="changePassword.php" method="post">
        <p>PROFESSORS</p>

        <table id="changPass" style="text-align: center; margin: 0 auto;">
            <hr>
            <tr>
                <td>User</td>
                <td>New Password</td>

            </tr>
            <tr>
<br>
                <td>
                    <select id="profUname" name="profUname" style="width:220px;" required>
                        <?php
                        while($fullNames=mysqli_fetch_row($profList)){
                            echo "<option value='$fullNames[3]'>" . $fullNames[3]. "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <?php
                    echo "<input  type='text' name='newPassProf' id='newPassProf' placeholder='New Password' maxlength='" . $MaxPwd .  "'minlength='". $MinPwd. "'required>";
                    ?>
                </td>

                <td><input id="submitProf" name="submitProf" type="submit" value="SUBMIT"></td>
            </tr>
        </table>
    </form>
    <br><br><p>STUDENTS</p>
    <form action="changePassword.php" method="post">
    <table id="changPass" style="text-align: center; margin: 0 auto;">

        <hr>
        <tr>
            <td>User</td>
            <td>New Password</td>

        </tr>
        <tr>
            <br>
            <td>
            <select id="studentUname" name="studentUname"  style="width:220px;" required>
                <?php
                while($fullNames=mysqli_fetch_row($studentList)){
                    echo "<option value='$fullNames[3]'>" . $fullNames[3]. "</option>";
                }
                ?>
            </select>
        </td>
            <td>
                <?php
                echo "<input  type='text' name='newPassStu' id='newPassStu' placeholder='New Password' maxlength='" . $MaxPwd .  "'minlength='". $MinPwd. "'required>";
                ?>

            </td>
        <td><input id="submitStu" name="submitStu" type="submit" value="SUBMIT"></td>
        </tr>
        </table>
    </form>
        <br><br><p>ADMIN</p>
    <form action="changePassword.php" method="post">
        <table id="changPass" style="text-align: center; margin: 0 auto;font-weight:bold;color:black;">
            <hr>
            <tr>
                <td>User</td>
                <td>New Password</td>

            </tr>
            <tr>
                <br>
                <td>
                    <select id="adminUname" name="adminUname"  style="width:220px;" required>
                        <?php
                        while($fullNames=mysqli_fetch_row($admin)){
                            echo "<option value='$fullNames[3]'>" . $fullNames[3]. "</option>";
                        }
                        ?>
                    </select>
                </td>

                <td>
                    <?php
                    echo "<input  type='text' name='newPassAdmin' id='newPassAdmin' placeholder='New Password' maxlength='" . $MaxPwd .  "'minlength='". $MinPwd. "'required>";
                    ?>
                </td>
                <td><input id="submitAdmin" name="submitAdmin" type="submit" value="SUBMIT"></td>

            </tr>
        </table>
    </form>

<?php

if(isset($_POST["submitProf"])){
    $profUname = $_POST["profUname"]; // GET USERNAME
    $newPassProf = $_POST["newPassProf"]; //GET NEW PASSWORD OF THE PROFESSOR
    $insertQuery = $db->query("UPDATE users SET Password = '$newPassProf'  WHERE Username='$profUname'"); //SET PASS WHERE USERNAME EQUALS
    if ($insertQuery) {
        echo "<br>The password of " . $profUname . " has been changed successfully.<br>";
        header('Refresh:3');
    }


}

if(isset($_POST["submitStu"])){
    $studUname = $_POST["studentUname"]; //STUDENT USERNAME
    $newPassStud = $_POST["newPassStu"]; //NEW PASSWORD FOR STUDENT
    $insertQuery = $db->query("UPDATE users SET Password = '$newPassStud'  WHERE Username='$studUname'"); //SET PASS WHERE USERNAME EQUALS
    if ($insertQuery) {
        echo "<br>The password of " . $studUname . " has been changed successfully.<br>";
        header('Refresh:3');
    }


}


if (isset($_POST["submitAdmin"])) {

    $adm_Uname = $_POST["adminUname"];  //ADMIN USERNAME
    $newPass = $_POST["newPassAdmin"];  //NEW PASS FOR ADMIN
    $insertQuery = $db->query("UPDATE users SET Password = '$newPass'  WHERE Username='$adm_Uname'"); //SET PASS WHERE USERNAME EQUALS
    if ($insertQuery) {
        echo "<br>The password of " . $adm_Uname . " has been changed successfully.<br>";
        header('Refresh:3');
    }

}


?>
</div>
</body>
</html>