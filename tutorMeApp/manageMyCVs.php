<script>function copyValue() {
    var dropboxvalue = document.getElementById('mydropbox').value;
    document.getElementById('test').value = dropboxvalue;
}
</script>
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

if (isset($_POST['view'])) {
    
    $cvtoView = $_POST['mydropbox'];

    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    /*$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') */
      $mysqli = new mysqli('eu-cdbr-west-02.cleardb.net', 'bdff3cc89b8df5',
                        '25912b2f', 'heroku_6a6bf0a23aababd')
            or die ('Cannot connect to db');

                $result = mysqli_query($mysqli, "SELECT * FROM CVs where cvID = '".$cvtoView."'");
                $row = $result->fetch_assoc();
                $_SESSION['cvIDchosen'] = $row['cvID']; 
                $tutorID = $row['tutorID']; 
                $cvsubject = $row['subject'];
                $referenceTeacher = $row['referenceTeacher'];
                $grade = $row['lcGrade'];
                $lcyear = $row['lcYear'];
                $cvabout = $row['about'];
                $cvverification = $row['verification'];

} 
elseif(isset($_POST['home'])){
                header("location: TutorsHome.php");
}
    
$link = mysqli_connect("eu-cdbr-west-02.cleardb.net", "bdff3cc89b8df5", "25912b2f", "heroku_6a6bf0a23aababd");

