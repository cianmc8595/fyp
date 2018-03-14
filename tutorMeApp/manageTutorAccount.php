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
        		    
$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') 
            or die ('Cannot connect to db');

                $dataRetrieval = mysqli_query($mysqli, "SELECT * FROM tutors where tutorID = '".$_SESSION['tutorID']."'");
                $dataRetrievalRow = $dataRetrieval->fetch_assoc();
                $email = $dataRetrievalRow['email'];
                $firstname = $dataRetrievalRow['firstname']; 
                $surname = $dataRetrievalRow['surname'];
                $pastSchool = $dataRetrievalRow['pastSchool'];

     $link = mysqli_connect("127.0.0.1", "cianmc85", "", "project_db");

if (isset($_POST['saveChanges'])) {
    
    // Validate email
    if(empty(trim($_POST['email']))){
        $email_err = "Please enter an email.";     
    } elseif(!filter_var((trim($_POST['email'])), FILTER_VALIDATE_EMAIL)){
        $email_err = "Email must be in correct format.";     
    } else{
        $updatedEmail = trim($_POST['email']);
    }
    
    // Validate firstname
    if(empty(trim($_POST['firstname']))){
        $firstname_err = "Please enter a firstname.";     
    } else{
        $updatedFirstname = trim($_POST['firstname']);
    }
    
    // Validate surname
    if(empty(trim($_POST['surname']))){
        $surname_err = "Please enter a surname.";     
    } else{
        $updatedSurname = trim($_POST['surname']);
    }
    
    // Validate pastSchool
    if(empty(trim($_POST['pastSchool']))){
        $pastSchool_err = "Please enter your past School's name.";     
    } else{
        $updatedPastSchool = trim($_POST['pastSchool']);
    }
    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($surname_err) && empty($email_err) && empty($pastSchool_err)){
    
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "UPDATE tutors SET email=?, firstname=?, surname=?, pastSchool=? WHERE tutorID=?";

        if($stmt = mysqli_prepare($link, $sql)){
        
            mysqli_stmt_bind_param($stmt, "sssss", $updatedEmail, $updatedFirstname, $updatedSurname, $updatedPastSchool, $_SESSION['tutorID']);
        
            if(mysqli_stmt_execute($stmt)){
                        

                echo "Record updated successfully";
                header("location: manageTutorAccount.php");
            } else {
                echo "Error updating record: " . $conn_found->error;
            }

          mysqli_stmt_close($stmt);
          mysqli_close($link);
    }
    }
}

if (isset($_POST['saveNewImage'])) {

$host = "127.0.0.1";
    $user = "cianmc85";
    $pass = "";
    $db = "project_db";
    $port = 3306;

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db, $port);
    // Check connection

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $imageCheckSql = "SELECT image FROM images WHERE userID ='".$_SESSION['tutorID']."' AND usertype = 'Tutor'";
    $imageCheckSqlResult = $conn->query($imageCheckSql);

    if ($imageCheckSqlResult->num_rows > 0) {



$check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
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
        $insert = $db->query("UPDATE images SET image='$imgContent' WHERE userID='".$_SESSION['tutorID']."' AND usertype='Tutor'");
        if($insert){
                echo "Profile Picture updated successfully";
                header("location: manageTutorAccount.php");        
        }else{
            echo "Error updating picture";
        } 
        
        
        
        
    }else{
        echo "Please select a new profile picture to upload.";
    }
}
else{
        
        $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $usertypeForImage = "Tutor";
        $userIDforImage = $_SESSION['tutorID'];
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
            header("location: manageTutorAccount.php");  
        }else{
            echo "File upload failed, please try again.";
        } 
    }else{
        echo "Please select an image file to upload.";
    }
     
        
    }
}
if (isset($_POST['home'])) {
        header("location: TutorsHome.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Tutor Account Management</title>
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
                        <a href="TutorsHome.php" style="margin-top:15px;" >Home</a>
                    </li>
                    <li>
                        <a href="NewCV.php" style="margin-top:15px;" >Add New CV</a>
                    </li>
                    <li>
                        <a href="tutorInbox.php" style="margin-top:15px;" >Inbox</a>
                    </li>
                    <li>
                        <a href="manageMyCVs.php" style="margin-top:15px;" >My CVs</a>
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
        <div class="parallax filter filter-color-blue" style="height:900px;">
            <div class="section" id="login">`
            <div class="container">
            
            <div class="login-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="margin-top:-50px; height:570px; padding-bottom:85px; width:60%; float: left; -webkit-border-radius: 20px 0px 0px 20px;-moz-border-radius: 20px 0px 0px 20px;border-radius: 20px 0px 0px 20px;">
		            <div class="avatar avatar-danger" style="margin-top:-35px;">
			            <img class="img-circle" src="assets/img/faces/tutorsIcon.png" alt="">
		            </div>
                    <h2 class="text-center">Tutor Account Management</h2>   
		            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
		                <label for="email" class:"form-control" style="margin-left:70px;">Email</label>
        	            <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" required="required">
        	            <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                        <label for="firstname" class:"form-control" style="margin-left:70px;">Firstname</label>
        	            <input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $firstname; ?>" required="required">
        	            <span class="help-block"><?php echo $firstname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
                        <label for="surname" class:"form-control" style="margin-left:70px;">Surname</label>
        	            <input type="text" name="surname" class="form-control" placeholder="Surname" value="<?php echo $surname; ?>" required="required">
        	            <span class="help-block"><?php echo $surname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                        <label for="pastSchool" class:"form-control" style="margin-left:70px;">School Attended</label>
                		<select type="text" class="form-control" name="pastSchool">
                    		<option selected value="<?php echo $pastSchool; ?>"><?php echo $pastSchool; ?></option><option value="school">My School is not on this list</option><option value="Ashton School">Ashton School</option>
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
                    <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:85%;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save Changes" name="saveChanges" style="width:40%; float: left; position: relative;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Home" name="home" style="width:40%; float: right; background:#008b9c; position: relative; margin-top:0px;">
                    </div>
                </form>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="margin-top:-50px; height:570px; padding-bottom:85px; width:35%; float: right; -webkit-border-radius: 0px 20px 20px 0px;-moz-border-radius: 0px 20px 20px 0px;border-radius: 0px 20px 20px 0px;">
                    <h2 class="text-center">Edit Profile Picture</h2> 
                    <?php
	                                if ($_SESSION['pictureCheck'] === "True"){
	                                    echo '<img style="height:220px; width:65%;display: block; margin-left: auto; margin-right: auto; border: solid 2px #00899C;" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['profilePic'] ).'"/>';
	                                }
	                                elseif ($_SESSION['pictureCheck'] === "False"){
	                                    echo '<img style="height:220px; width:85%;display: block; margin-left: auto; margin-right: auto; border: solid 2px #00899C;" src="headshot.jpg"/>';
	                                }
	                ?>
                    <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:100%;">
                        <input type="file" name="image" class="btn btn-primary btn-lg btn-block"/>
                    </div>
                     <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:85%;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save New Picture" name="saveNewImage" style="width:80%; margin: 0 auto; position: relative;">
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
