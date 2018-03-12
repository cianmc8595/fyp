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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; background-color:#d5f4e6;}
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>. You are a <b><?php echo $_SESSION['usertype']; ?></b>. Welcome to the site.</h1>
        <h1>Select the subject you need help with to find tutors that suit your needs.</h1>
    </div>
    <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input name="subjectChoice" class="btn btn-danger" type="submit" value="Maths"></input>
        <input name="subjectChoice" class="btn btn-danger" type="submit" value="English"></input>
        <input name="subjectChoice" class="btn btn-danger" type="submit" value="Irish"></input>
    </form>
    
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

if (isset($_POST['subjectChoice'])) {
    
    $choice = $_POST['subjectChoice'];

    $sql = "SELECT * FROM CVs WHERE subject = '".$choice."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
        echo "<form action='' method='POST'><table class='table'><tr><th>cvID </th><th> teacherID</th><th>Select tutor</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            
        
            $tutorID = $row['tutorID'];
            $schoolSearch = "SELECT pastSchool FROM tutors where tutorID = '".$tutorID."'";
            $schoolSearchResult = $conn->query($schoolSearch);
            
            if ($schoolSearchResult->num_rows === 1) {
                $rowSchool = $schoolSearchResult->fetch_assoc();
            
                $schoolCondition = $rowSchool['pastSchool'];
                
                if ($schoolCondition === $_SESSION['school']){
                    echo "<tr><td>" . $row["cvID"]. "</td><td>" . $row["referenceTeacher"]. "</td><td><button name='mybutton' value=". $row["cvID"]." type='submit'>Select CV</button></td></tr>";
                }
            }
            else {
                echo "gfhugfhjgki";
            }
        }
        echo "</table></form>";
    } else {
        echo "0 results";
    }
}
    $conn->close();
?>
<?php 
   if (isset($_POST["mybutton"]))
   {
       $_SESSION['CVIDtoView'] = $_POST["mybutton"];
       header("location: CVViewer.php");
   }
?>
</html>