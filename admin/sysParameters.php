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
    <title>ADMIN | PARAMETERS</title>
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
    <a href="sysParameters.php" class="active">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>

<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:400px;border-radius:50px;margin-top:70px;">
    <form action="sysParameters.php" method="post">
        <h1 style="">CHANGE SYSTEM PARAMETERS</h1><br><br>
        <input  type="text" name="minPwd" placeholder="MinPwd" required>
        <input  type="text" name="maxPwd" placeholder="MaxPwd" required>
        <input  type="text" name="maxCourse" placeholder="MaxCourse" required>
        <input  type="text" name="maxStuCourse" placeholder="MaxStuCourse" required>
        <input  type="text" name="maxProfCourse" placeholder="MaxProfCourse" required>
        <input type="submit" name="submit" class="member-btn" value="Update">
    </form>
    <br><br>
<?php
if(isset($_POST["submit"]))
{ //GET ALL INPUTTED PARAMETERS
    $min_pwd = $_POST["minPwd"];
    $max_pwd = $_POST["maxPwd"];
    $max_course = $_POST["maxCourse"];
    $max_stu_course=$_POST["maxStuCourse"];
    $max_prof_course = $_POST["maxProfCourse"];
      //UPDATE PARAMETERS ON THE TABLE
        $db = new mysqli("127.0.0.1","root","","education_sys");
        $result=$db ->query("UPDATE systemparameters SET MaxPwd=$max_pwd, MinPwd=$min_pwd, MaxCourse=$max_course, MaxStuCourse=$max_stu_course,MaxProfCourse= $max_prof_course WHERE adminName ='lamia';");
        if($result){
            echo "Parameters have been updated.";
            echo "<br><br><h4> Current Parameters:</h4><br>";
        }
//THIS IS KEY OF THE TABLE THAT I WROTE
$result = $db -> query("SELECT * FROM systemparameters WHERE adminName='lamia'");

echo "<table style='text-align: center; margin: 0 auto;background-color:black;' border='4'>"; // start a table tag in the HTML
echo  "<tr><td>MinPwd</td><td>MaxPwd</td><td>MaxCourse</td><td>MaxStuCourse</td><td>MaxProfCourse</td>
        </tr>";
while($row = mysqli_fetch_assoc($result)){   //Creates a loop to loop through results
    echo "<tr><td>" . $row['MinPwd'] . "</td><td>"
        . $row['MaxPwd'] . "</td><td>"
        .$row['MaxCourse'] . "</td><td>"
        .$row['MaxStuCourse'] . "</td><td>"
        .$row['MaxProfCourse'] . "</td></td></tr>";
}

echo "</table>";
}

    ?>


</div>
</body>
</html>