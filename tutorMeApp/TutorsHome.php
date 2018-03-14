<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: LandingPage.php#login");
  exit;
}/* END */

if($_SESSION['usertype'] !== 'Tutor'){
  header("location: ".$_SESSION['usertype']."sHome.php");
}

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

$result = $db->query("SELECT image FROM images WHERE userID = '" .$_SESSION['tutorID']."' AND usertype = '" .$_SESSION['usertype']."'");
    
    if($result->num_rows > 0){
        $imgData = $result->fetch_assoc();
        $_SESSION['profilePic'] = $imgData['image'];
        $_SESSION['pictureCheck'] = "True";
        //Render image
        
    }else{
        $_SESSION['pictureCheck'] = "False";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    
    
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="OCC Extranet App cards demo">
    <meta name="author" content="Samaritan's Purse International Relief">
    <title>Home - Tutors</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Gaia - Bootstrap Template | Free Demo</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/gaia.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Cambo|Poppins:400,600' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/fonts/pe-icon-7-stroke.css" rel="stylesheet">
    
 <!--   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->


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
		margin-top:200px;
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
		top: -5px;
		width: 80px;
		height: 80px;
		border-radius: 50%;
		z-index: 9;
		background: #70c5c0;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.login-form .avatar img {
		width: 100%;
		height:100%;
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
                <ul class="nav navbar-nav navbar-right navbar-uppercase" style="margin-top:7px; left:30px; height:0px;">
                    <li>
                        <a href="NewCV.php" style="margin-top:15px;" target="_blank">Add New CV</a>
                    </li>
                    <li>
                        <a href="tutorInbox.php" style="margin-top:15px;" target="_blank">Inbox</a>
                    </li>
                    <li>
                        <a href="manageMyCVs.php" style="margin-top:15px;" target="_blank">My CVs</a>
                    </li>
                    <li class="dropdown" style="padding-right:35px;margin-top:-13px;">
                        <a href="#gaia" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="login-form">
                            <div class="avatar avatar-danger">
	                            <?php
	                                if ($_SESSION['pictureCheck'] === "True"){
	                                    echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['profilePic'] ).'"/>';
	                                }
	                                elseif ($_SESSION['pictureCheck'] === "False"){
	                                    echo '<img class="img-circle" src="headshot.jpg"/>';
	                                }
	                            ?>
	                        </div>
        	            </div>
        	            </a>
        	        </li>
        	        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo $_SESSION['username']; ?><span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-danger">
                            <li>
                                <a href="logout.php">Sign Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>

    <div class="section section-header">
        <div class="parallax filter filter-color-blue" style="height:700px;">
            <div class="section" id="login">`
            <div class="container">
             <div class="flexbox-container" style="margin-top:200px;">

        <!-- HOME -->
        <a href="NewCV.php">
            <div class="app-card" id="home-card-color" style="margin-top:-80px;">
                <div style="margin:0 auto; width:80%; height:130px; margin-bottom:-20px;">
                    <img src="newCV.png" style="width:100%;height:100%;display: block; margin-left: auto; margin-right: auto; "></img>
                </div>
                <div class="text-container">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front">
                                <p class="title">Add New CV</p>
                            </div>
                            <div class="back">
                                <p class="description">Register to tutor in a new subject by adding a CV!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <img src="logo.png" style="width:400px;height:400px; margin-left:50px; margin-right:50px; margin-top:-160px;"></img>

        <!-- DOCUMENT RESOURCES -->
        <a href="manageTutorAccount.php">
            <div class="app-card" id="document-resources-card-color" style="margin-top:-80px;">
                <div style="margin:0 auto; width:80%; height:130px; margin-bottom:-20px;">
                    <img src="manageAccount.png" style="width:100%;height:100%;display: block; margin-left: auto; margin-right: auto; "></img>
                </div>
                <div class="text-container">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front">
                                <p class="title">Manage my Account</p>
                            </div>
                            <div class="back">
                                <p class="description">Manage your personal information and CVs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
</div>
<div class="flexbox-container" style="margin-top:0px;">
        <!-- DROP-OFF LOCATION MANAGEMENT -->
        <a href="tutorInbox.php">
            <div class="app-card" id="drop-off-location-management-card-color" style="margin-top:-50px;">
                <div style="margin:0 auto; width:80%; height:130px; margin-bottom:-20px;">
                    <img src="inbox.png" style="width:100%;height:100%;display: block; margin-left: auto; margin-right: auto; "></img>
                </div>
                <div class="text-container">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front">
                                <p class="title">Inbox</p>
                            </div>
                            <div class="back">
                                <p class="description">View all on-going conversations with students</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        
        <!-- VOLUNTEER SELECTION & ONBOARDING -->
        <a href="manageMyCVs.php">
            <div class="app-card" id="volunteer-selection-ampersand-onboarding-card-color" style="margin-top:-50px;">
                <div style="margin:0 auto; width:80%; height:130px; margin-bottom:-20px;">
                    <img src="myCVs.png" style="width:100%;height:100%;display: block; margin-left: auto; margin-right: auto; "></img>
                </div>
                <div class="text-container">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front">
                                <p class="title">My CVs</p>
                            </div>
                            <div class="back">
                                <p class="description">View and manage your CVs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        
        <!-- NATIONAL PARTNERSHIP RESOURCES -->
        <a href="logout.php">
            <div class="app-card" id="national-partnership-resources-card-color" style="margin-top:-50px;">
                <div style="margin:0 auto; width:80%; height:130px; margin-bottom:-20px;">
                    <img src="signout.png" style="width:100%;height:100%;display: block; margin-left: auto; margin-right: auto; "></img>
                </div>
                <div class="text-container">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front">
                                <p class="title">Sign out</p>
                            </div>
                            <div class="back">
                                <p class="description">Goodbye until next time!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
</div>
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