if (isset($_POST['saveChanges'])) {
    
    $updatedSubject = $_POST['Subject'];
    $updatedTeacher = $_POST['referenceTeacher'];
    $updatedGrade = $_POST['Grade'];
    $updatedLCYear = $_POST['lcYear'];
    $updatedAbout = $_POST['about'];
    $cvToUpdate = $_POST['cvID'];
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
            echo "link false</br>";

    }

    $sql = "UPDATE CVs SET subject=?, referenceTeacher=?, lcGrade=?, lcYear=?, about=? WHERE cvID=?";

    if($stmt = mysqli_prepare($link, $sql)){
        
        mysqli_stmt_bind_param($stmt, "ssssss", $updatedSubject, $updatedTeacher, $updatedGrade, $updatedLCYear, $updatedAbout, $_SESSION['cvIDchosen']);
        
        if(mysqli_stmt_execute($stmt)){
                        

            header("location: manageMyCVs.php");
        } else {
            echo "Error updating record: " . $conn_found->error;
        }

      mysqli_stmt_close($stmt);
      mysqli_close($link);
    }
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
        <div class="parallax filter filter-color-blue" style="height:1500px;">
            <div class="section" id="login">`
            <div class="container">
            
            <div class="login-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#formResults" method="post" enctype="multipart/form-data" style="padding-bottom:145px; margin-top:-250px; -webkit-border-radius: 40px 40px 0px 0px;-moz-border-radius: 40px 40px 0px 0px;border-radius: 40px 40px 0px 0px;">
                    <h2 class="text-center">My CVs</h2>
                    <?php
                    
// With help from http://jsfiddle.net/My7D5/ & https://www.sitepoint.com/community/t/populate-dropdown-menu-from-mysql-database/6481/7
  /*$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') */
    $mysqli = new mysqli('eu-cdbr-west-02.cleardb.net', 'bdff3cc89b8df5',
                        '25912b2f', 'heroku_6a6bf0a23aababd') 
           or die ('Cannot connect to db');

    $result = mysqli_query($mysqli, "SELECT cvID, subject FROM CVs where tutorID = '".$_SESSION['tutorID']."'");
    
    if($result->num_rows > 0){
        
        echo "<h3 class='text-center'>To view and edit one of your CVs, select it from the list below and select 'View CV'!</h3>";
        echo "<select style='width:30%; display:block; margin: 0 auto; margin-top:30px;' class='btn btn-primary dropdown-toggle' name='mydropbox' id='mydropbox' onchange='copyValue()'>";

        while ($row = $result->fetch_assoc()) {

                  unset($cvID, $verification, $subject);
                  $cvID = $row['cvID'];
                  $subject = $row['subject'];
                  echo '<option value="'.$cvID.'">'.$subject.'</option>';

        }

        echo "</select>";
        
        echo '<div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:85%;">
                    <a href="#formResults" style="text-decoration: none;"><input type="submit" class="btn btn-primary btn-lg btn-block" value="View CV" name="view" style="width:35%; float: left; background:#008b9c; position: relative; margin-top:30px;"></a>
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Home" name="home" style="width:35%; float: right; background:#008b9c; position: relative; margin-top:30px;">
                </div>';
        
    }
    else {
        
        echo "<h3 class='text-center'>It looks like you haven't registered any CVs with us yet!</br>
        To add a CV to your account so that you can find students to tutor,<b><a href='NewCV.php' style='color:#326970;'> click here!</a><b></h3>";
        echo "<div style='width:100%;'>
                <img src='nothingfound.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto; margin-top:-70px;'></img>
             </div>";
    }
    

?>
                    
                </form>
                <form id="formResults" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="padding-bottom:85px; padding-top:85px; margin-top:50px; -webkit-border-radius: 0px 0px 40px 40px;-moz-border-radius: 0px 0px 40px 40px;border-radius: 0px 0px 40px 40px;">
                    <h3 class="text-center"><b>CV Editor<b></b></h3>
		            <div class="form-group <?php echo (!empty($cvID_err)) ? 'has-error' : ''; ?>">
        	            <input type="text" name="cvID" style="visibility:hidden; margin-top:-50px;" class="form-control" value="<?php echo $_SESSION['cvIDchosen']; ?>" disabled >
                    </div>
		            <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                		<label style="margin-left:120px;">Subject:<sup>*</sup></label>
                		<select type="text" class="form-control" name="Subject">
                    		<option selected value="<?php echo $cvsubject; ?>"><?php echo $cvsubject; ?></option>
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
                        <label style="margin-left:120px;">Reference Teacher:<sup>*</sup></label>
            		<?php
            		
            		//jsfiddle.net/My7D5/ & https://www.sitepoint.com/community/t/populate-dropdown-menu-from-mysql-database/6481/7
					/*$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') */
            		  $mysqli = new mysqli('eu-cdbr-west-02.cleardb.net', 'bdff3cc89b8df5',
                        '25912b2f', 'heroku_6a6bf0a23aababd') 
            		  	or die ('Cannot connect to db');

    				$result = mysqli_query($mysqli, "SELECT teacherID, firstname, surname FROM teachers WHERE school = '".$_SESSION['pastSchool']."'");
    				
    				echo "<select class='form-control' name='referenceTeacher' id='mydropbox' onchange='copyValue()'>";
					echo "<option selected value='".$referenceTeacher."'>".$referenceTeacher."</option>";
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
                		<label style="margin-left:120px;">Grade:<sup>*</sup></label>
                		<select type="text" class="form-control" name="Grade">
                    		<option selected value="<?php echo $grade; ?>"><?php echo $grade; ?></option>
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
                		<label style="margin-left:120px;">LC Year:<sup>*</sup></label>
                		<select type="text" class="form-control" name="lcYear">
                    		<option selected value="<?php echo $lcyear; ?>"><?php echo $lcyear; ?></option><option value="2017">2017</option>
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
        	            <label style="margin-left:120px;">About:<sup>*</sup></label>
        	            <textarea style="overflow:auto;resize:none; height:100%;" name="about" class="form-control" value="<?php echo $cvabout; ?>"><?php echo $cvabout; ?></textarea>
        	            <span class="help-block"><?php echo $about_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($verification_err)) ? 'has-error' : ''; ?>">
        	            <label style="margin-left:120px;">Verified CV?<sup>*</sup></label>
        	            <input type="text" name="verification" class="form-control" value="<?php echo $cvverification; ?>" disabled>
        	            <span class="help-block"><?php echo $verification_err; ?></span>
                    </div>
                     <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Save Changes" name="saveChanges" style="width:40%; float: left; position: relative;">
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