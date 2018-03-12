<script>function copyValue() {
    var dropboxvalue = document.getElementById('mydropbox').value;
    document.getElementById('test').value = dropboxvalue;
}</script>
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
        <h2>Manage Tutor's CVs under your name:</h2>
        <p>The following are the CVs of tutors who indicated that you were their past teacher. Please select a tutor from the list to manage their profile, then click submit.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($lcGrade_err)) ? 'has-error' : ''; ?>">
                <label>CVs you are referenced on:<sup>*</sup></label>
                <?php
// Initialize the session
session_start();



// With help from http://jsfiddle.net/My7D5/ & https://www.sitepoint.com/community/t/populate-dropdown-menu-from-mysql-database/6481/7
  $mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') 
            or die ('Cannot connect to db');

    $result = mysqli_query($mysqli, "SELECT * FROM CVs where referenceTeacher = '".$_SESSION['teacherID']."'");
    echo "<html>";
    echo "<body>";
    echo "<select class='btn btn-primary dropdown-toggle' name='mydropbox' id='mydropbox' onchange='copyValue()'>";

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
                  echo '<option value="'.$cvID.'">Student: '.$fname.' '.$sname.'  - -  Subject: '.$subject.'  - -  CV Status: '.$verification.'</option>';

}

    echo "</select>";
    echo "</body>";
    echo "</html>";

?>
                <span class="help-block"><?php echo $lcGrade_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        
        <?php
            if($_POST){
            $selected_CVID = $_POST['mydropbox'];
            }


            $mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db') 
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
            ?>
            
    </div>
    <div class="wrapper">
        <h2>Manage CV verification status</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>CV ID:<sup>*</sup></label>
                <input type="text" name="cvID"class="form-control" value="<?php echo $retrieved_CVID; ?>" readonly="readonly">
            </div>
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>Tutor ID:<sup>*</sup></label>
                <input type="text" name="tutorID"class="form-control" value="<?php echo $retrieved_TutorID; ?>" disabled>
            </div>   
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>Subject:<sup>*</sup></label>
                <input type="text" name="subject"class="form-control" value="<?php echo $retrieved_subject; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>Reference Teacher:<sup>*</sup></label>
                <input type="text" name="referenceTeacher"class="form-control" value="<?php echo $retrieved_ReferenceTeacher; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>LC Grade:<sup>*</sup></label>
                <input type="text" name="lcGrade"class="form-control" value="<?php echo $retrieved_lcGrade; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>LC Year:<sup>*</sup></label>
                <input type="text" name="lcYear"class="form-control" value="<?php echo $retrieved_lcYear; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($tutorID_err)) ? 'has-error' : ''; ?>">
                <label>About:<sup>*</sup></label>
                <input type="text" name="about"class="form-control" value="<?php echo $retrieved_about; ?>" disabled>
            </div> 
            <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                <label>Verified CV?<sup>*</sup></label>
                <select type="text" class="form-control" name="Verification">
                    <option selected value="<?php echo $retrieved_Verification; ?>"><?php echo $retrieved_Verification; ?></option>
                    <option value="Unverified">Unverified</option>
                    <option value="Verified ">Verified</option>
                </select>
                <span class="help-block"><?php echo $subject_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" name="saveChanges">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>
</body>

<?php

$link = mysqli_connect("127.0.0.1", "cianmc85", "", "project_db");

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
}

?>
</html>