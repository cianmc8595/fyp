<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page

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
        <h2><?php echo $_SESSION['usertype']; ?> Account Management:</h2>
        <p></p>
        <?php
            if ($_SESSION['usertype'] === "Student"){
                echo "<form action='' method='post' style='position:absolute; top:150px; left:50px;'>";
                $id = $_SESSION['studentID'];
                $username = $_SESSION['username'];
                $email = $_SESSION['email'];
                $fname = $_SESSION['firstname'];
                $sname = $_SESSION['surname'];
                $yearInSchool = $_SESSION['yearInSchool'];
                $school = $_SESSION['school'];
            }
            else {
                echo "<form action='' method='post' style='visibility: hidden; position:absolute; top:150px; left:50px;'>";
            }
        ?>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Student ID:<sup>*</sup></label>
                <input type="text" name="studentID"class="form-control" value="<?php echo $id; ?>" readonly>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Username:<sup>*</sup></label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email:<sup>*</sup></label>
                <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name:<sup>*</sup></label>
                <input type="text" name="firstname"class="form-control" value="<?php echo $fname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
                <label>Surname:<sup>*</sup></label>
                <input type="text" name="surname"class="form-control" value="<?php echo $sname; ?>">
                <span class="help-block"><?php echo $surname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                <label>Year in School:<sup>*</sup></label>
                <input type="text" name="yearInSchool"class="form-control" value="<?php echo $yearInSchool; ?>">
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                <label>School:<sup>*</sup></label>
                <input type="text" name="school"class="form-control" value="<?php echo $school; ?>">
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <div class="form-group">
                <input name="saveStudentChanges" type="submit" class="btn btn-primary" value="Save Changes">
                <p><a href="StudentsHome.php" class="btn btn-danger">Main Menu</a></p>
            </div>
        </form>
      <!--  <?php
            if ($_SESSION['usertype'] === "Teacher"){
                echo "<form action='' method='post' style='position:absolute; top:150px; left:50px;'>";
            }
            else {
                echo "<form action='' method='post' style='visibility: hidden; position:absolute; top:150px; left:50px;'>";
            }
        ?>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Teacher Username:<sup>*</sup></label>
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
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                <label>Past School:<sup>*</sup></label>
                <input type="text" name="pastSchool"class="form-control" value="<?php echo $pastSchool; ?>">
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <div class="form-group">
                <input name="saveTeacherChanges" type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        <?php
            if ($_SESSION['usertype'] === "Tutor"){
                echo "<form action='' method='post' style='position:absolute; top:150px; left:50px;'>";
            }
            else {
                echo "<form action='' method='post' style='visibility: hidden; position:absolute; top:150px; left:50px;'>";
            }
        ?>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Tutor Username:<sup>*</sup></label>
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
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                <label>Past School:<sup>*</sup></label>
                <input type="text" name="pastSchool"class="form-control" value="<?php echo $pastSchool; ?>">
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <div class="form-group">
                <input name="saveTutorChanges" type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>-->
    </div>    
</body>
<?php

    $link = mysqli_connect("127.0.0.1", "cianmc85", "", "project_db");
    
    if (isset($_POST['saveStudentChanges'])){
            
        $id = $_SESSION['studentID'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $fname = $_POST['firstname'];
                $sname = $_POST['surname'];
                $yearInSchool = $_POST['yearInSchool'];
                $school = $_POST['school'];
                $id = $_POST['studentID'];
        
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "UPDATE students SET username=?, email=?, firstname=?, 
                surname=?, yearInSchool=?, school=? WHERE studentID=?";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $fname, $sname, $yearInSchool, $school, $id);
        
            if(mysqli_stmt_execute($stmt)){
                        
                $_SESSION['username'] = $username;   
                $_SESSION['email'] = $email;
                $_SESSION['firstname'] = $fname;
                $_SESSION['surname'] = $sname;
                $_SESSION['yearInSchool'] = $yearInSchool;
                $_SESSION['school'] = $school;
                echo "Record updated successfully";
                header("location: StudentsHome.php");
            } else {
                echo "Error updating record: " . $conn_found->error;
            }

         mysqli_stmt_close($stmt);
        mysqli_close($link);
        }
    
    }


?>
</html>