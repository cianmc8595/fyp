<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}/* END */

if($_SESSION['usertype'] !== 'Student'){
  header("location: ".$_SESSION['usertype']."sHome.php");
}

/*$host = "127.0.0.1";
$user = "cianmc85";
$pass = "";
$db = "project_db";
$port = 3306;*/

$host = "eu-cdbr-west-02.cleardb.net";
$user = "bdff3cc89b8df5";
$pass = "25912b2f";
$db = "heroku_6a6bf0a23aababd";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
// Check connection
                    
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['sendReview']))
{
    $review = $_POST['review']; 
    
    $radioVal = $_POST["star"];

    // Check input errors before inserting in database
    if(empty($review) || empty($radioVal)){
        
        echo "Must enter both a review and rating in order to submit";
        
    }
    else {
        
        /*$host = "127.0.0.1";
        $user = "cianmc85";
        $pass = "";
        $db = "project_db";
        $port = 3306;*/

        $host = "eu-cdbr-west-02.cleardb.net";
        $user = "bdff3cc89b8df5";
        $pass = "25912b2f";
        $db = "heroku_6a6bf0a23aababd";

		// Create connection
		$conn = new mysqli($host, $user, $pass, $db);
		// Check connection
                    
		if ($conn->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
		    }

        $CVIDRetrieveSql = "SELECT cvID FROM conversations where convID = '".$_SESSION['conversationToView']."'";
    	$CVIDRetrieveSqlResult = $conn->query($CVIDRetrieveSql);
        
        $cvRow = $CVIDRetrieveSqlResult->fetch_assoc();
                                    
        $cvid = $cvRow['cvID'];
        
        $tutorIDRetrieveSql = "SELECT * FROM CVs where cvID = '".$cvid."'";
    	$tutorIDRetrieveSqlResult = $conn->query($tutorIDRetrieveSql);
        
        $tutorRow = $tutorIDRetrieveSqlResult->fetch_assoc();
                                    
        $tutorID = $tutorRow['tutorID'];
        $cvsubject = $tutorRow['subject'];
        $reviewVerification = "Unapproved";
        $studentWhoWroteReview = $_SESSION['username'];
        
        $reviewIDRetrieveSql = "SELECT reviewID FROM reviews ORDER BY reviewID DESC LIMIT 1";
    	$reviewIDRetrieveSqlResult = $conn->query($reviewIDRetrieveSql);
        
        $reviewRow = $reviewIDRetrieveSqlResult->fetch_assoc();
        
        $reviewID = $reviewRow['reviewID'];
        $reviewID = $reviewID + 1;
        
        // Prepare an insert statement
        $SQL = $conn->prepare("INSERT INTO reviews (reviewID, tutorID, review, rating, verification, studentUsername, subject) VALUES (?, ?, ?, ?, ?, ?, ?)");
         
        if($conn){
            // Bind variables to the prepared statement as parameters
            $SQL->bind_param('sssssss', $param_reviewID, $param_tutorID, $param_review, $param_rating, $param_verification, $param_stuUName, $param_subject); 
            
            
            // Set parameters
            $param_reviewID = $reviewID;
            $param_tutorID = $tutorID;
            $param_review = $review; 
            $param_rating = $radioVal;
            $param_verification = $reviewVerification;
            $param_stuUName = $studentWhoWroteReview;
            $param_subject = $cvsubject;
            
            // Attempt to execute the prepared statement
            if($SQL->execute()){
                // Redirect to Tutors Homepage
                header("location: tutorInbox.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $SQL->close();
        
    }
}
if(isset($_POST['inbox']))
{
                header("location: tutorInbox.php");
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
    <title>Rate & Review</title>
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
	
	form .stars {
  background: url("stars.png") repeat-x 0 0;
  width: 150px;
  margin: 0 auto;
}
 
form .stars input[type="radio"] {
  position: absolute;
  opacity: 0;
  filter: alpha(opacity=0);
}
form .stars input[type="radio"].star-5:checked ~ span {
  width: 100%;
}
form .stars input[type="radio"].star-4:checked ~ span {
  width: 80%;
}
form .stars input[type="radio"].star-3:checked ~ span {
  width: 60%;
}
form .stars input[type="radio"].star-2:checked ~ span {
  width: 40%;
}
form .stars input[type="radio"].star-1:checked ~ span {
  width: 20%;
}
form .stars label {
  display: block;
  width: 30px;
  height: 30px;
  margin: 0!important;
  padding: 0!important;
  text-indent: -999em;
  float: left;
  position: relative;
  z-index: 10;
  background: transparent!important;
  cursor: pointer;
}
form .stars label:hover ~ span {
  background-position: 0 -30px;
}
form .stars label.star-5:hover ~ span {
  width: 100% !important;
}
form .stars label.star-4:hover ~ span {
  width: 80% !important;
}
form .stars label.star-3:hover ~ span {
  width: 60% !important;
}
form .stars label.star-2:hover ~ span {
  width: 40% !important;
}
form .stars label.star-1:hover ~ span {
  width: 20% !important;
}
form .stars span {
  display: block;
  width: 0;
  position: relative;
  top: 0;
  left: 0;
  height: 30px;
  background: url("stars.png") repeat-x 0 -60px;
  -webkit-transition: -webkit-width 0.5s;
  -moz-transition: -moz-width 0.5s;
  -ms-transition: -ms-width 0.5s;
  -o-transition: -o-width 0.5s;
  transition: width 0.5s;
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
                        <a href="StudentsHome.php" style="margin-top:15px;" >Home</a>
                    </li>
                    <li>
                        <a href="tutorSearch.php" style="margin-top:15px;" >Tutor Search</a>
                    </li>
                    <li>
                        <a href="tutorInbox.php" style="margin-top:15px;" >Inbox</a>
                    </li>
                    <li>
                        <a href="resources.php" style="margin-top:15px;" >Resources</a>
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
        <div class="parallax filter filter-color-blue" style="height:1200px;">
            <div class="section" id="login">`
            <div class="container">
            <div class="login-form">
            <form action='' id="ratingsForm" method='POST'style='padding-bottom:85px;top:-250px; height:800px;
            -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'>
            <h2 class='text-center'>Rate & Review</h2>
            <h3 class='text-center' style="margin-top:0px;">Submit a review about this tutor so that other students</br> can make more informed desicions on tutors in the future.</h3>
                        
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>" style="height:200px;">
        	    <textarea style="overflow:auto;resize:none; height:100%;" name="review" class="form-control" value="" placeholder="Write your review of this tutor here"></textarea>
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <h3 class='text-center' style="margin-top:40px;">Rate this tutor out of 5 using our star rating system</h2>
            <div class="stars">
                <input type="radio" name="star" class="star-1" id="star-1" value="1"/>
                <label class="star-1" for="star-1">1</label>
                <input type="radio" name="star" class="star-2" id="star-2" value="2"/>
                <label class="star-2" for="star-2">2</label>
                <input type="radio" name="star" class="star-3" id="star-3" value="3"/>
                <label class="star-3" for="star-3">3</label>
                <input type="radio" name="star" class="star-4" id="star-4" value="4"/>
                <label class="star-4" for="star-4">4</label>
                <input type="radio" name="star" class="star-5" id="star-5" value="5"/>
                <label class="star-5" for="star-5">5</label>
                <span></span>
            </div>
            <h5 class='text-center' style="margin-top:40px;">Remember to be fair and truthful when reviewig and rating your tutors!</br> All reviews are monitored by your teachers before being released to the public.</h5>
            <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Submit Review and Rating" name="sendReview" style="width:50%; float: left; position: relative;">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Inbox" name="inbox" style="width:40%; float: right; position: relative; margin-top:0px;">
            </div>
        </form>
            
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
</html>