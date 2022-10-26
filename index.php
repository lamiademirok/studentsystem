<?php
session_start();

?>
<html lang="en">
<head>
<title>Student System</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
<nav>
   <b> <a href ="#" id="home" style="text-decoration:underline;">Home</a></b>
   <b> <a href="#first" id ="login">Login</a></b>
</nav>
<div class= 'container' style="color:white;text-align:center;">
    <div style="padding:130px;">
        <p style="font-size:10px;text-align:left;">by Lamia Demirok</p>
        <h1 style="font-size:10vw;color:white;">Welcome</h1>
        <p>Login to access our system</p>
    </div>
    <section id= 'first'>
        <form action="index.php" method="post" id ="loginForm">
        <h1>LOGIN</h1><br>
        <label>Username</label><br>
        <input type="text" name="username" placeholder="Enter username"><br><br>
        <label>Password</label><br>
        <input type="password" name="upassword" placeholder="Enter password"><br><br>
        <input type="submit" name="submit" value="Login" id="inputbtn"></form>

    </section>
</div>

<?php
if(isset($_POST["submit"]))
{
    $username = $_POST["username"];
    $user_password = $_POST["upassword"];

    $db = new mysqli("127.0.0.1","root","","education_sys");
    $result=$db ->query("SELECT * FROM users WHERE Username = '$username' AND Password = '$user_password'");

    if (($result -> num_rows)!=0){
        $row=$result -> fetch_assoc();
        $user_type = $row["UserType"];

        if($user_type=="Admin"){
            $_SESSION["UserType"] = $user_type;
            $_SESSION["Username"] = $username;
            header("Location: admin/adminhome.php");
        }
        else if($user_type=="Student"){
            $_SESSION["UserType"] = $user_type;
            $_SESSION["Username"] = $username;
            header("Location: student/studentMain.php");
        }
        else if($user_type=="Professor"){
            $_SESSION["UserType"] = $user_type;
            $_SESSION["Username"] = $username;
            header("Location: professor/professorMain.php");

        }
    }
else{
        echo "<h5>Nickname or Password is wrong!!!</h5>";
    }

};
?>

<script src="script.js"></script>
</body>
</html>