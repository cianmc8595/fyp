<?PHP

/* Code below is based on http://www.homeandlearn.co.uk/php */
$id = "";

if (isset($_POST['Submit1'])) {

$id = $_POST['id'];
/*END*/  

//Connect to the Database
/* Code below is based on https://community.c9.io/t/connecting-php-to-mysql/1606 a post by Brady Dowling */
$host = "127.0.0.1";
$user = "cianmc85";
$pass = "";
$db = "project_db";
$port = 3306;
/*END*/  

// Create connection
/* Code below is based on aspects from http://www.homeandlearn.co.uk/php and https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection */
$conn_found = new mysqli($host, $user, $pass, $db, $port);

if ($conn_found) {

    $SQL = $conn_found->prepare('SELECT teacherID, username, password, email, firstname, surname, subject, school FROM teachers WHERE teacherID = ?');
    $SQL->bind_param('s', $id);
    $SQL->execute();
    $SQL->store_result();

    if ($SQL->num_rows === 1) {

        $SQL->bind_result($teacherID, $username, $password, $email, $firstname, $surname, $subject, $school); 
        $SQL->fetch();
     /*END*/  

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

<!-- Code below is based on aspects from http://www.homeandlearn.co.uk/php and https://websitebeaver.com/prepared-statements-in-php-mysqli-to-prevent-sql-injection  -->
<FORM NAME ="form1" METHOD ="POST" ACTION ="searchTeachers.php">
<label for="id">Search ID: </label>
<INPUT TYPE = 'TEXT' Name ='id' value="<?PHP print $id ; ?>">

<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Search for Teacher">

<label for="id2">ID: </label>  
<input type="text" value="<?php echo $teacherID; ?>" />
<label for="uname">Username: </label>
<input type="text" value="<?php echo $username; ?>" />
<label for="pword">Password: </label>
<input type="text" value="<?php echo $password; ?>" />
<label for="email">Email: </label>
<input type="text" value="<?php echo $email; ?>" />
<label for="fname">First Name: </label>
<input type="text" value="<?php echo $firstname; ?>" />
<label for="sname">Surname: </label>
<input type="text" value="<?php echo $surname; ?>" />
<label for="subject">Subject: </label>
<input type="text" value="<?php echo $subject; ?>" />
<label for="school">School: </label>
<input type="text" value="<?php echo $school; ?>" />

<!-- END -->

</FORM>


</body>
</html>