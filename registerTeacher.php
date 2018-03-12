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
$teacherID = $username = $password = $confirm_password = $email = $firstname = $surname = $subject = $school = "";
$teacherID_err = $username_err = $password_err = $confirm_password_err = $email_err = $firstname_err = $surname_err = $subject_err = $school_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = $conn_found->prepare("SELECT username FROM teachers WHERE username = ?");
        
        if ($conn_found) {
            // Bind variables to the prepared statement as parameters
            $sql->bind_param('s', $TeacherUsername);
            
            // Set parameters
            $TeacherUsername = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($sql->execute()){
                /* store result */
                $sql->store_result();
                
                if($sql->num_rows === 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $sql->close();
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    // Validate email
    if(empty(trim($_POST['email']))){
        $email_err = "Please enter an email.";     
    } elseif(!filter_var((trim($_POST['email'])), FILTER_VALIDATE_EMAIL)){
        $email_err = "Email must be in correct format.";     
    } else{
        $email = trim($_POST['email']);
    }
    
    // Validate firstname
    if(empty(trim($_POST['firstname']))){
        $firstname_err = "Please enter a firstname.";     
    } else{
        $firstname = trim($_POST['firstname']);
    }
    
    // Validate surname
    if(empty(trim($_POST['surname']))){
        $surname_err = "Please enter a surname.";     
    } else{
        $surname = trim($_POST['surname']);
    }
    
    // Validate subject
    if(empty(trim($_POST['subject']))){
        $subject_err = "Please enter the subject you teach.";     
    } else{
        $subject = trim($_POST['subject']);
    }
    
    // Validate school
    if(empty(trim($_POST['school']))){
        $school_err = "Please enter your school's name.";     
    } else{
        $school = trim($_POST['school']);
    }
    
    if ($conn_found) {

    $idFetch = $conn_found->prepare('SELECT teacherID FROM teachers ORDER BY teacherID DESC LIMIT 1');
    
    $idFetch->execute();
    $idFetch->store_result();
    
    $idFetch->bind_result($teacherID); 
    $idFetch->fetch();
    $teacherID = $teacherID + 1;
    
        if(empty($teacherID)){
            $teacherID_err = "error";
        }
        
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($surname_err) && empty($email_err) && empty($subject_err) && empty($school_err) && empty($teacherID_err)){
        
        // Prepare an insert statement
        $SQL = $conn_found->prepare("INSERT INTO teachers (teacherID, username, password, email, firstname, surname, subject, school) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         
        if($conn_found){
            // Bind variables to the prepared statement as parameters
            $SQL->bind_param('ssssssss', $param_teacherID, $param_username, $param_password, $param_email, $param_firstname, $param_surname, $param_subject, $param_school);
            
            // Set parameters
            $param_teacherID = $teacherID;
            $param_username = $username;
            $param_password = $password; 
            $param_firstname = $firstname;
            $param_surname = $surname;
            $param_email = $email;
            $param_subject = $subject;
            $param_school = $school;

            // Attempt to execute the prepared statement
            if($SQL->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $SQL->close();
    }
    
    // Close connection
    $conn_found->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Teacher Account Registration:</h2>
        <p>Please fill this form to create a new teacher account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username:<sup>*</sup></label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password:<sup>*</sup></label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email:<sup>*</sup></label>
                <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name:<sup>*</sup></label>
                <input type="text" name="firstname"class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
                <label>Surname:<sup>*</sup></label>
                <input type="text" name="surname"class="form-control" value="<?php echo $surname; ?>">
                <span class="help-block"><?php echo $surname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                <label>Subject:<sup>*</sup></label>
                <input type="text" name="subject"class="form-control" value="<?php echo $subject; ?>">
                <span class="help-block"><?php echo $subject_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($school_err)) ? 'has-error' : ''; ?>">
                <label>School:<sup>*</sup></label>
                <input type="text" name="school"class="form-control" value="<?php echo $school; ?>">
                <span class="help-block"><?php echo $school_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>