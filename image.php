<!DOCTYPE html>
<html>
<head>
<title>PHP File Upload example</title>
</head>
<body>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
    <label>File: </label><input type="file" name="image" />
    <input name="sumit" type="submit" value="Upload"/>
</form>
<?php
    
    if (isset($_POST['sumit']))
    {
        if(getimagesize($_FILES['image']['tmp_name'])== FALSE)
        {
            echo "Please select and image.";
        }
        else {
        
            $image = addslashes($_FILES['image']['tmp_name']);
            $name = addslashes($_FILES['image']['name']);
            $image = file_get_contents($image);
            $image = base64_encode($image);
            saveimage($name, $image);
        }
    }
    displayimage($image);
    function saveimage()
    {
        $con = mysql_connect("127.0.0.1","cianmc85","");
        mysql_select_db("project_db", $con);
        $qry = "UPDATE students SET profilePic='".$image."' WHERE studentID=1";
        $result = mysql_query($qry, $con);
        if ($result)
        {
            echo "<br/>Image uploaded.";
        }
        else {
            echo "<br/>Image not uploaded.";
        }
    }
    function displayimage()
    {
        $con = mysql_connect("127.0.0.1","cianmc85","");
        mysql_select_db("project_db", $con);
        $qry = "SELECT * from students WHERE studentID=1";
        $result = mysql_query($qry, $con);
        while($row = mysql_fetch_array($result))
        {
            echo '<img height="300" width="300" src="data:image,base64, '.$image.'"> ';
        }
        mysql_close($con);
    }






?>
</body>
</html>