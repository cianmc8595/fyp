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
  header("location: LandingPage.php#login");
  exit;
}/* END */

if($_SESSION['usertype'] !== 'Tutor'){
  header("location: ".$_SESSION['usertype']."sHome.php");
}

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
$cvID = $subject = $referenceTeacher = $lcGrade = $lcYear = $about = $verification = "";
$cvID_err = $subject_err = $referenceTeacher_err = $lcGrade_err = $lcYear_err = $about_err = $verification_err = "";

// Processing form data when form is submitted
if(isset($_POST["newCV"])){
 
    // Validate subject
    if(empty(trim($_POST[Subject]))){
        $subject_err = "Please enter a subject.";     
    } else{
        $subject = trim($_POST[Subject]);
    }
    
    //check that they don't already have a CV in this subject
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
    
    $checkforCVSql = "SELECT * FROM CVs WHERE tutorID ='".$_SESSION['tutorID']."' AND subject = '".$subject."'";
    $checkforCVSqlResult = $conn->query($checkforCVSql);
    if ($checkforCVSqlResult->num_rows > 0) { 
    
        $subject_err = "You have already registered with a CV in this subject.";
        
    }
    
    
    // Validate referenceTeacher
    if(empty(trim($_POST['referenceTeacher']))){
        $referenceTeacher_err = "Please enter a reference Teacher.";     
    } else{
        $referenceTeacher = trim($_POST['referenceTeacher']);
    }
    
    // Validate lcGrade
    if(empty(trim($_POST[Grade]))){
        $lcGrade_err = "Please enter a lcGrade.";     
    } else{
        $lcGrade = trim($_POST[Grade]);
    }
    
    // Validate lcYear
    if(empty(trim($_POST['lcYear']))){
        $lcYear_err = "Please enter a lcYear.";     
    } else{
        $lcYear = trim($_POST['lcYear']);
    }
    
    // Validate about
    if(empty(trim($_POST['about']))){
        $about_err = "Please enter a paragraph about yourself.";     
    } else{
        $about = trim($_POST['about']);
    }
    
    $verification = "Unverified";
    
    if ($conn_found) {

    $idFetch = $conn_found->prepare('SELECT cvID FROM CVs ORDER BY cvID DESC LIMIT 1');
    
    $idFetch->execute();
    $idFetch->store_result();
    
    $idFetch->bind_result($cvID); 
    $idFetch->fetch();
    $cvID = $cvID + 1;
    
        if(empty($cvID)){
            $cvID_err = "error";
        }
        
    }
    
    // Check input errors before inserting in database
    if(empty($subject_err) && empty($referenceTeacher_err) && empty($lcGrade_err) && empty($lcYear_err) && empty($about_err) && empty($verification_err)){
        
        // Prepare an insert statement
        $SQL = $conn_found->prepare("INSERT INTO CVs (cvID, tutorID, subject, referenceTeacher, lcGrade, lcYear, about, verification) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         
        if($conn_found){
            // Bind variables to the prepared statement as parameters
            $SQL->bind_param('ssssssss', $param_cvID, $param_tutorID, $param_subject, $param_referenceTeacher, $param_lcGrade, $param_lcYear, $param_about, $param_verification);
            
            // Set parameters
            $param_cvID = $cvID;
            $param_tutorID = $_SESSION['tutorID'];
            $param_subject = $subject; 
            $param_referenceTeacher = $referenceTeacher;
            $param_lcGrade = $lcGrade;
            $param_lcYear = $lcYear;
            $param_about = $about;
            $param_verification = $verification;
            
            // Attempt to execute the prepared statement
            if($SQL->execute()){
                // Redirect to Tutors Homepage
                header("location: TutorsHome.php");
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

if(isset($_POST["home"])){

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
    <title>New CV</title>
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
        <div class="parallax filter filter-color-blue" style="height:1500px;">
            <div class="section" id="login">`
            <div class="container">
            
            <div class="login-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="padding-bottom:85px; margin-top:-250px;
                                 -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;">
                    <h2 class="text-center">New CV Registration</h2>   
                    <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="tutorID"class="form-control" value="<?php echo "Tutor ID: " . $_SESSION['tutorID']; ?>" disabled>
        	            <span class="help-block"><?php echo $tutorID_err; ?></span>
                    </div>
		            <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                		<select type="text" class="form-control" name="Subject">
                    		<option selected value="">Select Subject</option>
                    		<option value="Biology">Biology</option>
                    		<option value="Business">Business</option>
                    		<option value="Chemistry">Chemistry</option>
                    		<option value="English">English</option>
                    		<option value="French">French</option>
                    		<option value="Geography">Geography</option>
                    		<option value="German">German</option>
                    		<option value="History">History</option>
                    		<option value="Irish">Irish</option>
                    		<option value="Maths">Maths</option>
                    		<option value="Music">Music</option>
                    		<option value="Physics">Physics</option>
                		</select>
                		<span class="help-block"><?php echo $subject_err; ?></span>
            		</div>
                    <div class="form-group <?php echo (!empty($referenceTeacher_err)) ? 'has-error' : ''; ?>">
            		<?php
            		
            		//jsfiddle.net/My7D5/ & https://www.sitepoint.com/community/t/populate-dropdown-menu-from-mysql-database/6481/7
					$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') 
            			or die ('Cannot connect to db');

    				$result = mysqli_query($mysqli, "SELECT teacherID, firstname, surname FROM teachers WHERE school = '".$_SESSION['pastSchool']."'");
    				
    				echo "<select class='form-control' name='referenceTeacher' id='mydropbox' onchange='copyValue()'>";
					echo "<option selected value=''>Choose a teacher from your past school to reference</option>";
					echo "<option value='NA'>No reference teachers available from my school</option>";
					
    				while ($row = $result->fetch_assoc()) {

                		unset($tID, $fname, $sname);
                		$tID = $row['teacherID'];
                		$fname = $row['firstname'];
                		$sname = $row['surname'];
                		echo '<option value="'.$tID.'">'.$fname." ".$sname.'</option>';

					}

    				echo "</select><span class='help-block'>" .$referenceTeacher_err. "</span>";

					?>
					</div>
		            <div class="form-group <?php echo (!empty($lcGrade_err)) ? 'has-error' : ''; ?>">
                		<select type="text" class="form-control" name="Grade">
                    		<option selected value="">Select the LC grade you achieved in this subject</option>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="B1">B1</option>
                            <option value="B2">B2</option>
                            <option value="B3">B3</option>
                            <option value="C1">C1</option>
                            <option value="C2">C2</option>
                            <option value="C3">C3</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="Fail">Fail</option>
                		</select>
                		<span class="help-block"><?php echo $lcGrade_err; ?></span>
            		</div>
                    <div class="form-group <?php echo (!empty($lcYear_err)) ? 'has-error' : ''; ?>">
                		<select type="text" class="form-control" name="lcYear">
                    		<option selected value="">Select the year you completed the LC</option><option value="2017">2017</option>
                            <option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option>
                            <option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option>
                            <option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option>
                            <option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option>
                            <option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option>
	                        <option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option>
	                        <option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option>
	                        <option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option>
	                        <option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option>
	                        <option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option>
	                        <option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option>
	                        <option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option>
	                        <option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option>
	                        <option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option>
                            <option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option>
                            <option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option>
	                        <option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option>
	                        <option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option>
	                        <option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option>
                            <option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option>
	                        <option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option>
	                        <option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option>
	                        <option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option>
	                        <option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option>
	                        <option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option>
	                        <option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option>
	                        <option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option>
	                        <option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option>
	                        <option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option>
                		</select>
                		<span class="help-block"><?php echo $lcYear_err; ?></span>
            		</div>
                    <div style="height:150px; margin-bottom:30px;" class="form-group <?php echo (!empty($about_err)) ? 'has-error' : ''; ?>">
        	            <textarea style="overflow:auto;resize:none; height:100%;" name="about" class="form-control" value="<?php echo $about; ?>" placeholder="Write a short paragraph explaining why a student should choose you"></textarea>
        	            <span class="help-block"><?php echo $about_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($verification_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="verification" class="form-control" value="Verification Status:  Unverified" disabled>
        	            <span class="help-block"><?php echo $verification_err; ?></span>
                    </div>
                     <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Register New CV" name="newCV" style="width:40%; float: left; position: relative;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Home" name="home" style="width:40%; float: right; position: relative; margin-top:0px;">
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
