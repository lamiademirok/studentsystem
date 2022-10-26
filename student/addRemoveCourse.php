<?php
ob_start();
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
$db = new mysqli("127.0.0.1","root","","education_sys");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>STUDENT | ADD COURSE</title>
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
    <a href ="askforconsent.php" >Ask for Consent</a>
    <a href ="addRemoveCourse.php" class="active">Add/Remove Course</a>
    <a href ="viewCourse.php" >View Course List</a>
    <a href ="changePassStu.php" >Change Password</a>
    <a href ="../admin/logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;min-height:420px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>ADD/REMOVE COURSES</h1>
    <?php
    #GET MAXSTUCOURSE VALUE TO SHOW STUDENTS HOW MANY COURSES THEY CAN HAVE IN TOTAL
    $getMax = $db -> query("SELECT MaxStuCourse FROM systemparameters WHERE adminName='lamia'");
    $getMaxVal = $getMax->fetch_assoc();
    $MaxStuCourse = $getMaxVal['MaxStuCourse'];
   echo "<p>You can be enrolled in maximum $MaxStuCourse courses.</p>";
   ?>
    <br>
    <p>ADD COURSE</p>
    <hr><br>
    <?php
    //NOW WE ALSO HAVE TO FIND STUDENT ID BY SESSION VARIABLE AND QUERY
    $username = $_SESSION["Username"];
    $findStudentId = $db -> query("SELECT uid FROM users WHERE Username = '$username';");
    $studentId = $findStudentId ->fetch_assoc();
    $enterId = $studentId['uid'];
   //HERE ARE DISPLAYED ALL COURSES THAT DON'T NEED CONSENT AND ARE NOT ON THE STUDENT'S COURSE PAGE AT THIS MOMENT!!
    $getAllCourses = $db ->query("SELECT course_code,courseid FROM courses
                          WHERE course_consent = 'Not required' AND course_code NOT IN(SELECT cr.course_code
     					  FROM studentscourses s, courses cr 
     					  WHERE s.studentid = '$enterId' 
       					  AND s.courseid = cr.courseid);");
    echo "<br><form action ='addRemoveCourse.php' METHOD ='POST'>";
    echo "<select style ='color:black;height:27px;' name='notYrCourses'>";
    while($notYrCourses=mysqli_fetch_row($getAllCourses)) {
        echo  "<option value ='$notYrCourses[1]' >" . $notYrCourses[0] . "</option>";
    }
    echo"</select>";
            echo"<input type='submit' value='ADD' name='addCourse' style='height:27px;'></form>";
    ?>
    <br><br>
    <p>YOUR APPROVED CONSENT REQUESTS</p>
    <hr><br>
    <?php
    //NOW WE ALSO HAVE TO FIND STUDENT ID BY SESSION VARIABLE AND QUERY
    $getConsents = $db ->query("SELECT cr.course_code, cr.courseid FROM courses cr, consents con WHERE con.courseid = cr.courseid AND con.result ='1' AND con.studentid ='$enterId' AND course_code NOT IN(SELECT cr.course_code
     					  FROM studentscourses s, courses cr 
     					  WHERE s.studentid = $enterId 
       					  AND s.courseid = cr.courseid);");

        echo "<br><form action ='addRemoveCourse.php' METHOD ='POST'>";
        echo "<select style ='color:black;height:27px;' name='getApproved'>";
    while($getApproved=mysqli_fetch_row($getConsents)){
        echo "<option value = '$getApproved[1]' >" . $getApproved[0] . "</option>";
        } echo "</select>";
        echo"<input type='submit' value='ADD' name='addCourseFromConsent' style='height:27px;'></form>";
    ?>
    <br><br>
    <p>REMOVE COURSES</p>
    <hr><br>
    <?php
    //NOW WE HAVE TO FIND THE COURSES THAT ARE CURRENTLY ON THE LIST AND SHOW THEM FOR DELETING.

    $presentCourses = $db ->query("SELECT cr.course_code, cr.courseid FROM courses cr, studentscourses s WHERE s.studentid ='$enterId' AND s.courseid = cr.courseid;");
    //LIST COURSES TO REMOVE.
    echo "<br><form action ='addRemoveCourse.php' METHOD ='POST'>";
    echo "<select style ='color:black;height:27px;' name='presentCr' id='present' >";
    while($presCourses = mysqli_fetch_row($presentCourses)){
        echo "<option value= '$presCourses[1]' >" . $presCourses[0] . "</option>";
    }    echo "</select>";
    echo"<input type='submit' value='REMOVE' name='removeCourse' style='height:27px;'></form>";

    ?>

    <?php
    // NEED TO COUNT HOW MANY COURSES THE STUDENT HAS. MAXIMUM IS 5.
    $howManyCourses = $db->query("SELECT COUNT(*) as NumOfCourses FROM studentscourses s WHERE s.studentid ='$enterId';");
    $countCourses = $howManyCourses->fetch_assoc();
    // HOW MANY -> $countCourses['NumOfCourses'];
    // WE ALSO MUST HAVE QUOTA RESTRICTION !!!!!! IF THE STUDENT

    //IF NORMAL ADD COURSE IS SUBMITTED
    if(isset($_POST["addCourse"])){
        $courseToAdd = $_POST['notYrCourses'];
        //IF THE PRESENT COURSE NUMBER OF THIS USER IS LESS THAN MAXIMUM VALUE, NEW COURSE CAN BE ADDED TO LIST. ELSE, SHOW ERROR.
        if($countCourses['NumOfCourses']<$MaxStuCourse) {
            $addToCourseList = $db->query("INSERT INTO studentscourses (studentid,courseid) VALUES('$enterId','$courseToAdd');");
            if($addToCourseList){
                echo "This course has been added to your list successfully.Check your Course List!";
                header('Refresh:2');

            }
            else{
                echo"An error has occured.";
            }
        }
        else{
            echo "You can have maximum " . $MaxStuCourse . " courses on your list.";
        }
    }


    //IF YOU WANT TO ADD COURSE FROM YOUR APPROVED CONSENT REQUESTS
    if(isset($_POST["addCourseFromConsent"])){
        $courseReq = $_POST['getApproved'];
        //IF THE PRESENT COURSE NUMBER OF THIS USER IS LESS THAN MAXIMUM VALUE, NEW COURSE CAN BE ADDED TO LIST. ELSE, SHOW ERROR.
        if($countCourses['NumOfCourses']<$MaxStuCourse) {
            $addToCourseList = $db->query("INSERT INTO studentscourses (studentid,courseid) VALUES('$enterId','$courseReq');");
            if($addToCourseList){
                echo "This course has been added to your list successfully.Check your Course List!";
                header('Refresh:1');
            }
            else{
                echo"An error has occured.";
            }
        }
        else{
            echo "You can have maximum " . $MaxStuCourse . " courses on your list.";
        }
    }


    //REMOVE COURSES FROM YOUR LIST
    if(isset($_POST["removeCourse"])){

        $CanDelete = $_POST['presentCr'];
        //IF THE PRESENT COURSE NUMBER OF THIS USER IS LESS THAN MAXIMUM VALUE, NEW COURSE CAN BE ADDED TO LIST. ELSE, SHOW ERROR.

            $delCourse = $db->query("DELETE FROM studentscourses WHERE  studentid = '$enterId' AND courseid= '$CanDelete';");
            if($delCourse){
                echo "This course has been deleted from your list sucessfully. Check your course list!";
                header('Refresh:1');

            }
            else{
                echo"An error has occured.";
            }


    }

    ?>
</div>
</body>
</html>
