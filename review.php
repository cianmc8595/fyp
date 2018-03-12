<?php
// Initialize the session
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
<body>
    <div class="wrapper">
        <h2>Rate and Review</h2>
        <p>To review this tutor, type your review, select a rating and below and click submit.</p>
        <form id="ratingsForm" method="post">
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                <label>Review:<sup>*</sup></label>
                <input type="text" name="review"class="form-control" value="">
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <h1>Star Rating</h1>
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
            <div class="form-group">
                <input name="sendReview" type="submit" class="btn btn-primary" value="Submit Review">
            </div>
        </form>
    </div>    
</body>
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

if(isset($_POST['sendReview']))
{
    $review = $_POST['review']; 
    
    echo "Review " . $review;
    
    $radioVal = $_POST["star"];

    // Check input errors before inserting in database
    if(empty($review)){
        
        echo "Must enter a review to send";
        
    }
    else {
        
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

        $CVIDRetrieveSql = "SELECT cvID FROM conversations where convID = '".$_SESSION['conversationToView']."'";
    	$CVIDRetrieveSqlResult = $conn->query($CVIDRetrieveSql);
        
        $cvRow = $CVIDRetrieveSqlResult->fetch_assoc();
                                    
        $cvid = $cvRow['cvID'];
        
        $tutorIDRetrieveSql = "SELECT tutorID FROM CVs where cvID = '".$cvid."'";
    	$tutorIDRetrieveSqlResult = $conn->query($tutorIDRetrieveSql);
        
        $tutorRow = $tutorIDRetrieveSqlResult->fetch_assoc();
                                    
        $tutorID = $tutorRow['tutorID'];
        
        $reviewIDRetrieveSql = "SELECT reviewID FROM reviews ORDER BY reviewID DESC LIMIT 1";
    	$reviewIDRetrieveSqlResult = $conn->query($reviewIDRetrieveSql);
        
        $reviewRow = $reviewIDRetrieveSqlResult->fetch_assoc();
        
        $reviewID = $reviewRow['reviewID'];
        $reviewID = $reviewID + 1;
        
        // Prepare an insert statement
        $SQL = $conn->prepare("INSERT INTO reviews (reviewID, tutorID, review, rating) VALUES (?, ?, ?, ?)");
         
        if($conn){
            // Bind variables to the prepared statement as parameters
            $SQL->bind_param('ssss', $param_reviewID, $param_tutorID, $param_review, $param_rating); 
            
            
            // Set parameters
            $param_reviewID = $reviewID;
            $param_tutorID = $tutorID;
            $param_review = $review; 
            $param_rating = $radioVal;
            
            
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
?>
</html>