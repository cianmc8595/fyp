<?php
// Initialize the session
session_start();

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
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate subject
    if(empty(trim($_POST[Subject]))){
        $subject_err = "Please enter a subject.";     
    } else{
        $subject = trim($_POST[Subject]);
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
        $about_err = "Please enter a about.";     
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
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New CV</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>New CV Registration:</h2>
        <p>Please complete your new CV.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>Tutor ID:<sup>*</sup></label>
                <input type="text" name="tutorID"class="form-control" value="<?php echo $_SESSION['tutorID']; ?>" disabled>
                <span class="help-block"><?php echo $tutorID_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                <label>Subject:<sup>*</sup></label>
                <select type="text" class="form-control" name="Subject">
                    <option selected value="">Choose a subject</option>
                    <option value="Maths">Maths</option>
                    <option value="English ">English</option>
                    <option value="Irish">Irish</option>
                </select>
                <span class="help-block"><?php echo $subject_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($referenceTeacher_err)) ? 'has-error' : ''; ?>">
                <label>Reference Teacher:<sup>*</sup></label>
                <input type="text" name="referenceTeacher" class="form-control" value="<?php echo $referenceTeacher; ?>">
                <span class="help-block"><?php echo $referenceTeacher_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($lcGrade_err)) ? 'has-error' : ''; ?>">
                <label>LC Grade achieved:<sup>*</sup></label>
                <select type="text" class="form-control" name="Grade">
                    <option selected value="">Select your grade</option>
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
                <label>Year LC completed:<sup>*</sup></label>
                <input type="text" name="lcYear"class="form-control" value="<?php echo $lcYear; ?>">
                <span class="help-block"><?php echo $lcYear_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($about_err)) ? 'has-error' : ''; ?>">
                <label>About:<sup>*</sup></label>
                <input type="text" name="about"class="form-control" value="<?php echo $about; ?>">
                <span class="help-block"><?php echo $about_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($verification_err)) ? 'has-error' : ''; ?>">
                <label>Verified CV?<sup>*</sup></label>
                <input type="text" name="verification"class="form-control" value="Unverified" disabled>
                <span class="help-block"><?php echo $verification_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>