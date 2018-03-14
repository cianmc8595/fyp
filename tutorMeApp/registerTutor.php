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
$tutorID = $username = $password = $confirm_password = $email = $firstname = $surname = $pastSchool = "";
$tutorID_err = $username_err = $password_err = $confirm_password_err = $email_err = $firstname_err = $surname_err = $pastSchool_err = "";

// Processing form data when form is submitted
if(isset($_POST['register'])){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = $conn_found->prepare("SELECT username FROM students WHERE username = ?
                                    UNION 
                                    SELECT username FROM tutors WHERE username = ?
                                    UNION 
                                    SELECT username FROM teachers WHERE username = ?");
        
        if ($conn_found) {
            // Bind variables to the prepared statement as parameters
            $sql->bind_param('sss', $TutorUsername, $TutorUsername, $TutorUsername);
            
            // Set parameters
            $TutorUsername = trim($_POST["username"]);
            
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
    
    // Validate pastSchool
    if(empty(trim($_POST['pastSchool']))){
        $pastSchool_err = "Please enter your past School's name.";     
    } else{
        $pastSchool = trim($_POST['pastSchool']);
    }
    
    if ($conn_found) {

    $idFetch = $conn_found->prepare('SELECT tutorID FROM tutors ORDER BY tutorID DESC LIMIT 1');
    
    $idFetch->execute();
    $idFetch->store_result();
    
    $idFetch->bind_result($tutorID); 
    $idFetch->fetch();
    $tutorID = $tutorID + 1;
    
        if(empty($tutorID)){
            $tutorID_err = "error";
        }
        
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($surname_err) && empty($email_err) && empty($pastSchool_err) && empty($tutorID_err)){
        
        // Prepare an insert statement
        $SQL = $conn_found->prepare("INSERT INTO tutors (tutorID, username, password, email, firstname, surname, pastSchool, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         
        if($conn_found){
            // Bind variables to the prepared statement as parameters
            $SQL->bind_param('ssssssss', $param_tutorID, $param_username, $param_password, $param_email, $param_firstname, $param_surname, $param_pastSchool, $param_enabled);
            
            // Set parameters
            $param_tutorID = $tutorID;
            $param_username = $username;
            $param_password = $password; 
            $param_firstname = $firstname;
            $param_surname = $surname;
            $param_email = $email;
            $param_pastSchool = $pastSchool;
            $param_enabled = "enabled";
            
            // Attempt to execute the prepared statement
            if($SQL->execute()){
                // Redirect to login page
                header("location: LandingPage.php#login");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $SQL->close();
    }
    
    // Close connection
    $conn_found->close();
    
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $usertypeForImage = "Tutor";
        $userIDforImage = $param_tutorID;
        /*
         * Insert image data into database
         */
        
        //DB details
        $dbHost     = '127.0.0.1';
        $dbUsername = 'cianmc85';
        $dbPassword = '';
        $dbName     = 'project_db';
        
        //Create connection and select DB
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
        // Check connection
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
        
        //Insert image content into database
        $insert = $db->query("INSERT into images (image, userID, usertype) VALUES ('$imgContent', '$userIDforImage', '$usertypeForImage')");
        if($insert){
            echo "File uploaded successfully.";
        }else{
            echo "File upload failed, please try again.";
        } 
    }else{
        echo "Please select an image file to upload.";
    }
}
elseif(isset($_POST['return'])){
    
    header("location: LandingPage.php");

    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Tutor Registration</title>
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

	.form-control {
	    margin: 0 auto;
	    position:relative;
	    width: 80%;
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
		width: 90%;
		margin: 0 auto;
		padding: 180px 0 30px;
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
        color:white;
		background: #008b9c;
		border: none;
		margin-bottom: 20px;
    }
	.login-form .btn:hover, .login-form .btn:focus {
		background: #008b9c;
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
                        <a href="LandingPage.php#login" style="margin-top:15px;" >Login</a>
                    </li>
                    <li>
                        <a href="LandingPage.php#usertype" style="margin-top:15px;" >Sign Up</a>
                    </li>
                    <li>
                        <a href="LandingPage.php#features" style="margin-top:15px;" >Features</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>

    <div class="section section-header">
        <div class="parallax filter filter-color-blue" style="height:1200px;">
            <div class="section" id="login">`
            <div class="container">
            
            <div class="login-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="padding-bottom:85px; margin-top:-50px;
                                 -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;">
		            <div class="avatar avatar-danger">
			            <img class="img-circle" src="assets/img/faces/tutorsIcon.png" alt="">
		            </div>
                    <h2 class="text-center">Tutor Registration</h2>   
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" required="required">
        	            <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
		            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $password; ?>" required="required">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        	            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>" required="required">
        	            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
		            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" required="required">
        	            <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $firstname; ?>" required="required">
        	            <span class="help-block"><?php echo $firstname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="surname" class="form-control" placeholder="Surname" value="<?php echo $surname; ?>" required="required">
        	            <span class="help-block"><?php echo $surname_err; ?></span>
                    </div>
					<div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                		<select type="text" class="form-control" name="pastSchool">
                    		<option selected value="">Select the school you went to from the list</option><option value="school">My School is not on this list</option><option value="Ashton School">Ashton School</option>
                            <option value="Ballincollig Community School">Ballincollig Community School</option><option value="Bandon Grammar School">Bandon Grammar School</option>
                            <option value="Bishopstown Community School">Bishopstown Community School</option><option value="Carrigaline Community School">Carrigaline Community School</option>
                            <option value="Carrigtwohill Post Primary">Carrigtwohill Post Primary</option><option value="Christ King Girls' Secondary School">Christ King Girls' Secondary School</option>
                            <option value="Christian Brothers College">Christian Brothers College</option><option value="Clonakilty Community College">Clonakilty Community College</option>
                            <option value="Coachford College">Coachford College</option><option value="Colaiste An Phiarsaigh">Colaiste An Phiarsaigh</option>
                            <option value="Coláiste An Spioraid Naoimh">Coláiste An Spioraid Naoimh</option><option value="Coláiste Choilm">Coláiste Choilm</option>
                            <option value="Coláiste Chríost Rí">Coláiste Chríost Rí</option><option value="Colaiste Muire">Colaiste Muire</option>
                            <option value="Coláiste Pobail Bheanntraí">Coláiste Pobail Bheanntraí</option><option value="Cork College Of Commerce">Cork College Of Commerce</option>
                            <option value="Deerpark C.B.S.">Deerpark C.B.S.</option><option value="Douglas Community School">Douglas Community School</option>
	                        <option value="Glanmire Community College">Glanmire Community College</option><option value="Kinsale Community School">Kinsale Community School</option>
	                        <option value="Loreto Secondary School">Loreto Secondary School</option><option value="Mayfield Community School">Mayfield Community School</option>
	                        <option value="Midleton College">Midleton College</option><option value="Millstreet Community School">Millstreet Community School</option>
	                        <option value="Mount Mercy College">Mount Mercy College</option><option value="North Monastery Secondary School">North Monastery Secondary School</option>
	                        <option value="Presentation Brothers College">Presentation Brothers College</option><option value="Regina Mundi College">Regina Mundi College</option>
	                        <option value="Sacred Heart Secondary School">Sacred Heart Secondary School</option><option value="Schull Community College">Schull Community College</option>
	                        <option value="Scoil Mhuire">Scoil Mhuire</option><option value="SKIBBEREEN COMMUNITY SCHOOL">SKIBBEREEN COMMUNITY SCHOOL</option>
	                        <option value="St Aidan's Community College">St Aidan's Community College</option><option value="St Aloysius College">St Aloysius College</option>
	                        <option value="St Colman's Community College">St Colman's Community College</option><option value="St Mary's High School">St Mary's High School</option>
	                        <option value="St Mary'S Secondary School">St Mary'S Secondary School</option><option value="St Patricks College">St Patricks College</option>
	                        <option value="St Vincent's Secondary School">St Vincent's Secondary School</option><option value="St. Angela's College">St. Angela's College</option>
	                        <option value="Ursuline Secondary School">Ursuline Secondary School</option>
                		</select>
                		<span class="help-block"><?php echo $pastSchool_err; ?></span>
            		</div>
                    <div class="form-group <?php echo (!empty($school_err)) ? 'has-error' : ''; ?>">
        	            <h2 class="text-center" style="font-size:18px;">Select a Profile Picture to upload:</h2>
                    </div>
                    <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                        <input type="file" name="image" class="btn btn-primary btn-lg btn-block"/>
                    </div>
                     <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Register" name="register" style="width:40%; float: left; position: relative; margin-top:0px;">
                    </div>
                </form>
                <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                        <a href="LandingPage.php"><input type="submit" class="btn btn-primary btn-lg btn-block" value="Return" name="return" style="width:40%; float: right; position: relative; margin-top:-120px; margin-right:15px;"></a>
                </div>
                <p class="text-center small">Already have an account? <a href="LandingPage.php#login">Log in here!</a></p>
            </div>
            
            </div>
            </div>
        </div>
    </div>
<!-- END of modified code -->

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
