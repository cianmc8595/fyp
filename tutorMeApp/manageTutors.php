<script>function copyValue() {
    var dropboxvalue = document.getElementById('mydropbox').value;
    document.getElementById('test').value = dropboxvalue;
}</script>
<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}/* END */

if($_SESSION['usertype'] !== 'Teacher'){
  header("location: ".$_SESSION['usertype']."sHome.php");
}


            if($_POST){
            $selected_CVID = $_POST['mydropbox'];
            }


            /*$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db')*/ 
            $mysqli = new mysqli('eu-cdbr-west-02.cleardb.net', 'bdff3cc89b8df5',
                        '25912b2f', 'heroku_6a6bf0a23aababd')
            or die ('Cannot connect to db');

                $result = mysqli_query($mysqli, "SELECT * FROM CVs where cvID = '".$selected_CVID."'");
                $row = $result->fetch_assoc();
                $retrieved_CVID = $row['cvID'];
                $retrieved_TutorID = $row['tutorID']; 
                $retrieved_subject = $row['subject'];
                $retrieved_ReferenceTeacher = $row['referenceTeacher'];
                $retrieved_lcGrade = $row['lcGrade'];
                $retrieved_lcYear = $row['lcYear'];
                $retrieved_about = $row['about'];
                $retrieved_Verification = $row['verification'];

$link = mysqli_connect("eu-cdbr-west-02.cleardb.net", "bdff3cc89b8df5", "25912b2f", "heroku_6a6bf0a23aababd");

