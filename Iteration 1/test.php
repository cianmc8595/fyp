<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<FORM NAME ="form1" METHOD =" " ACTION = "">

<INPUT TYPE = "TEXT" VALUE ="username">
<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Login">

</FORM>


<?php

    //Connect to the Database
    $host = "127.0.0.1";
    $user = "cianmc85";
    $pass = "";
    $db = "project_db";
    $port = 3306;
    
    $connection = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
    
    
    //And now to perform a simple query to make sure its working
    $query = "SELECT id, username FROM users WHERE username LIKE 'u%'";
    $result = mysqli_query($connection, $query);
    
    
    if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Name</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["username"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
    
?>  


</body>
</html>