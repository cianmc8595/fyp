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
            
            $Tutor_SQL = $conn_found->prepare('SELECT tutorID, username, password, firstname, surname, email, pastSchool, enabled FROM tutors WHERE username = ?');
            $Tutor_SQL->bind_param('s', $TutorUsername);
            $Tutor_SQL->execute();
            $Tutor_SQL->store_result();
            
            $Student_SQL = $conn_found->prepare('SELECT studentID, username, password, email, firstname, surname, yearInSchool, school, enabled FROM students WHERE username = ?');
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

                $Tutor_SQL->bind_result($retrievedTutorID, $retrievedUsername, $retrievedPassword, $retrievedFirstname, $retrievedSurname, $retrievedEmail, $retrievedSchool, $retrievedEnabled); 
                $Tutor_SQL->fetch();
                
                if ($retrievedUsername === $username){
                    if ($retrievedPassword === $password){
                    
                      if ($retrievedEnabled === "enabled"){
                        
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
                      elseif ($retrievedEnabled === "disabled"){
                        $password_err = 'Your account has been deactivated due to a breach in violations.</br> Please speak to your teacher regarding this issue.';

                      }
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

                $Student_SQL->bind_result($retrievedStudentID, $retrievedUsername, $retrievedPassword, $retrievedEmail, $retrievedFirstname, $retrievedSurname, $retrievedSchoolYear, $retrievedSchool, $retrievedEnabled); 
                $Student_SQL->fetch();
                
                if ($retrievedUsername === $username){
                    if ($retrievedPassword === $password){
                    
                      if ($retrievedEnabled === "enabled"){
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
                      elseif ($retrievedEnabled === "disabled"){
                        $password_err = 'Your account has been deactivated due to a breach in violations.</br> Please speak to your teacher regarding this issue.';

                      }
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
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>TutorLink</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/gaia.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Cambo|Poppins:400,600' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/fonts/pe-icon-7-stroke.css" rel="stylesheet">
    
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	body {
		background: #d47677;
	}
	.form-control {
        min-height: 41px;
		background: #fff;
		box-shadow: none !important;
		border-color: #e3e3e3;
	}
	.form-control:focus {
		border-color: #70c5c0;
	}
    .form-control, .btn {        
        border-radius: 2px;
    }
	.login-form {
		width: 80%;
		margin: 0 auto;
		padding: 250px 0 30px;		
	}
	.login-form form {
		color: #7a7a7a;
		border-radius: 2px;
    	margin-bottom: 15px;
        font-size: 13px;
        background: #ececec;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;	
        position: relative;	
    }
	.login-form h2 {
		font-size: 22px;
        margin: 35px 0 25px;
    }
	.login-form .avatar {
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -50px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #70c5c0;
		padding: 15px;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.login-form .avatar img {
		width: 100%;
	}	
    .login-form input[type="checkbox"] {
        margin-top: 2px;
    }
    .login-form .btn {        
        font-size: 16px;
        font-weight: bold;
		background: #70c5c0;
		border: none;
		margin-bottom: 20px;
    }
	.login-form .btn:hover, .login-form .btn:focus {
		background: #50b8b3;
        outline: none !important;
	}    
	.login-form a {
		
		text-decoration: underline;
	}
	.login-form a:hover {
		text-decoration: none;
	}
	.login-form form a {
		color: #7a7a7a;
		text-decoration: none;
	}
	.login-form form a:hover {
		text-decoration: underline;
	}
</style>
</head>

<body>
<!-- START of modified code -->

    <nav class="navbar navbar-default navbar-transparent navbar-fixed-top" color-on-scroll="200">
        <!-- if you want to keep the navbar hidden you can add this class to the navbar "navbar-burger"-->
        <div class="container">
            <div class="navbar-header">
                <button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar bar1"></span>
                    <span class="icon-bar bar2"></span>
                    <span class="icon-bar bar3"></span>
                </button>
                <a href="" style="margin-left:0px; margin-top:15px;" class="navbar-brand">
                    TutorLink
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right navbar-uppercase" style="margin-top:10px;">
                    <li>
                        <a href="#login" style="margin-top:15px;" target="_blank">Login</a>
                    </li>
                    <li>
                        <a href="#usertype" style="margin-top:15px;" target="_blank">Sign Up</a>
                    </li>
                    <li>
                        <a href="#features" style="margin-top:15px;" target="_blank">Features</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>


    <div class="section section-header">
        <div class="parallax filter filter-color-blue">
            
            <div class="container">
                <div class="content">
                    <div class="title-area">
                        <p></p>
                        <img src="logo.png" style="width:450px;height:450px;"></img>
                        <h3 style="margin-top:-50px;">Tutors you know, Tutors you trust!</h2>
                        <div class="separator line-separator">♦</div>
                    </div>

                    <div class="button-get-started">
                        <a href="#login" class="btn btn-white btn-fill btn-lg " style="border: 0px;background:#00899C;color:white;">
                            Login
                        </a>
                        <a href="#usertype" class="btn btn-white btn-fill btn-lg " style="border: 0px;background:#00899C;color:white;">
                            Sign Up
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
<!-- END of modified code -->

    <div class="section" id="login">`
        <div class="container" style="height:505px;">
            
            
            <div class="login-form"style="margin-top:-120px;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		            <div class="avatar" style="background:#008b9c;">
			            <img src="assets/avatar.png"alt="Avatar">
		            </div>
                    <h2 class="text-center">Member Login</h2>   
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" required="required">
        	            <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
		            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>        
                    <div class="form-group">
                        <button type="submit" style="width:35%;margin:0 auto;background:#008b9c; color:white;" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </div>
                </form>
                <p class="text-center small">Don't have an account? <a href="#usertype" style="color:#008b9c;">Sign up here!</a></p>
            </div>
        </div>
    </div>
    
    <div class="section section-our-team-freebie" id="usertype">
        <div class="parallax filter filter-color-black">
            <div class="image" style="background-image:url('https://images.cdn3.stockunlimited.net/thumb450/school-supplies-on-desk-background-with-copy-space_1955905.jpg');">
            </div>
            <div class="container" style="height:700px;">
                <div class="content">
                    <div class="row">
                        <div class="title-area">
                            <h2>Choose your Usertype</h2>
                            <div class="separator separator-danger">✻</div>
                            <p class="description">Welcome to TutorLink! Choose your usertype below to get started!</p>
                        </div>
                    </div>

                    <div class="team">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-member">
                                            <div class="content">
                                                <div class="avatar avatar-danger">
                                                    <img alt="..." class="img-circle" src="assets/img/faces/tutorsIcon.png"/>
                                                </div>
                                                <div class="description">
                                                    <h3 class="title">Tutor</h3>
                                                    <p class="description" style="color:black;">Sign up as a tutor with us and we'll help you find lots of students in your local area who need help in every Leaving Certificate subject.
                                                    If you're looking for a rewarding form of income, then this is the job for you!</p>
                                                </div>
                                                <div class="login-form" style="padding:0px; width:100%;">
                                                        <a href="registerTutor.php" style="text-decoration: none;"><button type="submit" class="btn btn-primary btn-lg btn-block" style="width:100%;margin:0 auto;background:#008b9c; color:white;">Sign Up as Tutor</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-member">
                                            <div class="content">
                                                <div class="avatar avatar-danger">
                                                    <img alt="..." class="img-circle" src="assets/img/faces/studentsIcon.png"/>
                                                </div>
                                                <div class="description">
                                                    <h3 class="title">Student</h3>
                                                    <p class="description" style="color:black;">Sign up as a student if you're currently studying for the Leaving Certificate. We will connect you with affordable tutors in your local area
                                                    who are verified and recommended by your own teachers!</p>
                                                </div>
                                                <div class="login-form" style="padding:0px; width:100%;">
                                                        <a href="registerStudent.php" style="text-decoration: none;"><button type="submit" class="btn btn-primary btn-lg btn-block" style="width:100%;margin:0 auto;background:#008b9c; color:white;">Sign Up as Student</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-member">
                                            <div class="content">
                                                <div class="avatar avatar-danger">
                                                    <img alt="..." class="img-circle" src="assets/img/faces/teachersIcon.png"/>
                                                </div>
                                                <div class="description">
                                                    <h3 class="title">Teacher</h3>
                                                    <p class="description" style="color:black;">Sign up as a teacher and we can help you to connect your current students with your high-achieving past students for grinds. Use our tools
                                                    to ensure they are connecting in a safe educational environment.</p>
                                                </div>
                                                <div class="login-form" style="padding:0px; width:100%;">
                                                        <a href="registerTeacher.php" style="text-decoration: none;"><button type="submit" class="btn btn-primary btn-lg btn-block" style="width:100%;margin:0 auto;background:#008b9c; color:white;">Sign Up as Teacher</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section" id="features">
        <div class="container" style="height:550px;">
            <div class="row">
                <div class="title-area" style="margin-top:70px;">
                    <h2>Key Features</h2>
                    <div class="separator separator-danger">✻</div>
                    <p class="description">Check out some of the key features our system offers you!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-icon">
                        <div class="avatar avatar-danger" style="background:#960000;">
                            <img alt="..." class="img-circle" style="width:100px;height:100px;" src="tutorSearch.png"/>
                        </div> 
                        <h3>Tutor Search</h3>
                        <p class="description">As a student, use our filtered tutor search to find tutors who went to your school and had the same teacher as you!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-icon">
                        <div class="avatar avatar-danger" style="background:#FC7800;">
                            <img alt="..." class="img-circle" style="width:100px;height:100px;" src="inbox.png"/>
                        </div>
                        <h3>Messenger</h3>
                        <p class="description">Our in-built messenger app keeps all educational talk within the system, in a safe and monitored environment.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-icon">
                        <div class="avatar avatar-danger" style="background:#4D8427;">
                            <img alt="..." class="img-circle" style="width:100px;height:100px;" src="newCV.png"/>
                        </div>
                        <h3>Personalise your online CV</h3>
                        <p class="description">As a tutor, advertise your tutoring services the best way you can: with a personalised online CV!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- <div class="section section-our-clients-freebie">
        <div class="container">
            <div class="title-area">
                <h5 class="subtitle text-gray">Here are some</h5>
                <h2>Clients Testimonials</h2>
                <div class="separator separator-danger">∎</div>
            </div>

            <ul class="nav nav-text" role="tablist">
                <li class="active">
                    <a href="#testimonial1" role="tab" data-toggle="tab">
                        <div class="image-clients">
                            <img alt="..." class="img-circle" src="assets/img/faces/face_5.jpg"/>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#testimonial2" role="tab" data-toggle="tab">
                        <div class="image-clients">
                            <img alt="..." class="img-circle" src="assets/img/faces/face_6.jpg"/>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#testimonial3" role="tab" data-toggle="tab">
                        <div class="image-clients">
                            <img alt="..." class="img-circle" src="assets/img/faces/headshot.jpg"/>
                        </div>
                    </a>
                </li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane active" id="testimonial1">
                    <p class="description">
                        And I used a period because contrary to popular belief I strongly dislike exclamation points! We no longer have to be scared of the truth feels good to be home In Roman times the artist would contemplate proportions and colors. Now there is only one important color... Green I even had the pink polo I thought I was Kanye I promise I will never let the people down. I want a better life for all!
                    </p>
                </div>
                <div class="tab-pane" id="testimonial2">
                    <p class="description">Green I even had the pink polo I thought I was Kanye I promise I will never let the people down. I want a better life for all! And I used a period because contrary to popular belief I strongly dislike exclamation points! We no longer have to be scared of the truth feels good to be home In Roman times the artist would contemplate proportions and colors. Now there is only one important color...
                    </p>
                </div>
                <div class="tab-pane" id="testimonial3">
                    <p class="description"> I used a period because contrary to popular belief I strongly dislike exclamation points! We no longer have to be scared of the truth feels good to be home In Roman times the artist would contemplate proportions and colors. The 'Gaia' team did a great work while we were collaborating. They provided a vision that was in deep connection with our needs and helped us achieve our goals.
                    </p>
                </div>

            </div>

        </div>
    </div>


    <div class="section section-small section-get-started">
        <div class="parallax filter">
            <div class="image"
                style="background-image: url('assets/img/office-1.jpeg')">
            </div>
            <div class="container">
                <div class="title-area">
                    <h2 class="text-white">Do you want to work with us?</h2>
                    <div class="separator line-separator">♦</div>
                    <p class="description"> We are keen on creating a second skin for anyone with a sense of style! We design our clothes having our customers in mind and we never disappoint!</p>
                </div>

                <div class="button-get-started">
                    <a href="#gaia" class="btn btn-danger btn-fill btn-lg">Contact Us</a>
                </div>
            </div>
        </div>
    </div>-->


   <!-- <footer class="footer footer-big footer-color-black" data-color="black">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="info">
                        <h5 class="title">Company</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="#">Home</a></li>
                                <li>
                                    <a href="#">Find offers</a>
                                </li>
                                <li>
                                    <a href="#">Discover Projects</a>
                                </li>
                                <li>
                                    <a href="#">Our Portfolio</a>
                                </li>
                                <li>
                                    <a href="#">About Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1 col-sm-3">
                    <div class="info">
                        <h5 class="title"> Help and Support</h5>
                         <nav>
                            <ul>
                                <li>
                                    <a href="#">Contact Us</a>
                                </li>
                                <li>
                                    <a href="#">How it works</a>
                                </li>
                                <li>
                                    <a href="#">Terms &amp; Conditions</a>
                                </li>
                                <li>
                                    <a href="#">Company Policy</a>
                                </li>
                                <li>
                                    <a href="#">Money Back</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="info">
                        <h5 class="title">Latest News</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i> <b>Get Shit Done</b> The best kit in the market is here, just give it a try and let us...
                                        <hr class="hr-small">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i> We've just been featured on <b> Awwwards Website</b>! Thank you everybody for...
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-2 col-md-offset-1 col-sm-3">
                    <div class="info">
                        <h5 class="title">Follow us on</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="#" class="btn btn-social btn-facebook btn-simple">
                                        <i class="fa fa-facebook-square"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-dribbble btn-simple">
                                        <i class="fa fa-dribbble"></i> Dribbble
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-twitter btn-simple">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-reddit btn-simple">
                                        <i class="fa fa-google-plus-square"></i> Google+
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <hr>
            <div class="copyright">
                 © <script> document.write(new Date().getFullYear()) </script> Creative Tim, made with love
            </div>
        </div>
    </footer>-->
    
    <footer class="footer footer-big footer-color-black" data-color="black">
        <div class="container" style="height:300px;">
            <div class="row" style="margin-left:370px;">
                <div class="col-md-3 col-sm-3" style=>
                    <div class="info">
                        <h5 class="title">Useful Links</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="https://www.examinations.ie/">
                                        <p>State Examinations Commission</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.studyclix.ie/">
                                        <p>StudyClix</p>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-2 col-md-offset-1 col-sm-3">
                    <div class="info">
                        <h5 class="title">Follow us on</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/" class="btn btn-social btn-facebook btn-simple">
                                        <i class="fa fa-facebook-square"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/" class="btn btn-social btn-twitter btn-simple">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="https://plus.google.com/discover" class="btn btn-social btn-reddit btn-simple">
                                        <i class="fa fa-google-plus-square"></i> Google+
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="copyright" style="margin-top:0px;">
                 © <script> document.write(new Date().getFullYear()) </script> Creative Tim, edited by Cian McCarthy for TutorLink
            </div>
        </div>
    </footer>
    
</body>

<!--   core js files    -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.js" type="text/javascript"></script>

<!--  js library for devices recognition -->
<script type="text/javascript" src="assets/js/modernizr.js"></script>

<!--  script for google maps   -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!--   file where we handle all the script from the Gaia - Bootstrap Template   -->
<script type="text/javascript" src="assets/js/gaia.js"></script>

</html>