if (isset($_POST['saveChanges'])) {
    
    $updatedVerification = $_POST['Verification'];
    $cvToUpdate = $_POST['cvID'];
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql = "UPDATE CVs SET verification=? WHERE cvID=?";

    if($stmt = mysqli_prepare($link, $sql)){
        
        mysqli_stmt_bind_param($stmt, "ss", $updatedVerification, $cvToUpdate);
        
        if(mysqli_stmt_execute($stmt)){
                        

            echo "Record updated successfully";
            header("location: manageTutors.php");
        } else {
            echo "Error updating record: " . $conn_found->error;
        }

      mysqli_stmt_close($stmt);
      mysqli_close($link);
    }
} elseif(isset($_POST['home']))
{
                header("location: TeachersHome.php");
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
    <title>Tutor Management</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
    
    
    
    
    
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Tutor Management</title>
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
                        <a href="TeachersHome.php" style="margin-top:15px;" >Home</a>
                    </li>
                    <li>
                        <a href="manageTutors.php" style="margin-top:15px;" >Tutors</a>
                    </li>
                    <li>
                        <a href="tutorInbox.php" style="margin-top:15px;" >Interactions</a>
                    </li>
                    <li>
                        <a href="manageReviews.php" style="margin-top:15px;" >Reviews & Ratings</a>
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
        <div class="parallax filter filter-color-blue" style="height:2100px;">
            <div class="section" id="login">`
            <div class="container">
            <div class="login-form">
               
               
               <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#formResults" method="post" enctype="multipart/form-data" style="padding-bottom:145px; margin-top:-250px; -webkit-border-radius: 40px 40px 0px 0px;-moz-border-radius: 40px 40px 0px 0px;border-radius: 40px 40px 0px 0px;">
                    <h2 class='text-center'>Manage Tutors and CVs</h2>
            <h3 class='text-center' style="margin-top:0px;">The following are the CVs on which you have been chosen as a reference teacher.</br>It is your job to verify these CVs if you deem their information to be true and accurate.
            </br></br>Select a CV from your list and click submit to view and verify the CV's information.</h3>
                    <?php
// Initialize the session
session_start();



// With help from http://jsfiddle.net/My7D5/ & https://www.sitepoint.com/community/t/populate-dropdown-menu-from-mysql-database/6481/7
  /*$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db')*/ 
            $mysqli = new mysqli('eu-cdbr-west-02.cleardb.net', 'bdff3cc89b8df5',
                        '25912b2f', 'heroku_6a6bf0a23aababd')
            or die ('Cannot connect to db');

    $result = mysqli_query($mysqli, "SELECT * FROM CVs where referenceTeacher = '".$_SESSION['teacherID']."'");
    
    if($result->num_rows > 0){ 
        
    echo "<select  style='width:50%; display:block; margin: 0 auto; margin-top:30px;'  class='btn btn-primary dropdown-toggle' name='mydropbox' id='mydropbox' onchange='copyValue()'>";

    while ($row = $result->fetch_assoc()) {

                  unset($cvID, $verification, $subject);
                  $cvID = $row['cvID'];
                  $subject = $row['subject'];
                  $verification = $row['verification']; 
                  $tutorID = $row['tutorID'];
                  $nameSearch = mysqli_query($mysqli, "SELECT firstname, surname FROM tutors where tutorID = '".$tutorID."'");
                  $rowName = $nameSearch->fetch_assoc();
                  $fname = $rowName['firstname'];
                  $sname = $rowName['surname'];
                  echo '<option value="'.$cvID.'">Tutor: '.$fname.' '.$sname.'  &nbsp;&nbsp;&nbsp;  Subject: '.$subject.'  &nbsp;&nbsp;&nbsp;  CV Status: '.$verification.'</option>';

}

    echo "</select>";
}
else{
    echo "<h3 class='text-center'>It looks like you haven't been referenced on any tutor's CVs yet. Check again later!</br></h3>";
        echo "<div style='width:100%;'>
                <img src='nothingfound.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto; margin-top:-70px;'></img>
             </div>";
}
?>
                
                    
                <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:85%;">
                    <a href="#formResults" style="text-decoration: none;"><input type="submit" class="btn btn-primary btn-lg btn-block" value="View CV Information" name="submit" style="width:35%; float: left; background:#008b9c; position: relative; margin-top:30px;"></a>
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Home" name="home" style="width:35%; float: right; background:#008b9c; position: relative; margin-top:30px;">
                </div>
                    
                
                    
                </form>
               <form id="formResults" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="padding-bottom:85px; padding-top:85px; margin-top:50px; -webkit-border-radius: 0px 0px 40px 40px;-moz-border-radius: 0px 0px 40px 40px;border-radius: 0px 0px 40px 40px;">
                    <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">CV ID:<sup>*</sup></label>
                <input type="text" name="cvID"class="form-control" value="<?php echo $retrieved_CVID; ?>" readonly="readonly">
            </div>
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">Tutor ID:<sup>*</sup></label>
                <input type="text" name="tutorID"class="form-control" value="<?php echo $retrieved_TutorID; ?>" disabled>
            </div>   
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">Subject:<sup>*</sup></label>
                <input type="text" name="subject"class="form-control" value="<?php echo $retrieved_subject; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">Reference Teacher:<sup>*</sup></label>
                <input type="text" name="referenceTeacher"class="form-control" value="<?php echo $retrieved_ReferenceTeacher; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">LC Grade:<sup>*</sup></label>
                <input type="text" name="lcGrade"class="form-control" value="<?php echo $retrieved_lcGrade; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">LC Year:<sup>*</sup></label>
                <input type="text" name="lcYear"class="form-control" value="<?php echo $retrieved_lcYear; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">About:<sup>*</sup></label>
                <input type="text" name="about"class="form-control" value="<?php echo $retrieved_about; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                <label style="margin-left:115px;">Verified CV?<sup>*</sup></label>
                <select type="text" class="form-control" name="Verification">
                    <option selected value="<?php echo $retrieved_Verification; ?>"><?php echo $retrieved_Verification; ?></option>
                    <option value="Unverified">Unverified</option>
                    <option value="Verified ">Verified</option>
                </select>
                <span class="help-block"><?php echo $subject_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save Changes" name="saveChanges" style="width:45%; margin:0 auto; background:#008b9c; position: relative; margin-top:30px;">
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