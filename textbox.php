<script>
    //Getting value from "ajax.php".

function fill(Value) {

   //Assigning value to "search" div in "search.php" file.

   $('#search').val(Value);

   //Hiding "display" div in "search.php" file.

   $('#display').hide();

}

$(document).ready(function() {

   //On pressing a key on "Search box" in "search.php" file. This function will be called.

   $("#search").keyup(function() {

       //Assigning search box value to javascript variable named as "name".

       var name = $('#search').val();

       //Validating, if "name" is empty.

       if (name == "") {

           //Assigning empty value to "display" div in "search.php" file.

           $("#display").html("");

       }

       //If name is not empty.

       else {

           //AJAX is called.

           $.ajax({

               //AJAX type is "Post".

               type: "POST",

               //Data will be sent to "ajax.php".

               url: "textbox.php",

               //Data, that will be sent to "ajax.php".

               data: {

                   //Assigning value of "name" into "search" variable.

                   search: name

               },

               //If result found, this funtion will be called.

               success: function(html) {

                   //Assigning result to "display" div in "search.php" file.

                   $("#display").html(html).show();

               }

           });

       }

   });

});
</script>
<?php
 
//Including Database configuration file.
 
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
 
//Getting value of "search" variable from "script.js".
 
if (isset($_POST['search'])) {
 
//Search box value assigning to $Name variable.
 
   $Name = $_POST['search'];
 
//Search query.
 
   $autocompleteSql = "SELECT school FROM teachers WHERE school LIKE '%".$Name."%'";
 
//Query execution
 
   $autocompleteSqlResult = $conn->query($autocompleteSql);
 
//Creating unordered list to display result.
 
   echo '
 
<ul>
 
   ';
 
   //Fetching result from database.
 
   while ($autocompleteRetrieveRow = $autocompleteSqlResult->fetch_assoc()) {
 
       ?>
 
   <!-- Creating unordered list items.
 
        Calling javascript function named as "fill" found in "script.js" file.
 
        By passing fetched result as parameter. -->
 
   <li onclick='fill("<?php echo $autocompleteRetrieveRow['school']; ?>")'>
 
   <a>
 
   <!-- Assigning searched result in "Search box" in "search.php" file. -->
 
       <?php echo $autocompleteRetrieveRow['school']; ?>
 
   </li></a>
 
   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
 
   <?php
 
}}
 
 
?>
 
</ul>
<!DOCTYPE html>
 
<html>
 
 
 
<head>
 
   <title>Live Search using AJAX</title>
 
   <!-- Including jQuery is required. -->
 
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 
   <!-- Including our scripting file. -->
 
   <script type="text/javascript" src="script.js"></script>
 
   <!-- Including CSS file. -->
 
   <link rel="stylesheet" type="text/css" href="style.css">
 
</head>
 
 
 
<body>
 
<!-- Search box. -->
 
   <input type="text" id="search" placeholder="Search" />
 
   <br>
 
   <b>Ex: </b><i>David, Ricky, Ronaldo, Messi, Watson, Robot</i>
 
   <br />
 
   <!-- Suggestions will be displayed in below div. -->
 
   <div id="display"></div>
 
 
 
</body>
 
 
 
</html>