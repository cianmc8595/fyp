<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}/* END */
?>
<?php 

$host = "127.0.0.1";
$user = "cianmc85"; 
$pass = "";
$db = "project_db";
$port = 3306;

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);
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
            else {
                echo "0 Teacher results";
            }
            
        }
        else {
            echo "0 Tutor results";
        }
}
else {
    echo "0 CV results";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $tutorFirstname. " " . $tutorSurname; ?> - Curriculum Vitae</title>

<meta name="viewport" content="width=device-width"/>
<meta name="description" content="The Curriculum Vitae of Joe Bloggs."/>
<meta charset="UTF-8"> 

<link type="text/css" rel="stylesheet" href="styles.css">

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
        
    </style>
</head>
<body id="top">
<div id="cv" class="instaFade">
	<div class="mainDetails">
		<div id="headshot" class="quickFade">
			<img src="headshot.jpg" alt="Alan Smith" />
		</div>
		
		<div id="name">
			<h1 class="quickFade delayTwo"><?php echo $tutorFirstname. " " . $tutorSurname; ?></h1>
			<h2 class="quickFade delayThree"><?php echo "Subject - " . $subject; ?></h2>
		</div>
		
		<div id="contactDetails" class="quickFade delayFour">
			<ul>
				<li>Email: <a href="mailto:joe@bloggs.com" target="_blank"><?php echo $tutorEmail;?></a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div id="mainArea" class="quickFade delayFive">
		<section>
			<article>
				<div class="sectionTitle">
					<h1>Tutor Profile</h1>
				</div>
				
				<div class="sectionContent">
				    <h2>Name</h2>
					<p><?php echo $tutorFirstname. " " . $tutorSurname; ?></p>
					<h2>Subject</h2>
					<p><?php echo $subject; ?></p>
					<h2>School Attended</h2>
					<p><?php echo $pastSchool; ?></p>
					<h2>Year Leaving Certificate Completed</h2>
					<p><?php echo $lcYear; ?></p>
					<h2>LC Grade achieved in tutoring subject</h2>
					<p><?php echo $lcGrade; ?></p>
					<h2>LC Teacher in tutoring subject</h2>
					<p><?php echo $teacherFirstname. " " . $teacherSurname; ?></p>
					<h2>About</h2>
					<p><?php echo $about; ?></p>
					<h2>Verification Status</h2>
					<p><?php echo $verification; ?></p>
				</div>
			</article>
			<div class="clear"></div>
		</section>
		<section>
			<article>
				<div class="sectionTitle">
					<h1>Teacher Information</h1>
				</div>
				
				<div class="sectionContent">
				    <h2>Name</h2>
					<p><?php echo $teacherFirstname. " " . $teacherSurname; ?></p>
					<h2>Current Position</h2>
					<p><?php echo "Current ".$subject." teacher at ".$pastSchool; ?></p>
					<h2>Email</h2>
					<p><?php echo $teacherEmail; ?></p>
				</div>
			</article>
			<div class="clear"></div>
		</section>
		<section>
			<article>
				
				<div class="sectionTitle">
					<h1>Student Reviews</h1>
				</div>
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
    
    				
    					$reviewSql = "SELECT * FROM reviews WHERE tutorID = '".$tutorID."'";
    					$reviewResult = $conn->query($reviewSql);

    					if ($reviewResult->num_rows > 0) { 
        					
        					$count = 1;
        					// output data of each row
        					while($reviewRow = $reviewResult->fetch_assoc()) {
            
        						
            					$reviewID = $reviewRow['reviewID'];
            					$review = $reviewRow['review'];
            					$rating = $reviewRow['rating'];
            					
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
            						echo "<div class='reviewContent' style='border-top: none'><h2>Review by:</h2>
										<p>studentUsername</p>
								    	<h2>Review</h2>
								    	<p>" .$review. "</p>
								    	<h2>Rating</h2>
								    	<img style='padding-top:6px; padding-bottom:10px; width:200px; height:40px;' src=" .$rating. " alt='Mountain View'></div>";
            					}
            					else {
            						echo "<div class='reviewContent'><h2>Review by:</h2>
										<p>studentUsername</p>
								    	<h2>Review</h2>
								    	<p>" .$review. "</p>
								    	<h2>Rating</h2>
								    	<img style='padding-top:6px; padding-bottom:10px; width:200px; height:40px;' src=" .$rating. " alt='Mountain View'></div>";
            					}
            					
            					$count = $count + 1;
                			}
                			$count = 1;
            			} else {
        					echo "0 Review Results";
    					}
					
    					$conn->close();
					?>
			</article>
			<div class="clear"></div>
		</section>
		<p><a href="messenger.php" class="btn btn-danger">Contact this tutor</a></p>
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