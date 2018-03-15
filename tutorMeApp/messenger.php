<script>
    window.onload=function () {
     var objDiv = document.getElementById("messageContainer");
     objDiv.scrollTop = objDiv.scrollHeight;
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
                        
                        if ($_SESSION['usertype'] === "Tutor" || $_SESSION['usertype'] === "Teacher"){
                            $convRetrieveSql = "SELECT * FROM conversations where convID = '".$_SESSION['conversationToView']."'";
    					    $convRetrieveSqlResult = $conn->query($convRetrieveSql);
    					    
                        }
                        elseif ($_SESSION['usertype'] === "Student"){

                            if ($_SESSION['studentNavigatingFrom'] === "Inbox"){
                                $convRetrieveSql = "SELECT * FROM conversations where convID = '".$_SESSION['conversationToView']."'";
    					        $convRetrieveSqlResult = $conn->query($convRetrieveSql);
                            }
                            elseif ($_SESSION['studentNavigatingFrom'] === "CV"){
                                $convRetrieveSql = "SELECT * FROM conversations where cvID = '".$_SESSION['CVIDtoView']."' AND studentID = '".$_SESSION['studentID']."'";
    					        $convRetrieveSqlResult = $conn->query($convRetrieveSql);
                            }
    					    
                        }
                        

    					if ($convRetrieveSqlResult->num_rows > 0) { 
        					
        					$i = 1;
        					if ($_SESSION['usertype'] === "Student"){
        					    // output data of each row
        					    while(($convRow = $convRetrieveSqlResult->fetch_assoc()) && ($i = 1)) {
        						    $convID = $convRow['convID'];
        						    $_SESSION['CVIDtoView'] = $convRow['cvID'];
            					    $i = $i + 1;
            					
            				    }
        					}
        					elseif ($_SESSION['usertype'] === "Tutor" || $_SESSION['usertype'] === "Teacher"){

                                // output data of each row
        					    while(($convRow = $convRetrieveSqlResult->fetch_assoc()) && ($i = 1)) {
                            
        						    $convID = $_SESSION['conversationToView'];
        						    $_SESSION['CVIDtoView'] = $convRow['cvID'];
                                    $_SESSION['studentID'] = $convRow['studentID'];
            					    $i = $i + 1;
            					
            				    }
    					    
                            }
        					
            				    $interactionIDFetch = $conn->prepare('SELECT interactionID FROM conversations ORDER BY interactionID DESC LIMIT 1');
                                $interactionIDFetch->execute();
                                $interactionIDFetch->store_result();
    
                                $interactionIDFetch->bind_result($intID); 
                                $interactionIDFetch->fetch();
                                $intID = $intID + 1;

            			} else {
        					    
        					    $convIDFetch = $conn->prepare('SELECT convID FROM conversations ORDER BY convID DESC LIMIT 1');
                                $convIDFetch->execute();
                                $convIDFetch->store_result();
    
                                $convIDFetch->bind_result($convID); 
                                $convIDFetch->fetch();
                                $convID = $convID + 1;
                                
                                $interactionIDFetch = $conn->prepare('SELECT interactionID FROM conversations ORDER BY interactionID DESC LIMIT 1');
                                $interactionIDFetch->execute();
                                $interactionIDFetch->store_result();
    
                                $interactionIDFetch->bind_result($intID); 
                                $interactionIDFetch->fetch();
                                $intID = $intID + 1;

    					}
        		    
if(isset($_POST['send']))
{
    $message = $_POST['message']; 
    $date_clicked = date('D, jS F Y g:ia');
    $date_clicked = date('d-m-Y H:i');
    
    // Check input errors before inserting in database
    if(!empty($message) && empty($message_err)){
        
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
        
        // Prepare an insert statement
        $SQL = $conn->prepare("INSERT INTO conversations (interactionID, convID, cvID, studentID, dateTime, message, sender) VALUES (?, ?, ?, ?, ?, ?, ?)");
         
        if($conn){
            // Bind variables to the prepared statement as parameters
            $SQL->bind_param('sssssss', $param_intID, $param_convID, $param_cvID, $param_StudentID, $param_dateTime, $param_message, $param_sender); 
            
            
            // Set parameters
            $param_intID = $intID;
            $param_convID = $convID;
            $param_cvID = $_SESSION['CVIDtoView']; 
            $param_StudentID = $_SESSION['studentID'];
            $param_dateTime = $date_clicked;
            $param_message = $message;
            $param_sender = $_SESSION['usertype'];
            
            // Attempt to execute the prepared statement
            if($SQL->execute()){
                // Redirect to Tutors Homepage
                $message = "";
                header("location: messenger.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $SQL->close();
        
    }
}

if(isset($_POST['flag']))
{
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
    
    $interactionretrieveSql = "SELECT * FROM conversations WHERE interactionID ='".$_POST['flag'] ."'";
    $interactionretrieveSqlResult = $conn->query($interactionretrieveSql);

    if ($interactionretrieveSqlResult->num_rows > 0) {
            
            $interactionRow = $interactionretrieveSqlResult->fetch_assoc();
            $MessageViolation = "The following message (sent by the ".$interactionRow['sender']." in this conversation) has been flagged 
                                as a violation by the teacher " .$_SESSION['firstname']. " " .$_SESSION['surname']. " --- " .$interactionRow['message']." --- Please follow our guidelines when interacting with other users.
                                Further violations may result in the deactivation of your TutorLink account";
            $senderUpdate = "Violation";
            
            //DB details
            /*$dbHost     = '127.0.0.1';
            $dbUsername = 'cianmc85';
            $dbPassword = '';
            $dbName     = 'project_db';*/
            
            $dbHost     = 'eu-cdbr-west-02.cleardb.net';
            $dbUsername = 'bdff3cc89b8df5';
            $dbPassword = '25912b2f';
            $dbName     = 'heroku_6a6bf0a23aababd';
            
            //Create connection and select DB
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
            // Check connection
            if($db->connect_error){
                die("Connection failed: " . $db->connect_error);
            }
        
            //Insert image content into database
            $update = $db->query("UPDATE conversations SET message='$MessageViolation', sender='$senderUpdate' WHERE interactionID ='".$_POST['flag'] ."'");
            
            if($update){
            
            
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
        
             // Prepare an insert statement
            $SQL = $conn->prepare("INSERT INTO conversations (interactionID, convID, cvID, studentID, dateTime, message, sender) VALUES (?, ?, ?, ?, ?, ?, ?)");
         
            if($conn){
                    // Bind variables to the prepared statement as parameters
                    $SQL->bind_param('sssssss', $param_intID, $param_convID, $param_cvID, $param_StudentID, $param_dateTime, $param_message, $param_sender); 
            
            
                    // Set parameters
                    $param_intID = $intID;
                    $param_convID = $convID;
                    $param_cvID = $_SESSION['CVIDtoView']; 
                    $param_StudentID = $_SESSION['studentID'];
                    $param_dateTime = date('D, jS F Y g:ia');;
                    $param_message = "A message in the above conversation has been flagged by a teacher as having violated our guidelines on interactions with other TutorLink users. The message in question is highlighted in the above conversation.
                                    Please be careful in future!";
                    $param_sender = $senderUpdate;
            
                    // Attempt to execute the prepared statement
                    if($SQL->execute()){
                        // Redirect to Tutors Homepage
                        $message = "";
                        header("location: messenger.php");
                    } else{
                        echo "Something went wrong. Please try again later.";
                    }
                }
        
                // Close statement
                $SQL->close();
        
            }else{
                echo "AUnable to flag Message. Try again later.";
            } 
        
        
        
        
        }else{
            echo "BUnable to flag Message. Try again later." . $_POST['flag'];
        }
    
}
    
if(isset($_POST['deactivateTutor']))
{
            
            //DB details
            /*$dbHost     = '127.0.0.1';
            $dbUsername = 'cianmc85';
            $dbPassword = '';
            $dbName     = 'project_db';*/
            
            $dbHost     = 'eu-cdbr-west-02.cleardb.net';
            $dbUsername = 'bdff3cc89b8df5';
            $dbPassword = '25912b2f';
            $dbName     = 'heroku_6a6bf0a23aababd';
        
            //Create connection and select DB
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
            // Check connection
            if($db->connect_error){
                die("Connection failed: " . $db->connect_error);
            }
        
            //Insert image content into database
            $update = $db->query("UPDATE tutors SET enabled='disabled', username='User Deactivated' WHERE tutorID ='".$_POST['deactivateTutor']."'");
            
            if($update){
                $enabled = 'User Deactivated';
            
            
            
            }else{
                echo "Unable to deactivate User.";
            } 
    
}
if(isset($_POST['deactivateStudent']))
{
            
            //DB details
            /*$dbHost     = '127.0.0.1';
            $dbUsername = 'cianmc85';
            $dbPassword = '';
            $dbName     = 'project_db';*/
            
            $dbHost     = 'eu-cdbr-west-02.cleardb.net';
            $dbUsername = 'bdff3cc89b8df5';
            $dbPassword = '25912b2f';
            $dbName     = 'heroku_6a6bf0a23aababd';
            
            //Create connection and select DB
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
            // Check connection
            if($db->connect_error){
                die("Connection failed: " . $db->connect_error);
            }
        
            //Insert image content into database
            $update = $db->query("UPDATE students SET enabled='disabled', username='User Deactivated' WHERE studentID ='".$_POST['deactivateStudent']."'");
            
            if($update){
                $enabled = 'User Deactivated';
            
            
            
            }else{
                echo "Unable to deactivate User.";
            } 
    
}
if(isset($_POST['reactivateTutor']))
{
            
            //DB details
            /*$dbHost     = '127.0.0.1';
            $dbUsername = 'cianmc85';
            $dbPassword = '';
            $dbName     = 'project_db';*/
            
            $dbHost     = 'eu-cdbr-west-02.cleardb.net';
            $dbUsername = 'bdff3cc89b8df5';
            $dbPassword = '25912b2f';
            $dbName     = 'heroku_6a6bf0a23aababd';
            
            //Create connection and select DB
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
            // Check connection
            if($db->connect_error){
                die("Connection failed: " . $db->connect_error);
            }
        
            //Insert image content into database
            $update = $db->query("UPDATE tutors SET enabled='enabled', username='username".$_POST['reactivateTutor']."' WHERE tutorID ='".$_POST['reactivateTutor']."'");
            
            if($update){
                $enabled = 'User Reactivated';
            
            
            
            }else{
                echo "Unable to reactivate User.";
            } 
    
}
if(isset($_POST['reactivateStudent']))
{
            
            //DB details
            /*$dbHost     = '127.0.0.1';
            $dbUsername = 'cianmc85';
            $dbPassword = '';
            $dbName     = 'project_db';*/
            
            $dbHost     = 'eu-cdbr-west-02.cleardb.net';
            $dbUsername = 'bdff3cc89b8df5';
            $dbPassword = '25912b2f';
            $dbName     = 'heroku_6a6bf0a23aababd';
            
            //Create connection and select DB
            $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
            // Check connection
            if($db->connect_error){
                die("Connection failed: " . $db->connect_error);
            }
        
            //Insert image content into database
            $update = $db->query("UPDATE students SET enabled='enabled', username='username".$_POST['reactivateStudent']."' WHERE studentID ='".$_POST['reactivateStudent']."'");
            
            if($update){
                $enabled = 'User Reactivated';
            
            
            
            }else{
                echo "Unable to reactivate User.";
            } 
    
}
       
       if(isset($_POST['Exit'])){
           if($_SESSION['usertype'] === 'Student'){
               header("location: StudentsHome.php");
           }
           elseif($_SESSION['usertype'] === 'Tutor'){
               header("location: TutorsHome.php");
           }
           elseif($_SESSION['usertype'] === 'Teacher'){
               header("location: TeachersHome.php");
           }
       }
       
       if(isset($_POST['Inbox'])){
               header("location: tutorInbox.php");
           
       }
       
       //DB details
        /*$dbHost     = '127.0.0.1';
            $dbUsername = 'cianmc85';
            $dbPassword = '';
            $dbName     = 'project_db';*/
            
            $dbHost     = 'eu-cdbr-west-02.cleardb.net';
            $dbUsername = 'bdff3cc89b8df5';
            $dbPassword = '25912b2f';
            $dbName     = 'heroku_6a6bf0a23aababd';
        
        //Create connection and select DB
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
        // Check connection
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }
       
    if ($_SESSION['usertype'] === "Tutor"){
    
        $studentImageFetch = $db->query("SELECT image FROM images WHERE userID = '" .$_SESSION['studentID']."' AND usertype = 'Student'");
    
        if($studentImageFetch->num_rows > 0){
            $imgData = $studentImageFetch->fetch_assoc();
            $otherUserImage = $imgData['image'];
            $otherImageFound = "True";
            //Render image  
        
        }else{
            $otherImageFound = "False";
        }
        
        $studentUsernameFetch = $db->query("SELECT username FROM students WHERE studentID = '" .$_SESSION['studentID']."'");
    
        if($studentUsernameFetch->num_rows > 0){
            $studentUsernameFetchRow = $studentUsernameFetch->fetch_assoc();
            $otherUserUsername = $studentUsernameFetchRow['username'];

        }else{
            $otherUserUsername = "otherUser";
        }
        
    }
    elseif ($_SESSION['usertype'] === "Student"){
        
        $tutorIDFetch = $db->query("SELECT tutorID FROM CVs WHERE cvID = '" .$_SESSION['CVIDtoView']."'");
    
        if($tutorIDFetch->num_rows > 0){
            $tutorIDFetchRow = $tutorIDFetch->fetch_assoc();
            $FetchedTutorID = $tutorIDFetchRow['tutorID'];
        
            $tutorUsernameFetch = $db->query("SELECT username FROM tutors WHERE tutorID = '" .$FetchedTutorID."'");
            
            if($tutorUsernameFetch->num_rows > 0){
                $tutorUsernameFetchRow = $tutorUsernameFetch->fetch_assoc();
                $otherUserUsername = $tutorUsernameFetchRow['username'];
        
                $tutorImageFetch = $db->query("SELECT image FROM images WHERE userID = '" .$FetchedTutorID."' AND usertype = 'Tutor'");
            
                if($tutorImageFetch->num_rows > 0){
                    $tutorImageFetchRow = $tutorImageFetch->fetch_assoc();
                    $otherUserImage = $tutorImageFetchRow['image'];
                    $otherImageFound = "True";

                }else{
                    $otherImageFound = "False";
                }
            
            }else{
                $otherUserUsername = "otherUsername";
            }
            
        }else{
        }
        
    }
    elseif ($_SESSION['usertype'] === "Teacher"){
    
        $studentImageFetch = $db->query("SELECT image FROM images WHERE userID = '" .$_SESSION['studentID']."' AND usertype = 'Student'");
    
        if($studentImageFetch->num_rows > 0){
            $imgData = $studentImageFetch->fetch_assoc();
            $studentImage = $imgData['image'];
            $studentImageFound = "True";
            //Render image  
        
        }else{
            $studentImageFound = "False";
        }
        
        $studentUsernameFetch = $db->query("SELECT username FROM students WHERE studentID = '" .$_SESSION['studentID']."'");
    
        if($studentUsernameFetch->num_rows > 0){
            $studentUsernameFetchRow = $studentUsernameFetch->fetch_assoc();
            $studentUsername = $studentUsernameFetchRow['username'];

        }else{
            $studentUsername = "student";
        }
        
        $tutorIDFetch = $db->query("SELECT tutorID FROM CVs WHERE cvID = '" .$_SESSION['CVIDtoView']."'");
    
        if($tutorIDFetch->num_rows > 0){
            $tutorIDFetchRow = $tutorIDFetch->fetch_assoc();
            $FetchedTutorID = $tutorIDFetchRow['tutorID'];
        
            $tutorUsernameFetch = $db->query("SELECT username FROM tutors WHERE tutorID = '" .$FetchedTutorID."'");
            
            if($tutorUsernameFetch->num_rows > 0){
                $tutorUsernameFetchRow = $tutorUsernameFetch->fetch_assoc();
                $tutorUsername = $tutorUsernameFetchRow['username'];
        
                $tutorImageFetch = $db->query("SELECT image FROM images WHERE userID = '" .$FetchedTutorID."' AND usertype = 'Tutor'");
            
                if($tutorImageFetch->num_rows > 0){
                    $tutorImageFetchRow = $tutorImageFetch->fetch_assoc();
                    $tutorImage = $tutorImageFetchRow['image'];
                    $tutorImageFound = "True";

                }else{
                    $tutorImageFound = "False";
                }
            
            }else{
                $tutorUsername = "tutor";
            }
            
        }else{
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
    <title>Messenger</title>
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
	
	
	
	
	
	
	
	.wrapper{ width: 350px; padding: 20px; }
        #otherUserStyle { 
                color: white;
                font-size: 16px;
                text-align: left;
                padding-right: 20px;
                padding-left: 20px;
                padding-top: 20px;
                padding-bottom: 20px;
                width: 60%;
                float:right;
                background-color:#00899C;
                margin-right:30px;
                -webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;
        }
        #currentUserStyle { 
                color: black;
                font-size: 16px;
                padding-right: 20px;
                padding-left: 20px;
                padding-top: 20px;
                padding-bottom: 20px;
                width: 60%;
                float:left;
                background-color:#ececec;
                margin-left:30px;
                border: solid 1px #00899C;
                text-align: left;
                -webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;
        } 
        #otherUserDateStyle { 
                color: black;
                font-size: 12px;
                text-align: right;
                padding-right: 20px;
                padding-left: 20px;
                margin-bottom: -10px;
                width: 60%;
                float:right;
                margin-right:30px;
        }
        #currentUserDateStyle { 
                color: black;
                font-size: 12px;
                padding-right: 20px;
                padding-left: 20px;
                margin-bottom: -10px;
                width: 60%;
                float:left;
                margin-left:30px;
                text-align: left;
        } 
        #teacherStyle { 
                color: #960000;
                font-size: 16px;
                padding-right: 20px;
                padding-left: 20px;
                padding-top: 20px;
                padding-bottom: 20px;
                width: 95%;
                float:left;
                background-color:#FFD3D3;
                margin-left:30px;
                border: solid 1px #960000;
                text-align: center;
                -webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;
        } 
        #teacherDateStyle { 
                color: black;
                font-size: 12px;
                text-align: right;
                padding-right: 20px;
                padding-left: 20px;
                margin-bottom: -10px;
                width: 60%;
                float:right;
                margin-right:30px;
        }
        div.scroll {
                border: solid 2px #00899C;
                background-color: #BFDCE0;
                width: 80%;
                height: 500px;
                margin: 0 auto;
                float:center;
                overflow-y: scroll;
                overflow-x: hidden;
                margin-top: 20px;
                margin-bottom: 50px;
                -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;

        }
        
        #shadowing{display: none;position: fixed;top: 0%;left: 0%;width: 100%;height: 100%; background-color: #53AFBA; z-index:10;    opacity:0.5; filter: alpha(opacity=50);}
    #box {display: none;position: fixed;top: 20%;left: 20%;width: 60%;height: 60%;max-height:400px;padding: 0; margin:0;border: 1px solid #CCA;background-color: white;z-index:11; overflow: hidden;-webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 0px 40px 40px;border-radius: 40px 0px 40px 40px;}   
    #boxclose{float:right;position:absolute; top: 0; right: 0px; background-image:url(images/close.gif);background-repeat:no-repeat;    background-color:#53AFBA; color:white;border:0px solid black; width:40px;height:20px;margin-right:0px;}
    #boxcontent{text-align:center;position:absolute;top:23px;left:0;right:0;bottom:0;margin:0 0 0 0;padding: 8px;overflow: auto;width:100%;height:100%;   overflow:hidden;}
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
        <div class="parallax filter filter-color-blue" style="height:1400px;">
            <div class="section" id="login">`
            <div class="container">
            <div class="login-form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" style="padding-bottom:85px; margin-top:-50px;
                                 -webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;">
                    <p style="text-align:center; background:#960000;float:right; width:100px; margin-top:0px;position:relative;
                    -webkit-border-radius: 10px 10px 10px 10px;-moz-border-radius: 10px 10px 10px 10px;border-radius: 10px 10px 10px 10px;"><a href="#" style="font-size:11px; color:white;"onClick="document.getElementById('shadowing').style.display='block';
                      document.getElementById('box').style.display='block';"><b>TutorLink Interaction Guidelines</b></a></p>
                    
                    <?php
                    if ($_SESSION['usertype'] === 'Student' || $_SESSION['usertype'] === 'Tutor'){
                                        echo '<h2 class="text-center">Messenger</h2>';
                                        echo '<div class="avatar avatar-danger" style="height:60px; width:60px; position: relative; left:-50px;">';
												 if ($_SESSION['pictureCheck'] === "True"){
													echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['profilePic'] ).'"/>';
												 }
												 elseif ($_SESSION['pictureCheck'] === "False"){
													echo '<img class="img-circle" src="headshot.jpg"/>';
												 }
										echo '</div><div class="avatar avatar-danger" style="height:60px; width:60px; position: relative; left: 50px; top: -64px;">';
												 if ($otherImageFound === "True"){
													echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $otherUserImage ).'"/>';
												 }
												 elseif ($otherImageFound === "False"){
													echo '<img class="img-circle" src="headshot.jpg"/>';
												 }   
										echo '</div>
												<h4 class="text-center" style="position: relative; left:-50px; top: -64px;"><b>'.$_SESSION['username']. '<b></h4>
												<h4 class="text-center" style="position: relative; left: 50px; top: -102px;"><b>'.$otherUserUsername. '<b></h4>';
	                                
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
                        
                        
					
					$previousMessagesSql = "SELECT * FROM conversations where convID = '".$convID."'";
    				$previousMessagesSqlResult = $conn->query($previousMessagesSql);    
					if ($previousMessagesSqlResult->num_rows > 0) { 
        					    
        					    echo "<div id='messageContainer' class='scroll' style='margin-top:-90px;'>";
        					    // output data of each row
        					    while($messageRow = $previousMessagesSqlResult->fetch_assoc()) {
                                    
                                    if ($messageRow['sender'] === $_SESSION['usertype']){
                                        $userStyle = "currentUserStyle";
                                        $userDateStyle = "currentUserDateStyle";
                                    }
                                    elseif ($messageRow['sender'] === 'Violation') {
                                        $userStyle = "teacherStyle";
                                        $userDateStyle = "teacherDateStyle";
                                    }
                                    else {
                                        $userStyle = "otherUserStyle";
                                        $userDateStyle = "otherUserDateStyle";
                                    }
                                    
                                    
	                                
        						    echo "<p id=".$userStyle."><b>".$messageRow['sender']. ": ".$messageRow['message']."<b><p><br> ";
            					    echo "<span id=".$userDateStyle.">".$messageRow['dateTime']."</span>";
            					
            				    }
            				    echo "</div>";
        		    }
                    }
                    elseif ($_SESSION['usertype'] === 'Teacher'){
                        
                                        echo '<h2 class="text-center">Conversation Monitor</h2>';
                                        echo '<h4 class="text-center">It is your responsibility as the reference teacher for the conversation below
                                                to monitor the conversation</br> for any messages which you deem to be in violation of our guidelines. Please flag any messages below which you believe</br> violate our guidelines, in order provide a warning to the conversation participants.</br></br>
                                                If further violations are committed by a user, you may choose to deactivate the users account. However, once deactivated, the user will no longer</br>
                                                 be able to access their account, so please ensure their previous violations are not simply a misunderstanding before deactivating their account!</br>
                                                 <b>Note: </b>In order to reactivate their account, a deactivated user should contact you outside of the system to discuss whether that should be allowed.</br></br>
                                                <b>Conversation Participants:<b></br></h4>';
                                        echo '<div class="avatar avatar-danger" style="height:60px; width:60px; position: relative; left:-70px;">';
												 if ($tutorImageFound === "True"){
													echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $tutorImage ).'"/>';
												 }
												 elseif ($tutorImageFound === "False"){
													echo '<img class="img-circle" src="headshot.jpg"/>';
												 }
										echo '</div><div class="avatar avatar-danger" style="height:60px; width:60px; position: relative; left: 70px; top: -64px;">';
												 if ($studentImageFound === "True"){
													echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $studentImage ).'"/>';
												 }
												 elseif ($studentImageFound === "False"){
													echo '<img class="img-circle" src="headshot.jpg"/>';
												 }   
										echo '</div>
												<h4 class="text-center" style="position: relative; left:-70px; top: -64px;"><b>Tutor:</br>'.$tutorUsername. '<b></h4>
												<h4 class="text-center" style="position: relative; left: 70px; top: -130px;"><b>Student:</br>'.$studentUsername. '<b></h4>';
	                                    echo "<div class='form-group' style='height:auto; margin: 0 auto; margin-top:-140px; padding: 10px; position: relative; width:25%; text-align:center;'>
                                                <button name='deactivateTutor' id='button' class='btn btn-primary btn-lg btn-block' value=".$FetchedTutorID." type='submit' style='left:-5px;width:49%; float: left; position: relative; font-size:11px; background:#960000; padding:2; text-align:center;'>Deactivate Tutor</button>
                                                <button name='deactivateStudent' id='button' class='btn btn-primary btn-lg btn-block' value=".$_SESSION['studentID']." type='submit' style='left:5px;width:49%; float: right; background:#008b9c; position: relative; margin-top:0px; padding:2; font-size:11px; background:#960000;'>Deactivate Student</button>
                                                </br></br></br></br></br></br></br></br>
                                              </div>";
                                        echo "<div class='form-group' style='height:auto; margin: 0 auto; margin-top:-140px; padding: 10px; position: relative; width:25%; text-align:center;'>
                                                <button name='reactivateTutor' id='button' class='btn btn-primary btn-lg btn-block' value=".$FetchedTutorID." type='submit' style='left:-5px;width:49%; float: left; position: relative; font-size:11px; margin-top:-15px;background:#4D8427; padding:2; text-align:center;'>Reactivate Tutor</button>
                                                <button name='reactivateStudent' id='button' class='btn btn-primary btn-lg btn-block' value=".$_SESSION['studentID']." type='submit' style='left:5px;width:49%; float: right; position: relative; margin-top:-15px; padding:2; font-size:11px; background:#4D8427;'>Reactivate Student</button>
                                                </br></br></br></br>                                                </br></br></br></br>

                                              </div>";
                                        
                                        
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
                        
                        
					
					$previousMessagesSql = "SELECT * FROM conversations where convID = '".$convID."'";
    				$previousMessagesSqlResult = $conn->query($previousMessagesSql);    
					if ($previousMessagesSqlResult->num_rows > 0) { 
        					    
        					    echo "<div id='messageContainer' class='scroll' style='margin-top:-90px;'>";
        					    // output data of each row
        					    while($messageRow = $previousMessagesSqlResult->fetch_assoc()) {
                                    
                                    if ($messageRow['sender'] === 'Tutor'){
                                        $userStyle = "currentUserStyle";
                                        $userDateStyle = "currentUserDateStyle";
                                    }
                                    elseif ($messageRow['sender'] === 'Student') {
                                        $userStyle = "otherUserStyle";
                                        $userDateStyle = "otherUserDateStyle";
                                    }
                                    elseif ($messageRow['sender'] === 'Violation') {
                                        $userStyle = "teacherStyle";
                                        $userDateStyle = "teacherDateStyle";
                                    }
	                                
        						    echo "<p id=".$userStyle."><b>".$messageRow['sender']. ": ".$messageRow['message']."<b>";
        						    
        						    if ($messageRow['sender'] === 'Tutor'){
        						        echo "<button name='flag' id='button' class='btn btn-primary btn-lg btn-block' value='".$messageRow['interactionID']."' type='submit' 
        						        style='width:35%; height:10%;float: right; position: relative; margin-bottom:0px; font-size:14px; background:#960000; opacity:1;'>Flag Message</button>";
        						    }
        						    elseif ($messageRow['sender'] === 'Student'){
        						        echo "<button name='flag' id='button' class='btn btn-primary btn-lg btn-block' value='".$messageRow['interactionID']."' type='submit' 
        						        style='width:35%; height:10%;float: right; position: relative; margin-bottom:0px; font-size:14px; background:#960000; opacity:1;'>Flag Message</button>";
        						    }
        						    echo "<p><br> ";
            					    echo "<span id=".$userDateStyle.">".$messageRow['dateTime']."</span>";
            					
            				    }
            				    echo "</div>";
            				    
        		    }
                    }
        		    ?>
        		    <?php
        		        
        		        if ($_SESSION['usertype'] === 'Student' || $_SESSION['usertype'] === 'Tutor'){
        		            
        		            echo '<div class="form-group" style="margin: 0 auto;width:80%; height:80px; float: center; position: relative;">
        	                        <textarea style="overflow:auto;resize:none;width:65%; height:100%; float: left; position: relative;" name="message" class="form-control" placeholder="Message"></textarea>
        	                        <span class="help-block"><?php echo $message_err; ?></span>
                                    <input name="send" type="submit" class="btn btn-primary btn-lg btn-block" value="Send" style="width:30%; height:100%;float: right; position: relative;">
                                </div>';
        		        
        		        }
        		        
                    
                    ?>
                    <div class="form-group" style="height:auto; margin: 0 auto; margin-top:50px; padding: 10px; position: relative; width:50%;">
                        <input name="Inbox" type="submit" class="btn btn-primary btn-lg btn-block" value="Inbox" style="width:40%; float: left; position: relative;">
                        <input name="Exit" type="submit" class="btn btn-primary btn-lg btn-block" value="Exit" style="width:40%; float: right; background:#008b9c; position: relative; margin-top:0px;">
                    </div>
                    <div id="shadowing"></div>
                    <div id="box">
                       <span id="boxclose" onClick="document.getElementById('box').style.display='none';
                           document.getElementById('shadowing').style.display='none'">close </span>
                         <div id="boxcontent">    
                            <b>The following are some basic guidelines for interacting with other users via TutorLink.<br>
                            We aim to create a safe environment where tutors and students</br> can interact in a responsible manner with respect for other users.</b><br><br>
                            1 -- Use appropriate language when chatting with other users.<br>
                            2 -- This messenger feature is only for the pupose of organising grinds between<br> tutors and students. It should not be used as a form of social contact.<br>
                            3 -- Any use of inappropriate language of malicious, sexual, or immature context<br> will result in a violation and/or deactivation of your account.<br>
                            4 -- Remember that each conversation has three participants. Each cnversation is<br> being monitored by a teacher who has the power to warn an deactivate users accounts.<br>
                            
                         </div>
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
