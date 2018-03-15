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

?>
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

$_SESSION['studentNavigatingFrom'] = "CV";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM CVs WHERE cvID = '".$_SESSION['CVIDtoView']."'";
$result = $conn->query($sql);

if ($result->num_rows === 1) { 
    
    $row = $result->fetch_assoc();
            
    $tutorID = $row['tutorID'];
    $subject = $row['subject'];
    $teacherID = $row['referenceTeacher'];
    $lcGrade = $row['lcGrade'];
    $lcYear = $row['lcYear'];
    $about = $row['about'];
    $verification = $row['verification'];
    
    $relatedTutorSearch = "SELECT * FROM tutors where tutorID = '".$tutorID."'";
    $relatedTutorSearchResult = $conn->query($relatedTutorSearch);
            
        if ($relatedTutorSearchResult->num_rows === 1) {
            
            $rowTutor = $relatedTutorSearchResult->fetch_assoc();
            
            $tutorEmail = $rowTutor['email'];
            $tutorFirstname = $rowTutor['firstname'];
            $tutorSurname = $rowTutor['surname'];
            $pastSchool = $rowTutor['pastSchool'];
                
            $relatedTeacherSearch = "SELECT * FROM teachers where teacherID = '".$teacherID."'";
            $relatedTeacherSearchResult = $conn->query($relatedTeacherSearch);
            
            if ($relatedTeacherSearchResult->num_rows === 1){
                
                $rowTeacher = $relatedTeacherSearchResult->fetch_assoc();
                
                $teacherEmail = $rowTeacher['email'];
                $teacherFirstname = $rowTeacher['firstname'];
                $teacherSurname = $rowTeacher['surname'];

            }
            
            
        }
        
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

    $result = $db->query("SELECT image FROM images WHERE userID = '" .$tutorID."' AND usertype = 'Tutor'");
    
    if($result->num_rows > 0){
        $imgData = $result->fetch_assoc();
        $tutorPic = $imgData['image'];
        $_SESSION['tutorpictureCheck'] = "True";
        //Render image
        
    }else{
        $_SESSION['tutorpictureCheck'] = "False";
    }

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $tutorFirstname. " " . $tutorSurname; ?> - CV</title>

<meta name="viewport" content="width=device-width"/>
<meta name="description" content="The Curriculum Vitae of Joe Bloggs."/>
<meta charset="UTF-8"> 
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">
<link type="text/css" rel="stylesheet" href="assets/css/styles.css">

<link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700|Lato:400,300' rel='stylesheet' type='text/css'>
<!--elements from CV template downloaded from http://www.thomashardy.me.uk/free-responsive-html-css3-cv-template
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<style type="text/css">
        
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
q:before {
	font-size:1em;
	content: open-quote;
	color:#00899C;
}
 
q:after {
	font-size:1em;
    content: close-quote;
    color:#00899C;
}
        
    </style>
</head>
<body id="top">
<div id="cv" class="instaFade" style="-webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;">
	<div class="mainDetails" style="-webkit-border-radius: 40px 40px 0px 0px;-moz-border-radius: 40px 40px 0px 0px;border-radius: 40px 40px 0px 0px;">
	<div style="width:100%; height:100px; margin:0 auto; border:10px white;">
		<p><a href="tutorSearch.php" style="font-family: Helvetica;text-decoration:none;font-weight:bold;background:#00899C;color:white;font-size:16px; padding:20px; float:left;" class="btn btn-danger">Back to Search</a></p>
		<p><a href="messenger.php" style="font-family:Helvetica;text-decoration:none;font-weight:bold;background:#00899C;color:white;font-size:16px; padding:20px; float:right;" class="btn btn-danger">Contact this tutor</a></p>
	</div>
		<div id="headshot" class="quickFade" style="margin-top:-80px;">
			<?php
	                                if ($_SESSION['tutorpictureCheck'] === "True"){
	                                    echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $tutorPic ).'"/>';
	                                }
	                                elseif ($_SESSION['tutorpictureCheck'] === "False"){
	                                    echo '<img class="img-circle" src="headshot.jpg"/>';
	                                }
	                            ?>
		</div>
		
		<div id="name">
			<h1  style="font-family:Helvetica; font-weight:bold;"class="quickFade delayTwo"><?php echo $tutorFirstname. " " . $tutorSurname; ?></h1>
			<h2  style="font-family:Helvetica; font-weight:bold;"class="quickFade delayThree"><?php echo "Subject - " . $subject; ?></h2>
		</div>
		
		<!--<div id="contactDetails" class="quickFade delayFour">
			<ul>
				<li>Email: <a href="mailto:joe@bloggs.com" ><?php echo $tutorEmail;?></a></li>
			</ul>
		</div>-->
		<div class="clear"></div>
	</div>
	<div id="mainArea" class="quickFade delayFive">
		<section>
			<article>
				<div class="sectionTitle">
					<h1 style="font-family:Cambo; font-weight:bold;">Tutor Profile</h1>
				</div>
				
				<div class="sectionContent">
					<div style="width:40%; float:left;">
				    	<h2 style="font-family:Cambo; font-weight:bold;">Name</h2>
						<p><?php echo $tutorFirstname. " " . $tutorSurname; ?></p>
						<h2 style="font-family:Cambo; font-weight:bold;">Subject</h2>
						<p><?php echo $subject; ?></p>
						<h2 style="font-family:Cambo; font-weight:bold;">School Attended</h2>
						<p><?php echo $pastSchool; ?></p>
						<h2 style="font-family:Cambo; font-weight:bold;">Completed LC</h2>
						<p><?php echo $lcYear; ?></p>
					</div>
					<div style="width:40%; float:right;padding-right:20px;">
						<h2 style="font-family:Cambo; font-weight:bold;">LC Grade achieved in <?php echo $subject; ?></h2>
						<p><?php echo $lcGrade; ?></p>
						<h2 style="font-family:Cambo; font-weight:bold;"><?php echo $subject; ?> Teacher for LC</h2>
						<p><?php echo $teacherFirstname. " " . $teacherSurname; ?></p>
						<h2 style="font-family:Cambo; font-weight:bold;">Verification Status</h2>
						<p><?php echo $verification; ?> - Tutors are verified by the teacher referenced on the CV</p>
					</div>
					<div style="width:90%; float:left;padding-right:20px;">
						<h2 style="font-family:Cambo; font-weight:bold;">About</h2>
						<p><?php echo $about; ?></p>
					</div>
				</div>
			</article>
			<div class="clear"></div>
		</section>
		<section>
			<article>
				<div class="sectionTitle">
					<h1 style="font-family:Cambo; font-weight:bold;">Reference Teacher</h1>
				</div>
				
				<div class="sectionContent">
					<?php
					
					if (!empty($teacherFirstname)){
						echo '<h2 style="font-family:Cambo; font-weight:bold;">Name</h2>
					<p>' .$teacherFirstname. '' . $teacherSurname. '</p>
					<h2 style="font-family:Cambo; font-weight:bold;">Current Position</h2>
					<p>Current '.$subject.' teacher at '.$pastSchool. '</p>
					<h2 style="font-family:Cambo; font-weight:bold;">Email</h2>
					<p>' . $teacherEmail . '</p>';
					}
					else{
                				echo "<h2 style='font-family:Cambo; border:2px solid #00899C; background:#00899C; color:white; text-align:center; margin-left:170px; margin-bottom: 20px;margin-top:0px; font-weight:bold; width:270px;'>No teacher has been referenced on this CV.</h2>";
					}
					
					?>
				</div>
			</article>
			<div class="clear"></div>
		</section>
		<section style="padding-bottom:100px;">
			<article>
				
				<div class="sectionTitle">
					<h1 style="font-family:Cambo; font-weight:bold;">Student Reviews<br><br><br><br><br><br><br><br></h1>
				</div>
				<h2 style="color:#00899C; font-size:1.2em;text-align:center;font-family:Cambo; font-weight:bold;">The following reviews and ratings have been submitted by 
						students who have interacted with this tutor. Each review has been approved by the reference teacher on this CV.<br><br>
						Tutors may be registered to tutor in several subjects. We have included
						all of the reviews left about this tutor below, ordered by subject with any <?php echo $subject; ?> reviews first.</h2>
					<div class='sectionContent' style='height:650px;overflow: auto;'>
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
    
    					$count = 1;
    					$reviewSql = "SELECT * FROM reviews WHERE tutorID = '".$tutorID."' AND subject = '".$subject."' AND verification = 'Approved'";
    					$reviewResult = $conn->query($reviewSql);

    					if ($reviewResult->num_rows > 0) { 
        					
        					// output data of each row
        					while($reviewRow = $reviewResult->fetch_assoc()) {
            
            					$reviewID = $reviewRow['reviewID'];
            					$review = $reviewRow['review'];
            					$rating = $reviewRow['rating'];
            					$student = $reviewRow['studentUsername'];
            					$reviewsubject = $reviewRow['subject'];
            					
            					if ($rating === "5"){
            						$rating = "star5.PNG";
            					}
            					elseif ($rating === "4") {
            						$rating = "star4.PNG";
            					}
            					elseif ($rating === "3") {
            						$rating = "star3.PNG";
            					}
            					elseif ($rating === "2") {
            						$rating = "star2.PNG";
            					}
            					elseif ($rating === "1") {
            						$rating = "star1.PNG";
            					}
            					
            					if ($count == 1){
            						echo "<div class='reviewContent' style='border-top: none'>
								    	<p><span style='color:#00899C;' >" .$student. " - </span><q>" .$review. "</q></p>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px;'>Rating</h2>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px; float:right; margin-right:280px; margin-top:-25px;'>Subject</h2>
								    	<img style='padding-top:6px; padding-bottom:10px; width:200px; height:40px; margin-top:25px;' src=" .$rating. " alt='Mountain View'>
            							<p style=' width:40px; float:right; margin-right:280px; margin-top:34px;'>" .$reviewsubject. "</p></div>";
            							$count = $count + 1;
            							$reviewsAdded = "true";
            						
            					}
            					else {
            						echo "<div class='reviewContent'>
								    	<p><span style='color:#00899C;' >" .$student. " - </span><q>" .$review. "</q></p>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px;'>Rating</h2>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px; float:right; margin-right:280px; margin-top:-25px;'>Subject</h2>
								    	<img style='padding-top:26px; padding-bottom:10px; width:200px; height:40px;' src=" .$rating. " alt='Mountain View'>
            							<p style=' width:40px; float:right; margin-right:280px; margin-top:30px;'>" .$reviewsubject. "</p></div>";
            							$reviewsAdded = "true";
            					}
        					}
            					
            				
            			}
            			else{
            				$reviewsAdded = "false";
            			}
            			
            			$review2Sql = "SELECT * FROM reviews WHERE tutorID = '".$tutorID."' AND subject <> '".$subject."'  AND verification = 'Approved' ORDER BY subject";
    					$review2Result = $conn->query($review2Sql);

    					if ($review2Result->num_rows > 0) { 
        					
        					// output data of each row
        					while($review2Row = $review2Result->fetch_assoc()) {
            
            					$reviewID = $review2Row['reviewID'];
            					$review = $review2Row['review'];
            					$rating = $review2Row['rating'];
            					$student = $review2Row['studentUsername'];
            					$reviewsubject = $review2Row['subject'];
            					
            					if ($rating === "5"){
            						$rating = "star5.PNG";
            					}
            					elseif ($rating === "4") {
            						$rating = "star4.PNG";
            					}
            					elseif ($rating === "3") {
            						$rating = "star3.PNG";
            					}
            					elseif ($rating === "2") {
            						$rating = "star2.PNG";
            					}
            					elseif ($rating === "1") {
            						$rating = "star1.PNG";
            					}
            					
            					
            					if ($count == 1){
            						echo "<div class='reviewContent' style='border-top: none'>
								    	<p><span style='color:#00899C;' >" .$student. " - </span><q>" .$review. "</q></p>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px;'>Rating</h2>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px; float:right; margin-right:280px; margin-top:-25px;'>Subject</h2>
								    	<img style='padding-top:6px; padding-bottom:10px; width:200px; height:40px; margin-top:25px;' src=" .$rating. " alt='Mountain View'>
            							<p style=' width:40px; float:right; margin-right:280px; margin-top:34px;'>" .$reviewsubject. "</p></div>";
            							$count = $count + 1;
            							
            							$reviewsAdded = "true";
            					}
            					else {
            						echo "<div class='reviewContent'>
								    	<p><span style='color:#00899C;' >" .$student. " - </span><q>" .$review. "</q></p>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px;'>Rating</h2>
								    	<h2 style='font-family:Cambo; font-weight:bold; width:40px; float:right; margin-right:280px; margin-top:-25px;'>Subject</h2>
								    	<img style='padding-top:26px; padding-bottom:10px; width:200px; height:40px;' src=" .$rating. " alt='Mountain View'>
            							<p style=' width:40px; float:right; margin-right:280px; margin-top:30px;'>" .$reviewsubject. "</p></div>";
            							$reviewsAdded = "true";
            					}
            					
        					}
                			}
                			
                			if ($reviewsAdded === "false"){
                			
                				echo "<h2 style='font-family:Cambo; border:2px solid #00899C; background:#00899C; color:white; text-align:center; margin-left:170px; margin-top:300px; font-weight:bold; width:270px;'>No reviews have been left about this tutor yet.</h2>";
                			}
    					$conn->close();
					?>
				</div>	
			</article>
			<div class="clear"></div>
			<p><a href="tutorSearch.php" style="font-family:Helvetica;text-decoration:none;font-weight:bold;background:#00899C;color:white;font-size:16px; padding:20px; margin-top:20px;float:left;" class="btn btn-danger">Back to Search</a></p>
			<p><a href="messenger.php" style="font-family:Helvetica;text-decoration:none;font-weight:bold;background:#00899C;color:white;font-size:16px; padding:20px; float:right;" class="btn btn-danger">Contact this tutor</a></p>
		
		</section>
		
	</div>
</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3753241-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>