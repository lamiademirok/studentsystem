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
    <title>ADMIN | ADD COURSES</title>
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
    <a class="active" href="../admin/editCourses.php">Add Course</a>
    <a href="changePassword.php">Change Passwords</a>
    <a href="deactivate.php">Deactivate Users</a>
    <a href="sysParameters.php">Change System Parameters</a>
    <a href="getUserStats.php">Get User Statistics Report</a>
    <a href="logout.php">Logout</a>
</div>

<?php
$db = new mysqli("127.0.0.1","root","","education_sys");
$profs=$db ->query("SELECT * FROM users WHERE UserType = 'Professor'"); //SELECT ALL PROFS
$num_of_profs = $profs->num_rows;


?>
<br>
<div id="textAr" style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;border-radius:50px;min-height: 400px;">
<h1>ADD COURSE</h1><br>
<form action="editCourses.php" method="post">

    <table id="course" style="text-align: center; margin: 0 auto;">
        <tr>
            <td>Course Code</td>
            <td>Course Name</td>
            <td>Professor</td>
            <td>Description</td>
            <td>Quota</td>
            <td>Final Date</td>
            <td>Consent</td>
        </tr>
        <tr>
            <td>
                <input type="text" id="courseCode" name="courseCode" placeholder="MIS131" required>


            </td>
            <td><input type="text" id="courseName" name="courseName" placeholder="Introduction to.." required>
            </td>
            <td>
                <select id="courseProfessor" name="courseProfessor" required>
                    <?php
                    while($prof_lastname=mysqli_fetch_row($profs)){ //GET LAST NAMES OF PROFS
                        echo "<option value='$prof_lastname[2]'>" . $prof_lastname[1]. " " .  $prof_lastname[2] . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type="text" id="courseDesc" name="courseDesc" placeholder="Coding..." required></td>
            <td><input type="number" id="courseQuota" name="courseQuota" placeholder="65" required></td>
            <td><input type="date" id="courseFinal" name="courseFinal" required></td>
            <td>
                <select name="courseConsent" required>
                    <option value="0">Not Required</option>
                    <option value="1">Required</option>
                </select>
            </td>
            <td><input id="submit" name="submit" type="submit" value="Add"></td>
        </tr>
    </table>
</form>
<br>
<!--COURSES LIST--->
<table style="text-align: center; margin: 0 auto;background-color:black;" border="4">
    <b>COURSES<b>
    <?php
    $courses=$db ->query("SELECT * FROM courses"); //GET ALL COURSES
    echo  "<tr><td>Course Code</td><td>Course Name</td><td>Professor</td><td>Description</td><td>Quota</td><td>Final Date</td><td>Consent</td>
        </tr>";

    while($course_list=mysqli_fetch_row($courses)){
   echo "<tr>"
            ."<td height='35'>".$course_list[0].
       "<td>".$course_list[1]. "</td>" //prof name
            ."<td>".$course_list[2]. "</td>"
            ."<td>".$course_list[3]. "</td>"
            ."<td>".$course_list[4]. "</td>"
            ."<td>".$course_list[5]. "</td>"
            ."<td>".$course_list[6]. "</td>"
            ."</tr>";
    }
    ?>
</table>
</div>



<?php
if(isset($_POST["submit"]))
{ //GET ALL THE INFO GIVEN ABOUT THE COURSE AND INSERT IT TO THE TABLE
    $course_code=$_POST["courseCode"];
    $course_name= $_POST["courseName"];
    $course_prof= $_POST["courseProfessor"];
    $course_description= $_POST["courseDesc"];
    $course_quota= $_POST["courseQuota"];
    $course_finaldate= $_POST["courseFinal"];
    $consent_choice= $_POST["courseConsent"];

    if($consent_choice == 0){
        $course_consent = "Not required";
    } else{
        $course_consent = "Required";
    }

        $db = new mysqli("127.0.0.1","root","","education_sys");
        $result=$db ->query("INSERT INTO courses (course_code,course_name, course_professor, course_info, course_quota, course_finaldate, course_consent)
                                    VALUES ('$course_code','$course_name','$course_prof','$course_description', '$course_quota', '$course_finaldate', '$course_consent')");
        if($result){
            echo "<p> $course_code has been created successfully!</p>";
            echo header('Refresh:1');
        }

};
?>
</body>
</html>
