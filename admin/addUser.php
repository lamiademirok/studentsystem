<?php
ob_start();
session_start();
if($_SESSION["UserType"]!="Admin"){ //if user is not admin then go to other pages.
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
    <title>ADMIN | ADD COURSES</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../styleusrs.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
<div class="topnav">
    <a href="../admin/adminhome.php">Home</a>
    <a href="userList.php">Lists</a>
    <a class="active" href="../admin/addUser.php">Add User</a>
    <a  href="../admin/editCourses.php">Add Course</a>
    <a href="changePassword.php">Change Passwords</a>
    <a href="deactivate.php">Deactivate Users</a>
    <a href="sysParameters.php">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>

<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;border-radius:50px;margin-top:70px;min-height:400px;">

        <form id="member-inputs" action="addUser.php" method="post">
            <h1>ADD USER</h1><br>
            <input type="radio" name="user-type" value="1" checked><h4>Student</h4><br>
            <input type="radio" name="user-type" value="2"><h4>Professor</h4><br><br>
            <input  type="text" name="user-firstname" placeholder="Name" required>
            <input  type="text" name="user-lastname" placeholder="Surname" required>
            <input  type="text" name="username" placeholder="Username" required>
            <?php
            $db = new mysqli("127.0.0.1","root","","education_sys");
            //GET MaxPwd AND MinPwd VALUES TO USE AS CONSTRAINT FOR PASSWORD!!
            $getValues = $db -> query("SELECT MinPwd,MaxPwd FROM systemparameters WHERE adminName = 'lamia';");
            $valPwd = $getValues->fetch_assoc();
            //NOW LET'S DEFINE MIN AND MAX !
            $MinPwd = $valPwd['MinPwd'];
            $MaxPwd = $valPwd['MaxPwd'];
            echo "<input  type='password' name='user-password' placeholder='Password' maxlength='" . $MaxPwd .  "'minlength='". $MinPwd. "'required>";?>
            <input type="submit" name="submit" class="member-btn" value="Create">
        </form>

<?php
if(isset($_POST["submit"]))
{
    $user_firstname = $_POST["user-firstname"];
    $user_lastname = $_POST["user-lastname"];
    $user_password = $_POST["user-password"];
    $username=$_POST["username"];
    $radioVal = $_POST["user-type"];
    if($radioVal == 1){
        $user_type = "Student";
    } else if ($radioVal == 2){
        $user_type = "Professor";
    }
    if(($user_firstname!="")&&($user_lastname!="")&&($user_password!="")){
        $result=$db ->query("INSERT INTO users (rName, Surname,Username, Password, UserType) VALUES ('$user_firstname','$user_lastname','$username','$user_password', '$user_type')");
        if($result){
            echo "<p> New $user_type has been created.</p>";
            header('Refresh:1');

        }
    }
};
?>
</div>

</body>

</html>