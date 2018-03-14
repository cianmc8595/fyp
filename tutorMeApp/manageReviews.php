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

if($_SESSION['usertype'] !== 'Teacher'){
  header("location: ".$_SESSION['usertype']."sHome.php");
}

$link = mysqli_connect("127.0.0.1", "cianmc85", "", "project_db");

if (isset($_POST['approve'])) {
    
    $reviewToApprove = $_POST['approve'];
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
            echo "link false</br>";

    }

    $sql = "UPDATE reviews SET verification='Approved' WHERE reviewID=?";

    if($stmt = mysqli_prepare($link, $sql)){
        
        mysqli_stmt_bind_param($stmt, "s", $reviewToApprove);
        
        if(mysqli_stmt_execute($stmt)){
                        
            header("location: manageReviews.php");
        } else {
            echo "Error updating record: " . $conn_found->error;
        }

      mysqli_stmt_close($stmt);
      mysqli_close($link);
    }
}

if (isset($_POST['remove'])) {
    
    $reviewToRemove = $_POST['remove'];
    
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
            echo "link false</br>";

    }

    $sql = "DELETE FROM reviews WHERE reviewID=?";

    if($stmt = mysqli_prepare($link, $sql)){
        
        mysqli_stmt_bind_param($stmt, "s", $reviewToRemove);
        
        if(mysqli_stmt_execute($stmt)){
                        
            header("location: manageReviews.php");
        } else {
            echo "Error updating record: " . $conn_found->error;
        }

      mysqli_stmt_close($stmt);
      mysqli_close($link);
    }
}
if (isset($_POST['TeachersHome'])) {
            header("location: TeachersHome.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Manage Reviews & Ratings</title>
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
	
	#inbox {
	    width:95%;
	    margin:0 auto;
	    background: #fff;
	    display:block; width:100%;overflow:auto;display:table;
	}
	
	#inbox img {
	     position:relative; 
	     margin-top:10px;
	     height:80px; 
	     width:80px;
	}
	
	#inbox td {
	     vertical-align: middle;
    display: table-cell;
    text-align:center;
    font-size: 16px;
    border-bottom: 1px solid #00899C;
    font-weight: bold;
	}
	
	#inbox th {
	     vertical-align: middle;
    display: table-cell;
    text-align:center;
    font-size: 20px;
    background:#00899C;
    color: white;
    
    
	}
	
	#button {
	    width:80%;
	    margin: 0 auto;
	}
	
	
tbody {
    
    display:block;
    height:550px;
    overflow:auto;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;/* even columns width , fix width of table too*/
}
thead {
    width: calc( 100% - 1em )/* scrollbar is average 1em/16px width, remove it from thead width */
}
table {
    width:400px;
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
        <div class="parallax filter filter-color-blue" style="height:5500px;">
            <div class="section" id="login">`
            <div class="container">
            
            <div class="login-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="padding-bottom:85px; margin-top:-250px;
                                 -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;">
                    <h2 class="text-center">Reviews and Ratings Approval</h2>
                    
                    <?php
                    
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
                        
                        $tutorIDRetrieveSql = "SELECT distinct tutorID FROM CVs WHERE referenceTeacher ='".$_SESSION['teacherID']."'";
                        $tutorIDRetrieveSqlResult = $conn->query($tutorIDRetrieveSql);
                        
                        if ($tutorIDRetrieveSqlResult->num_rows > 0) { 
                            
                            $reviewIDArray = array();
                            echo "<h4 class='text-center'>Students on TutorLink have the ability to leave reviews and ratings on the CVs of any tutors they interact with.</br> 
                                This is to provide their fellow students with honest reviews of each tutor so that their fellow</br> students can make more informed decisions about tutors.</br>
                                Reviews for each tutor need to be approved by that tutor's reference teacher before going public.</br>
                                Please review and approve the following reviews unless you perceive them to be in violation of our guidelines.</h4>";
                            echo "<table class='table' id='inbox' style='display:block;'><tr><th style='text-align:left; padding-left:30px;'>Tutor</th><th style='text-align:left;'>Review</th>
                                <th>Rating</th><th></th><th></th></tr>";
                            
                            while($tutorIDRetrieveRow = $tutorIDRetrieveSqlResult->fetch_assoc()) {
                                
                                $reviewRetrieveSql = "SELECT * FROM reviews WHERE tutorID ='".$tutorIDRetrieveRow['tutorID']."' AND verification = 'Unapproved'";
                                $reviewRetrieveSqlResult = $conn->query($reviewRetrieveSql);
                
                                if ($reviewRetrieveSqlResult->num_rows > 0) { 
                                    while($reviewRetrieveSqlRow = $reviewRetrieveSqlResult->fetch_assoc()) {
                                            
                                            $reviewIDArray[] = $reviewRetrieveSqlRow['reviewID'];
                                    }
                                }

                            }
                            
                            array_walk($reviewIDArray , 'intval');
                            $reviewIDs = implode(',', $reviewIDArray);
                            
                            $dataRetrieveSql = "SELECT * FROM reviews WHERE reviewID IN ($reviewIDs)";
                            $dataRetrieveSqlResult = $conn->query($dataRetrieveSql);
                            
                            if ($dataRetrieveSqlResult->num_rows > 0) { 
    
                                while($dataRetrieveRow = $dataRetrieveSqlResult->fetch_assoc()) {
            
                                    $tutorNameRetrieveSql = "SELECT firstname, surname FROM tutors WHERE tutorID ='".$dataRetrieveRow['tutorID']."'";
                                    $tutorNameRetrieveSqlResult = $conn->query($tutorNameRetrieveSql);
                                    $tutorNameRetrieveRow = $tutorNameRetrieveSqlResult->fetch_assoc();
                                    
                                    echo "<tr><td style='text-align:left;'>".$tutorNameRetrieveRow['firstname']. " ".$tutorNameRetrieveRow['surname']."</td><td style='text-align:left;'>" . $dataRetrieveRow['review'] . "</td>
                                        <td style='text-align:left;'>". $dataRetrieveRow['rating']. "</td>
                                        <td><button name='approve' id='button' class='btn btn-primary btn-lg btn-block' value=".$dataRetrieveRow['reviewID']." type='submit' style='width:100%;'>Approve</button></td>
                                        <td><button name='remove' id='button' class='btn btn-primary btn-lg btn-block' value=".$dataRetrieveRow['reviewID']." type='submit'>Remove</button></td></tr>";
                                    
                                }
                            }
                            else {
                                echo "<h4 class='text-center'>You do not currently have any reviews to approve.</br></br></br></h4>
                                        <div style='width:100%;'>
                                            <img src='nothingfound.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto; margin-top:-120px;'></img>
                                        </div>
                                        <button name='TeachersHome' id='button' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%; margin-top:20px;'>Home</button>";
                            }
                        }
                        else {
                            echo "<h4 class='text-center'>No tutors have listed you as their reference teacher yet. You will not have to approve any reviews</br>
                                until a tutor references you on their CV, and recieves a review on that CV.</br></br></br></h4>
                                        <div style='width:100%;'>
                                            <img src='nothingfound.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto; margin-top:-120px;'></img>
                                        </div>
                                        <button name='TeachersHome' id='button' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%; margin-top:20px;'>Home</button>";
                        }
                        
                        
                        
                        
                        
                        
                       
                    
                ?>    
                </form>
            </div>
            
            </div>
            </div>
        </div>
    </div>
<!-- END of modified code -->

    

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
