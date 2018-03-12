<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}/* END */
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; background-color:#d5f4e6;}
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>. You are a <b><?php echo $_SESSION['usertype']; ?></b>. Welcome to the site.</h1>
        <h1>Hi, <b><?php echo $_SESSION['firstname']; ?></b>. You are a <b><?php echo $_SESSION['surname']; ?></b>. Welcome to the site.</h1>
        <h1>Hi, <b><?php echo $_SESSION['teacherID']; ?></b>. You are a Welcome to the site.</h1>
    </div>
    <p><a href="manageTutors.php" class="btn btn-danger">Manage my tutors</a></p>
    <p><a href="manageAccount.php" class="btn btn-danger">Manage my Account</a></p>
    <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
</body>
</html>