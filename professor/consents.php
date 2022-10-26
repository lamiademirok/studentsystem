<?php
ob_start();
session_start();

if ($_SESSION["UserType"] != "Professor") {
    //if not Admin
    if ($_SESSION["UserType"] == "Admin") {
        header("Location: ../admin/adminhome.php");
    } else if (($_SESSION["UserType"] == "Student")) {
        header("Location: ../student/studentMain.php");
    } else {
        header("Location: index.php");
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PROFESSORS | CONSENTS</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styleusrs.css">
    <style>
        button{
            background-color:black;
            font-weight:bolder;
            padding:5px;
        }
    </style>
</head>
<body>


<?php
$db = new mysqli("127.0.0.1","root","","education_sys");

?>
<div class="topnav">
    <a  href="professorMain.php">Home</a>
    <a href ="consents.php" class="active">Consent Requests</a>
    <a href="list.php">Course and Student List</a>
    <a href="submitGrades.php">Submit Grades</a>
    <a href="changePass.php">Change Password</a>
    <a href="../admin/logout.php">Logout</a>
</div>
<div style="background-color:rgba(0,0,0,.5);padding:50px;margin:50px;min-height:400px;border-radius:50px;margin-top:70px;font-weight:bolder;">
    <h1>CONSENT REQUESTS</h1><br>

    <?php
    $value = $_SESSION["Username"];
    //SELECT ALL THE CONSENTS THAT BELONG TO THE PROFESSOR THAT IS LOGGED IN!
    $result = $db ->query("SELECT con.consentid, con.studentid, con.courseid, con.result, c.course_professor,c.course_name,con.message,c.course_code,u.rName, u.Surname FROM consents con,courses c, users u  WHERE c.courseid = con.courseid AND c.course_professor = u.Surname AND u.Username= '$value' AND result = 0;");

    echo "<form action='consents.php' method='post'>";
    echo "<table style='width:900px;padding:5px;margin:0 auto;text-align:center;'>";
    echo  "<tr style='text-decoration: underline; font-size:19px;'><td>Consent ID</td><td>Student ID</td><td>Course Name</td><td>Message</td></tr>";
    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr>"
            ."<td>" .$row["consentid"]. "</td>"
            ."<td>" .$row["studentid"]. "</td>"
            ."<td>" .$row["course_code"]. "</td>"
            ."<td>" .$row["message"]. "</td>"
            ."</tr>";
    }
    echo "</table>";

    echo "<br><br><h5>Select the CONSENT ID of the consent you want to accept or reject.</h5>";
    //SELECT ALL THE CONSENT ID'S TO BE LISTED FOR THE CONSTRUCTOR TO ACCEPT OR REJECT.
    $chooseCon = $db ->query("SELECT con.consentid,con.courseid FROM consents con,courses cr,users u WHERE cr.courseid = con.courseid  AND cr.course_professor = u.Surname AND u.Username = '$value' AND con.result ='0'");


    echo"<br>";
    echo "<select name='consChoose' required>";
                    while($consChoose=mysqli_fetch_row($chooseCon)){
                        echo "<option value='$consChoose[0]'>" . $consChoose[0] . "</option>";
                        $courseId = $consChoose[1];
                    }
                    echo "</select>";


                    echo "<input id='acceptBtn' name='accept' type='submit' value='ACCEPT' style='background-color:black;color:white;font-weight:bolder;padding:5px;'>";
    echo "<input id='rejectBtn' name='reject' type='submit' value='REJECT' style='background-color:black;color:white;font-weight:bolder;padding:5px;'>";

    echo "</form>";
    echo "<br>";
    if(isset($_POST["accept"])) {
         // This is to use in queries for checking.
        $getConsentNumber = $_POST['consChoose'];
        //CHECK FOR COURSE QUOTA FIRST !!
        $checkQuota = $db->query("SELECT course_quota FROM courses WHERE courseid='$courseId'");
        $courseQuota = $checkQuota->fetch_assoc();
        $quota = $courseQuota['course_quota'];

        //CALCULATE STUDENTS THAT WERE GIVEN CONSENT!!
        $checkStuds = $db ->query("SELECT COUNT(*) AS NumOfStud FROM consents WHERE courseid = 'courseId' AND result ='1' ");
        $studentsOfCourse = $checkStuds->fetch_row();
        $taken = $studentsOfCourse[0];

        if($quota>$taken){
            $acceptReq = $db->query("UPDATE consents SET result ='1' WHERE consentid ='$getConsentNumber'");
            if($acceptReq){
                header('Refresh:1');
                echo "<p>Consent request has been accepted.</p>";

            }
            else{
                echo "An error has occured.";
            }
        }
    }

    if(isset($_POST["reject"])) {
        //WE GET THE CONSENT NUMBER TO REJECT!
        $getConsentNumber = $_POST['consChoose'];

        //WE DON'T NEED TO CHECK QUOTA, JUST REJECT IT!
            $rejectReq = $db->query("UPDATE consents SET result ='-1' WHERE consentid ='$getConsentNumber'");
            if($rejectReq){
                header('Refresh:2');
                echo "<p>Consent request has been rejected.</p>";
            }
            else{
                echo "An error has occured.";
            }
        }

    ?>
</div>

</body>
</html>