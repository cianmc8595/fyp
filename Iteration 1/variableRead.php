<?PHP

$id = "";

if (isset($_POST['Submit1'])) {

$id = $_POST['id'];

//Connect to the Database
$host = "127.0.0.1";
$user = "cianmc85";
$pass = "";
$db = "project_db";
$port = 3306;
    
// Create connection
$conn_found = new mysqli($host, $user, $pass, $db, $port);

if ($conn_found) {

    $SQL = $conn_found->prepare('SELECT id, username FROM users WHERE id = ?');
    $SQL->bind_param('s', $id);
    $SQL->execute();
    $SQL->store_result();

    if ($SQL->num_rows === 1) {

        $SQL->bind_result($idVariable, $username); 
        $SQL->fetch();

        
        /*while ($SQL->fetch()) {
              $username[] = $usernameRow;
              foreach($results['data'] as $result) {
                    echo $result['type'], '<br>';
}*/
  }

    
    else {

        print "No records found";

    }

        $SQL->close();
        $conn_found->close();

}
else {

print "Database NOT Found ";

}

}

?>

<!DOCTYPE html>
<html>
<head>
<style>
body {
    
    background-color:#d5f4e6;
    
}
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    background-color:#80ced6;
    font-size:20px;
    text-decoration:strong;
}

input[type=submit]:hover {
    background-color:  #618685;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
</head>
<body>


<FORM NAME ="form1" METHOD ="POST" ACTION ="variableRead.php">
<label for="id">Search ID: </label>
<INPUT TYPE = 'TEXT' Name ='id' value="<?PHP print $id ; ?>">

<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Search for User">

<label for="id2">ID: </label>  
<input type="text" value="<?php echo $idVariable; ?>" />
<label for="uname">Username: </label>
<input type="text" value="<?php echo $username; ?>" />



</FORM>


</body>
</html>