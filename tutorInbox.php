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
        <h1>Hi, <b><?php echo $_SESSION['usertype']. " - " .$_SESSION['firstname']; ?></b>. Welcome to your Inbox.</h1>
        <h1>All of your conversations are listed below.</h1>
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
        
    } else {
        
            echo "0 results";
    
    }

    array_walk($CVArray , 'intval');
    $CVids = implode(',', $CVArray);
    $messageRetrieveSql = "SELECT distinct convID FROM conversations WHERE cvID IN ($CVids)";
    $messageRetrieveSqlResult = $conn->query($messageRetrieveSql);

    if ($messageRetrieveSqlResult->num_rows > 0) { 
        
            echo "<form action='' method='POST'><table class='table'><tr><th>conversation ID </th><th>Select conversation</th></tr>";
            // output data of each row
            while($MessageRetrieveRow = $messageRetrieveSqlResult->fetch_assoc()) {
            
                echo "<tr><td>" . $MessageRetrieveRow['convID']. "</td><td><button name='mybutton' value=".$MessageRetrieveRow['convID']." type='submit'>Select conversation</button></td></tr>";
            
            }
        
    } else {
        
            echo "0 results";
    
    } 

 
    if (isset($_POST["mybutton"]))
    {
        $_SESSION['conversationToView'] = $_POST["mybutton"];
        header("location: messenger.php");
    }

}
elseif ($_SESSION['usertype'] === "Student"){
    
    $messageRetrieveSql = "SELECT distinct convID FROM conversations WHERE studentID ='".$_SESSION['studentID']."'";
    $messageRetrieveSqlResult = $conn->query($messageRetrieveSql);

    if ($messageRetrieveSqlResult->num_rows > 0) { 
        
            echo "<form action='' method='POST'><table class='table'><tr><th>conversation ID </th><th>Select conversation</th><th>Rate & Review</th></tr>";
            // output data of each row
            while($MessageRetrieveRow = $messageRetrieveSqlResult->fetch_assoc()) {
            
                echo "<tr><td>" . $MessageRetrieveRow['convID']. "</td><td><button name='mybutton' value=".$MessageRetrieveRow['convID']." type='submit'>Select conversation</button></td><td><button name='reviewbtn' value=".$MessageRetrieveRow['convID']." type='submit'>Rate and Review</button></td></tr>";
            
            }
        
    } else {
        
            echo "0 results";
    
    } 

 
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

}
        $conn->close();
?>
</html>