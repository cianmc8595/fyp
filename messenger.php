<script>
    window.onload=function () {
     var objDiv = document.getElementById("messageContainer");
     objDiv.scrollTop = objDiv.scrollHeight;
}
</script>
<?php
// Initialize the session
session_start();

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
        					elseif ($_SESSION['usertype'] === "Tutor"){

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
					
					$previousMessagesSql = "SELECT * FROM conversations where convID = '".$convID."'";
    				$previousMessagesSqlResult = $conn->query($previousMessagesSql);    
					if ($previousMessagesSqlResult->num_rows > 0) { 
        					    
        					    echo "<div id='messageContainer' class='scroll'>";
        					    // output data of each row
        					    while($messageRow = $previousMessagesSqlResult->fetch_assoc()) {
                                    
                                    if ($messageRow['sender'] === $_SESSION['usertype']){
                                        $userStyle = "currentUserStyle";
                                    }
                                    else {
                                        $userStyle = "otherUserStyle";
                                    }
                                    
        						    echo "<p id=".$userStyle."><b>".$messageRow['sender']. ": ".$messageRow['message']." --- ".$messageRow['dateTime']. "<b><p><br> ";
            					
            				    }
            				    echo "</div>";
        		    }
        		    
        		    
if(isset($_POST['send']))
{
    $message = $_POST['message']; 
    $date_clicked = date('D, jS F Y g:ia');
    $date_clicked = date('d-m-Y H:i');
    
    // Check input errors before inserting in database
    if(empty($message)){
        
        echo "Must enter a message to send";
        
    }
    else {
        
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
                header("location: messenger.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $SQL->close();
        
    }
}
       
       if(isset($_POST['home'])){
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
       
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        #otherUserStyle { 
                color: white;
                font-size: 16px;
                text-align: right;
                padding-right: 20px;
                padding-left: 20px;
                width: 100%;
                background-color:#7f0606;
        }
        #currentUserStyle { 
                color: white;
                font-size: 16px;
                padding-right: 20px;
                padding-left: 20px;
                width: 100%;
                background-color:#062f99;
        } 
        div.scroll {
                background-color: white;
                width: 400px;
                height: 250px;
                overflow-y: scroll;
                overflow-x: hidden;
                margin-top: 20px;
                margin-left: 20px;
        }
        
    </style>
    
</head>
<body>
    <div class="wrapper">
        <h2>Messenger</h2>
        <p>To contact this tutor, type your message below and click send.</p>
        <form action="" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Conversation ID: <?php echo $convID; ?></label>
            </div> 
            <div class="form-group <?php echo (!empty($pastSchool_err)) ? 'has-error' : ''; ?>">
                <label>Message:<sup>*</sup></label>
                <input type="text" name="message"class="form-control" value="">
                <span class="help-block"><?php echo $pastSchool_err; ?></span>
            </div>
            <div class="form-group">
                <input name="send" type="submit" class="btn btn-primary" value="Send Message">
            </div>
        </form>
        <form action="" method="post">
            <input name="home" type="submit" class="btn btn-primary" value="Main Menu">
        </form>
    </div>    
</body>
</html>