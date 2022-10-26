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
    <title>STUDENT | CONSENTS</title>
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
    <a href ="askforconsent.php" class="active">Ask for Consent</a>
    <a href ="addRemoveCourse.php">Add/Remove Course</a>
    <a href ="viewCourse.php" >View Course List</a>
    <a href ="changePassStu.php" >Change Password</a>
    <a href ="../admin/logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;height:420px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>ASK FOR CONSENT</h1>
    <p>You can see courses that need consent listed.</p><br><br>
     <form action='askforconsent.php' method='POST'>
    <?php
    $db = new mysqli("127.0.0.1","root","","education_sys");
    $uvalue= $_SESSION["Username"];
    $coursesThatNeedConsent = $db-> query("SELECT course_code FROM courses WHERE course_consent = 'Required' ;");

            echo  "Course Code<br>";
            echo "<select name='course' style='color:black;width:150px;height:30px;'required>";
                        while($consentList=mysqli_fetch_row($coursesThatNeedConsent)) {
                        echo  "<option value ='$consentList[0]'>" . $consentList[0] . "</option>";
                        }
    ?>
    </select><br><br>
    Your Message<br>
  <textarea maxlength="50" rows="4" cols="40" style="color:black;" name="yrMessage" placeholder="Briefly explain why you want to take this course." required></textarea><br>
    <br><input type='submit' name='submitConsent' value='SUBMIT' style="color:black;font-weight: bolder;">
    </form>
</div>
<?php
if(isset($_POST["submitConsent"]))
{
    $whichCourse = $_POST['course'];
    $yourMessage = $_POST['yrMessage'];
    //WE GOT INFORMATION OF COURSE CODE BUT WE HAVE ID ON CONSENTS TABLE. SO WE HAVE TO FIND IT VIA QUERY.
    $findCourseId = $db ->query("SELECT courseid FROM courses WHERE course_code = '$whichCourse'");
    $courseId = $findCourseId->fetch_assoc();
    $course = $courseId['courseid'];

    if (query("SELECT courseid,studentid FROM consents "))
    //NOW WE ALSO HAVE TO FIND STUDENT ID BY SESSION VARIABLE AND QUERY
    $username = $_SESSION["Username"];
    $findStudentId = $db -> query("SELECT uid FROM users WHERE Username = '$username';");
    $studentId = $findStudentId ->fetch_assoc();
    $enterId = $studentId['uid'];
    //now insert the consent to list
    $addToList = $db ->query("INSERT INTO consents(studentid,courseid,message) VALUES ('$enterId','$course' ,'$yourMessage')");
    if($addToList){
        echo "Your consent request has been sent.";
    }
    else{
        "An error has occured. Please try again.";
    }

}
    ?>
</body>
</html>
