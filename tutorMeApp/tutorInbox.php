<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: LandingPage.php");
  exit;
}/* END */

if (isset($_POST["mybutton"]))
    {
        $_SESSION['conversationToView'] = $_POST["mybutton"];
        $_SESSION['studentNavigatingFrom'] = "Inbox";
        header("location: messenger.php");
    }
    elseif (isset($_POST["reviewbtn"]))
    {
        $_SESSION['conversationToView'] = $_POST["reviewbtn"];
        $_SESSION['studentNavigatingFrom'] = "Inbox";
        header("location: review.php");
    }
    
    if (isset($_POST["TutorHome"]))
    {
        header("location: TutorsHome.php");
    }
    elseif (isset($_POST["StudentHome"]))
    {
        header("location: StudentsHome.php");
    }
    elseif (isset($_POST["TeacherHome"]))
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
    <title>Inbox - <?php echo $_SESSION['usertype']; ?></title>
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
                        <a href="<?php echo $_SESSION['usertype']; ?>sHome.php" style="margin-top:15px;" >Home</a>
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
        <div class="parallax filter filter-color-blue" style="height:2900px;">
            <div class="section" id="login">`
            <div class="container">
            <div class="login-form">
            
            <?php
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

if ($_SESSION['usertype'] === "Tutor"){

    $CVRetrieveSql = "SELECT cvID FROM CVs where tutorID = '".$_SESSION['tutorID']."'";
    $CVRetrieveSqlResult = $conn->query($CVRetrieveSql);

    // set array
    $CVArray = array();

    if ($CVRetrieveSqlResult->num_rows > 0) { 

            // output data of each row
            while($CVRetrieveRow = $CVRetrieveSqlResult->fetch_assoc()) {
            
                // add each row returned into an array
                $CVArray[] = $CVRetrieveRow['cvID'];

            }
        
    } 

    array_walk($CVArray , 'intval');
    $CVids = implode(',', $CVArray);
    $messageRetrieveSql = "SELECT distinct convID FROM conversations WHERE cvID IN ($CVids)";
    $messageRetrieveSqlResult = $conn->query($messageRetrieveSql);

    $intIDArray = array();

    if ($messageRetrieveSqlResult->num_rows > 0) { 
            
        echo "<form action='' method='POST'style='padding-bottom:85px; margin-top:-250px;
                                 -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'>
                                 <h2 class='text-center'>Inbox</h2>
                                 <table class='table' id='inbox' style='display:block;'><tr><th style='text-align:left; padding-left:30px;'>Student</th><th style='text-align:left;'>Subject</th><th>Message Preview</th><th>Date Sent/Received</th><th></th></tr>";
            // output data of each row
        while($MessageRetrieveRow = $messageRetrieveSqlResult->fetch_assoc()) {
            
                $intIDRetrieveSql = "SELECT max(interactionID) FROM conversations WHERE convID ='".$MessageRetrieveRow['convID']."'";
                $intIDRetrieveSqlResult = $conn->query($intIDRetrieveSql);
                
                if ($intIDRetrieveSqlResult->num_rows > 0) { 
                
                    $intIDRetrieveSqlRow = $intIDRetrieveSqlResult->fetch_assoc();
                    $intIDArray[] = $intIDRetrieveSqlRow['max(interactionID)'];
                    
                }

        } 
        
        array_walk($intIDArray , 'intval');
        $interactionIDs = implode(',', $intIDArray);

        
        $dataRetrieveSql = "SELECT * FROM conversations WHERE interactionID IN ($interactionIDs) ORDER BY interactionID DESC";
    $dataRetrieveSqlResult = $conn->query($dataRetrieveSql);

    if ($dataRetrieveSqlResult->num_rows > 0) { 
    
            while($dataRetrieveRow = $dataRetrieveSqlResult->fetch_assoc()) {
            
                $studentImageRetrieveSql = "SELECT image FROM images WHERE userID ='".$dataRetrieveRow['studentID']."' AND usertype = 'Student'";
                $studentImageRetrieveSqlResult = $conn->query($studentImageRetrieveSql);
                $studentImageRetrieveRow = $studentImageRetrieveSqlResult->fetch_assoc();
                $imageStudent = $studentImageRetrieveRow['image'];
                
                $studentUsernameRetrieveSql = "SELECT username FROM students WHERE studentID ='".$dataRetrieveRow['studentID']."'";
                $studentUsernameRetrieveSqlResult = $conn->query($studentUsernameRetrieveSql);
                $studentUsernameRetrieveRow = $studentUsernameRetrieveSqlResult->fetch_assoc();
                
                $subjectRetrieveSql = "SELECT subject FROM CVs WHERE cvID ='".$dataRetrieveRow['cvID']."'";
                $subjectRetrieveSqlResult = $conn->query($subjectRetrieveSql);
                $subjectRetrieveRow = $subjectRetrieveSqlResult->fetch_assoc();
                
                if ($dataRetrieveRow['sender'] === "Student"){
                    $highlight = "style='background:#BFDCE0;'";
                    $highlightAdd = "background:#BFDCE0;";
                }
                elseif ($dataRetrieveRow['sender'] === "Tutor"){
                    $highlight = "style='background:white;'";
                    $highlightAdd = "background:white;";
                }
                elseif ($dataRetrieveRow['sender'] === "Violation"){
                    $highlight = "style='background:#FFD3D3;'";
                    $highlightAdd = "background:#FFD3D3;";
                }
                
                echo "<tr><td style='text-align:left;".$highlightAdd."'>";
                if (!empty($imageStudent)){
	                 echo '<img class="avatar avatar-danger img-circle" src="data:image/jpeg;base64,'.base64_encode( $imageStudent ).'"/>';
	            }
	            elseif (empty($imageStudent)){
	                 echo '<img class="avatar avatar-danger img-circle" src="headshot.jpg"/>';
	            }
                echo " " .$studentUsernameRetrieveRow['username']. "</td><td style='text-align:left;".$highlightAdd."'>" . $subjectRetrieveRow['subject'] . "</td>
                <td style='text-align:left; max-width: 40px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;".$highlightAdd."'>"; if ($dataRetrieveRow['sender'] === $_SESSION['usertype']){echo "You:  ";} echo $dataRetrieveRow['message'] . "</td>
                <td ".$highlight.">" . $dataRetrieveRow['dateTime']. "</td>
                <td ".$highlight."><button name='mybutton' id='button' style='font-size:13px; width:100%;' class='btn btn-primary btn-lg btn-block' value=".$dataRetrieveRow['convID']." type='submit'>Open Conversation</button></td></tr>";
            
            }
    echo "<button name='TutorHome' id='button' style='margin-bottom:30px; width:30%;' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%;'>Home</button>";
    }
        
} else {
    
    echo "<form action='' method='POST' style='padding-bottom:85px;top:-250px; height:880px;
        -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'><h2 class='text-center'>Inbox</h2>
             <h4 class='text-center'>You do not have any ongoing conversations at the moment.</br></br></br></h4>
             <div style='width:100%;'>
                <img src='emptyInbox.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto;'></img>
             </div>
             <h4 class='text-center'></br>You will have to wait to chat until a student chooses to contact you regarding tutorials.</br> To increase your chances of being selected, <a href='manageMyCVs.php' style='color:#326970;'><b>manage your CVs here!<b></a></br></br></h4>
             <button name='TutorHome' id='button' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%;'>Home</button>
         </form>";
         
}
    
    

}
elseif ($_SESSION['usertype'] === "Student"){
    
    $messageRetrieveSql = "SELECT distinct convID FROM conversations WHERE studentID ='".$_SESSION['studentID']."'";
    $messageRetrieveSqlResult = $conn->query($messageRetrieveSql);

    $intIDArray = array();

    if ($messageRetrieveSqlResult->num_rows > 0) { 
            
        echo "<form action='' method='POST' style='padding-bottom:85px;top:-250px; height:1200px;
            -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'><h2 class='text-center'>Inbox</h2><table class='table' id='inbox' style='display:block;'><tr><th style='text-align:left; padding-left:30px;'>Tutor</th><th style='text-align:left;'>Subject</th><th>Message Preview</th><th>Date Sent/Received</th><th></th><th></th></tr>";
            // output data of each row
        while($MessageRetrieveRow = $messageRetrieveSqlResult->fetch_assoc()) {
            
                $intIDRetrieveSql = "SELECT max(interactionID) FROM conversations WHERE convID ='".$MessageRetrieveRow['convID']."'";
                $intIDRetrieveSqlResult = $conn->query($intIDRetrieveSql);
                
                if ($intIDRetrieveSqlResult->num_rows > 0) { 
                
                    $intIDRetrieveSqlRow = $intIDRetrieveSqlResult->fetch_assoc();
                    $intIDArray[] = $intIDRetrieveSqlRow['max(interactionID)'];
                    
                }

        } 
        
        array_walk($intIDArray , 'intval');
        $interactionIDs = implode(',', $intIDArray);

    
    $dataRetrieveSql = "SELECT * FROM conversations WHERE interactionID IN ($interactionIDs) ORDER BY interactionID DESC";
    $dataRetrieveSqlResult = $conn->query($dataRetrieveSql);

    if ($dataRetrieveSqlResult->num_rows > 0) { 
    
            while($dataRetrieveRow = $dataRetrieveSqlResult->fetch_assoc()) {
            
                $tutorIDRetrieveSql = "SELECT tutorID, subject FROM CVs WHERE cvID ='".$dataRetrieveRow['cvID']."'";
                $tutorIDRetrieveSqlResult = $conn->query($tutorIDRetrieveSql);
                $tutorIDRetrieveRow = $tutorIDRetrieveSqlResult->fetch_assoc();
                
                $tutorUsernameRetrieveSql = "SELECT username FROM tutors WHERE tutorID ='".$tutorIDRetrieveRow['tutorID']."'";
                $tutorUsernameRetrieveSqlResult = $conn->query($tutorUsernameRetrieveSql);
                $tutorUsernameRetrieveRow = $tutorUsernameRetrieveSqlResult->fetch_assoc();
                
                $tutorImageRetrieveSql = "SELECT image FROM images WHERE userID ='".$tutorIDRetrieveRow['tutorID']."' AND usertype = 'Tutor'";
                $tutorImageRetrieveSqlResult = $conn->query($tutorImageRetrieveSql);
                $tutorImageRetrieveRow = $tutorImageRetrieveSqlResult->fetch_assoc();
                $imageTutor = $tutorImageRetrieveRow['image'];
                
                $subjectRetrieveSql = "SELECT subject FROM CVs WHERE cvID ='".$dataRetrieveRow['cvID']."'";
                $subjectRetrieveSqlResult = $conn->query($subjectRetrieveSql);
                $subjectRetrieveRow = $subjectRetrieveSqlResult->fetch_assoc();
                
                if ($dataRetrieveRow['sender'] === "Tutor"){
                    $highlight = "style='background:#BFDCE0;'";
                    $highlightAdd = "background:#BFDCE0;";
                }
                elseif ($dataRetrieveRow['sender'] === "Student"){
                    $highlight = "style='background:white;'";
                    $highlightAdd = "background:white;";
                }
                elseif ($dataRetrieveRow['sender'] === "Violation"){
                    $highlight = "style='background:#FFD3D3;'";
                    $highlightAdd = "background:#FFD3D3;";
                }
                
                echo "<tr><td style='text-align:left;".$highlightAdd."'>";
                if (!empty($imageTutor)){
	                                    echo '<img class="avatar avatar-danger  img-circle" src="data:image/jpeg;base64,'.base64_encode( $imageTutor ).'"/>';
	                                }
	                                elseif (empty($imageTutor)){
	                                    echo '<img class="avatar avatar-danger img-circle" src="headshot.jpg"/>';
	                                }
                echo " " .$tutorUsernameRetrieveRow['username']. "</td><td style='text-align:left;".$highlightAdd."'>" . $subjectRetrieveRow['subject'] . "</td>
                <td style='text-align:left; max-width: 40px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;".$highlightAdd."'>"; if ($dataRetrieveRow['sender'] === $_SESSION['usertype']){echo "You:  ";} echo $dataRetrieveRow['message']. "</td>
                <td ".$highlight.">" . $dataRetrieveRow['dateTime']. "</td>
                <td ".$highlight."><button name='mybutton' id='button' style='font-size:13px; width:100%; padding-top:20px; padding-bottom:20px; padding-left:2px;padding-right:2px;' class='btn btn-primary btn-lg btn-block' value=".$dataRetrieveRow['convID']." type='submit' style='width:100%;'>Open Conversation</button></td>
                <td ".$highlight."><button name='reviewbtn' id='button' style='font-size:13px; width:100%; padding-top:20px; padding-bottom:20px; padding-left:2px;padding-right:2px;' class='btn btn-primary btn-lg btn-block' value=".$dataRetrieveRow['convID']." type='submit'>Rate and Review</button></td></tr>";
            
            }
    echo "<button name='TutorHome' id='button' style='margin-bottom:30px; width:30%;' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%;'>Home</button>";
    }
    
} else {
        
    echo "<form action='' method='POST' style='padding-bottom:85px;top:-250px; height:880px;
        -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'><h2 class='text-center'>Inbox</h2>
             <h4 class='text-center'>You do not have any ongoing conversations at the moment.</br></br></br></h4>
             <div style='width:100%;'>
                <img src='emptyInbox.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto;'></img>
             </div>
             <h4 class='text-center'></br> Start a conversation with a tutor via their CV.</br> Browse Tutor's CVs using  our <a href='tutorSearch.php' style='color:#326970;'><b>Tutor Search Feature.<b></a></br></br></h4>
             <button name='StudentHome' id='button' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%;'>Home</button>
         </form>";
    
    
}
    
    

}elseif ($_SESSION['usertype'] === "Teacher"){
    
    $CVRetrieveSql = "SELECT cvID FROM CVs where referenceTeacher = '".$_SESSION['teacherID']."'";
    $CVRetrieveSqlResult = $conn->query($CVRetrieveSql);

    // set array
    $CVArray = array();

    if ($CVRetrieveSqlResult->num_rows > 0) { 

            // output data of each row
            while($CVRetrieveRow = $CVRetrieveSqlResult->fetch_assoc()) {
            
                // add each row returned into an array
                $CVArray[] = $CVRetrieveRow['cvID'];

            }
        

    } 
    
    array_walk($CVArray , 'intval');
    $CVids = implode(',', $CVArray);
    $messageRetrieveSql = "SELECT distinct convID FROM conversations WHERE cvID IN ($CVids)";
    $messageRetrieveSqlResult = $conn->query($messageRetrieveSql);

    $intIDArray = array();
    
    if ($messageRetrieveSqlResult->num_rows > 0) { 
            
        echo "<form action='' method='POST'style='padding-bottom:85px;top:-250px; height:1200px;
            -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'>
        <h2 class='text-center'>Interactions Inbox</h2>
        <h4 class='text-center'>The following are any ongoing conversations between any tutors whose CVs</br>
        you are referenced on, and the students who contacted them through those CVs.</br></br>
        As the reference teacher on these CVs, it is your responsibility to monitor these interactions.</br>
        If any conversation content is deemed inapropriate, you should take action.</br></br></h4>
        <table class='table' id='inbox' style='display:block;'><tr><th style='text-align:left; padding-left:30px;'>Tutor</th><th style='text-align:left;'>Student</th><th style='text-align:left;'>Subject</th><th></th></tr>";
            // output data of each row
        while($MessageRetrieveRow = $messageRetrieveSqlResult->fetch_assoc()) {
            
                $intIDRetrieveSql = "SELECT max(interactionID) FROM conversations WHERE convID ='".$MessageRetrieveRow['convID']."'";
                $intIDRetrieveSqlResult = $conn->query($intIDRetrieveSql);
                
                if ($intIDRetrieveSqlResult->num_rows > 0) { 
                
                    $intIDRetrieveSqlRow = $intIDRetrieveSqlResult->fetch_assoc();
                    $intIDArray[] = $intIDRetrieveSqlRow['max(interactionID)'];
                    
                }

        } 
        
        array_walk($intIDArray , 'intval');
        $interactionIDs = implode(',', $intIDArray);

        
        $dataRetrieveSql = "SELECT * FROM conversations WHERE interactionID IN ($interactionIDs) ORDER BY interactionID DESC";
    $dataRetrieveSqlResult = $conn->query($dataRetrieveSql);

    if ($dataRetrieveSqlResult->num_rows > 0) { 
    
            while($dataRetrieveRow = $dataRetrieveSqlResult->fetch_assoc()) {
            
                $studentImageRetrieveSql = "SELECT image FROM images WHERE userID ='".$dataRetrieveRow['studentID']."' AND usertype = 'Student'";
                $studentImageRetrieveSqlResult = $conn->query($studentImageRetrieveSql);
                $studentImageRetrieveRow = $studentImageRetrieveSqlResult->fetch_assoc();
                $imageStudent = $studentImageRetrieveRow['image'];
                
                $studentUsernameRetrieveSql = "SELECT username FROM students WHERE studentID ='".$dataRetrieveRow['studentID']."'";
                $studentUsernameRetrieveSqlResult = $conn->query($studentUsernameRetrieveSql);
                $studentUsernameRetrieveRow = $studentUsernameRetrieveSqlResult->fetch_assoc();
                
                $tutorIDRetrieveSql = "SELECT tutorID FROM CVs WHERE cvID ='".$dataRetrieveRow['cvID']."'";
                $tutorIDRetrieveSqlResult = $conn->query($tutorIDRetrieveSql);
                $tutorIDRetrieveRow = $tutorIDRetrieveSqlResult->fetch_assoc();
                
                $tutorImageRetrieveSql = "SELECT image FROM images WHERE userID ='".$tutorIDRetrieveRow['tutorID']."' AND usertype = 'Tutor'";
                $tutorImageRetrieveSqlResult = $conn->query($tutorImageRetrieveSql);
                $tutorImageRetrieveRow = $tutorImageRetrieveSqlResult->fetch_assoc();
                $imageTutor = $tutorImageRetrieveRow['image'];
                
                $tutorUsernameRetrieveSql = "SELECT username FROM tutors WHERE tutorID ='".$tutorIDRetrieveRow['tutorID']."'";
                $tutorUsernameRetrieveSqlResult = $conn->query($tutorUsernameRetrieveSql);
                $tutorUsernameRetrieveRow = $tutorUsernameRetrieveSqlResult->fetch_assoc();
                
                $subjectRetrieveSql = "SELECT subject FROM CVs WHERE cvID ='".$dataRetrieveRow['cvID']."'";
                $subjectRetrieveSqlResult = $conn->query($subjectRetrieveSql);
                $subjectRetrieveRow = $subjectRetrieveSqlResult->fetch_assoc();
                
                if ($dataRetrieveRow['sender'] === "Student"){
                    $highlight = "style='background:#BFDCE0;'";
                    $highlightAdd = "background:#BFDCE0;";
                }
                elseif ($dataRetrieveRow['sender'] === "Tutor"){
                    $highlight = "style='background:white;'";
                    $highlightAdd = "background:white;";
                }
                elseif ($dataRetrieveRow['sender'] === "Violation"){
                    $highlight = "style='background:#FFD3D3;'";
                    $highlightAdd = "background:#FFD3D3;";
                }
                
                echo "<tr><td style='text-align:left;'>";
                if (!empty($imageTutor)){
	                 echo '<img class="avatar avatar-danger img-circle" src="data:image/jpeg;base64,'.base64_encode( $imageTutor ).'"/>';
	            }
	            elseif (empty($imageTutor)){
	                 echo '<img class="avatar avatar-danger img-circle" src="headshot.jpg"/>';
	            }
                echo " " .$tutorUsernameRetrieveRow['username']. "</td><td style='text-align:left;'>";
                if (!empty($imageStudent)){
	                 echo '<img class="avatar avatar-danger img-circle" src="data:image/jpeg;base64,'.base64_encode( $imageStudent ).'"/>';
	            }
	            elseif (empty($imageStudent)){
	                 echo '<img class="avatar avatar-danger img-circle" src="headshot.jpg"/>';
	            }
                echo " " .$studentUsernameRetrieveRow['username']. "</td><td style='text-align:left;'>" . $subjectRetrieveRow['subject'] . "</td>
                <td><button name='mybutton' style='width:100%;' id='button' class='btn btn-primary btn-lg btn-block' value=".$dataRetrieveRow['convID']." type='submit'>Monitor Conversation</button></td></tr>";
            
            }
    
    }
} else {
        
    echo "<form action='' method='POST' style='padding-bottom:85px;top:-250px; height:880px;
        -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;'><h2 class='text-center'>Interactions</h2>
             <h4 class='text-center'>You do not have any ongoing interactions in your inbox at the moment.</br>This means that none of the tutors who have listed you as their CV reference</br>
             have been contacted by any students yet.</br></h4>
             <div style='width:100%;'>
                <img src='emptyInbox.png' class='text-center' style='width:450px;height:450px; display:block; margin: 0 auto;'></img>
             </div>
             <h4 class='text-center'></br>If you would like to see which CVs you are referenced on,</br><a href='manageTutors.php' style='color:#326970;'><b>You can view them here!<b></a></br></br></h4>
             <button name='TeacherHome' id='button' class='btn btn-primary btn-lg btn-block' value='Home' type='submit' style='width:30%;'>Home</button>
         </form>";
    
    
}
    
    

}
        $conn->close();
?>
            
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
</html>