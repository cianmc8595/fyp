<?php

//Connect to the Database
/* Code below is based on https://community.c9.io/t/connecting-php-to-mysql/1606 a post by Brady Dowling */
$host = "127.0.0.1";
$user = "cianmc85";
$pass = "";
$db = "project_db";
$port = 3306;
    
// Create connection
/* Code below is based on aspects from http://www.homeandlearn.co.uk/php and https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection */
$conn_found = new mysqli($host, $user, $pass, $db, $port);
 
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
/*END*/    
    $TeacherUsername = $TutorUsername = $StudentUsername = $username;
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
    
        if ($conn_found) {

            $Teacher_SQL = $conn_found->prepare('SELECT teacherID, username, password, firstname, surname FROM teachers WHERE username = ?');
            $Teacher_SQL->bind_param('s', $TeacherUsername);
            $Teacher_SQL->execute();
            $Teacher_SQL->store_result();
            
            $Tutor_SQL = $conn_found->prepare('SELECT tutorID, username, password, firstname, surname, email, pastSchool FROM tutors WHERE username = ?');
            $Tutor_SQL->bind_param('s', $TutorUsername);
            $Tutor_SQL->execute();
            $Tutor_SQL->store_result();
            
            $Student_SQL = $conn_found->prepare('SELECT studentID, username, password, email, firstname, surname, yearInSchool, school FROM students WHERE username = ?');
            $Student_SQL->bind_param('s', $StudentUsername);
            $Student_SQL->execute();
            $Student_SQL->store_result();

            if ($Teacher_SQL->num_rows === 1) {

                $Teacher_SQL->bind_result($retrievedTeacherID, $retrievedUsername, $retrievedPassword, $retrievedFirstname, $retrievedSurname); 
                $Teacher_SQL->fetch();
                
                if ($retrievedUsername === $username){
                    if ($retrievedPassword === $password){
                    
                        /* Password is correct, so start a new session and
                        save the username to the session */
                        session_start();
                        $_SESSION['username'] = $retrievedUsername;
                        $_SESSION['usertype'] = "Teacher";
                        $_SESSION['teacherID'] = "$retrievedTeacherID";
                        $_SESSION['firstname'] = "$retrievedFirstname";
                        $_SESSION['surname'] = "$retrievedSurname";
                        header("location: TeachersHome.php");
                        
                    }
                    else{
                        $password_err = 'The password you entered was not valid.';
                    }
                }
                else{
                    $username_err = 'Username does not exist. Please try again.';
                }
            }
            elseif ($Tutor_SQL->num_rows === 1){

                $Tutor_SQL->bind_result($retrievedTutorID, $retrievedUsername, $retrievedPassword, $retrievedFirstname, $retrievedSurname, $retrievedEmail, $retrievedSchool); 
                $Tutor_SQL->fetch();
                
                if ($retrievedUsername === $username){
                    if ($retrievedPassword === $password){
                    
                        /* Password is correct, so start a new session and
                        save the username to the session */
                        session_start();
                        $_SESSION['username'] = $retrievedUsername;
                        $_SESSION['tutorID'] = $retrievedTutorID;
                        $_SESSION['email'] = $retrievedEmail;
                        $_SESSION['firstname'] = $retrievedFirstname;
                        $_SESSION['surname'] = $retrievedSurname;
                        $_SESSION['pastSchool'] = $retrievedSchool;
                        $_SESSION['usertype'] = "Tutor";  
                        header("location: TutorsHome.php");
                        
                    }
                    else{
                        $password_err = 'The password you entered was not valid.';
                    }
                }
                else{
                    $username_err = 'Username does not exist. Please try again.';
                }
            }
            elseif ($Student_SQL->num_rows === 1){

                $Student_SQL->bind_result($retrievedStudentID, $retrievedUsername, $retrievedPassword, $retrievedEmail, $retrievedFirstname, $retrievedSurname, $retrievedSchoolYear, $retrievedSchool); 
                $Student_SQL->fetch();
                
                if ($retrievedUsername === $username){
                    if ($retrievedPassword === $password){
                    
                        /* Password is correct, so start a new session and
                        save the username to the session */
                        session_start();
                        $_SESSION['username'] = $retrievedUsername;   
                        $_SESSION['email'] = $retrievedEmail;
                        $_SESSION['firstname'] = $retrievedFirstname;
                        $_SESSION['surname'] = $retrievedSurname;
                        $_SESSION['studentID'] = $retrievedStudentID;
                        $_SESSION['yearInSchool'] = $retrievedSchoolYear;
                        $_SESSION['school'] = $retrievedSchool;
                        $_SESSION['usertype'] = "Student";
                        header("location: StudentsHome.php");
                        
                    }
                    else{
                        $password_err = 'The password you entered was not valid.';
                    }
                }
                else{
                    $username_err = 'Username does not exist. Please try again.';
                }
            }
            else {
                $username_err = 'Username does not exist. Please try again.';
            }

            $Teacher_SQL->close();
            $conn_found->close();
        }
        else {
            print "Database NOT Found ";
        }
    
    }
    
  /*END*/  
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; background-color:#d5f4e6; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login to your account</h2>
        <p>Please enter your username and password</p>
        <!-- Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username:<sup>*</sup></label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Login">
            </div>
            <p>Don't have an account? <a href="registerHome.php">Sign up now</a>.</p>
        </form>
        <!-- END -->
    </div>    
</body>
</html>