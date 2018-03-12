<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: LandingPage.php#login");
  exit;
}/* END */

//DB details
        $dbHost     = '127.0.0.1';
        $dbUsername = 'cianmc85';
        $dbPassword = '';
        $dbName     = 'project_db';
        
        //Create connection and select DB
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
        // Check connection
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
        }

    $result = $db->query("SELECT image FROM images WHERE userID = '" .$_SESSION['studentID']."' AND usertype = '" .$_SESSION['usertype']."'");
    
    if($result->num_rows > 0){
        $imgData = $result->fetch_assoc();
        $_SESSION['profilePic'] = $imgData['image'];
        $_SESSION['pictureCheck'] = "True";
        //Render image
        
    }else{
        $_SESSION['pictureCheck'] = "False";
    }

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    
    
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="OCC Extranet App cards demo">
    <meta name="author" content="Samaritan's Purse International Relief">
    <title>app tiles</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
    
    
    
    
    
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Gaia - Bootstrap Template | Free Demo</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/gaia.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Cambo|Poppins:400,600' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/fonts/pe-icon-7-stroke.css" rel="stylesheet">
    
 <!--   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->


<style type="text/css">

	.form-control {
	    margin: 0 auto;
	    position:relative;
	    width: 80%;
        min-height: 41px;
		background: #fff;
		box-shadow: none !important;
		border-color: #e3e3e3;
	}
	.form-control:focus {
		border-color: #70c5c0;
	}
    .form-control, .btn {        
        border-radius: 2px;
    }
	.login-form {
		width: 90%;
		margin: 0 auto;
		margin-top:200px;
		padding: 180px 0 30px;
	}
	.login-form form {
		color: #7a7a7a;
		border-radius: 2px;
    	margin-bottom: 15px;
        font-size: 13px;
        background: #ececec;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;	
        position: relative;	
    }
	.login-form h2 {
		font-size: 22px;
        margin: 35px 0 25px;
    }
	.login-form .avatar {
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -5px;
		width: 80px;
		height: 80px;
		border-radius: 50%;
		z-index: 9;
		background: #70c5c0;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.login-form .avatar img {
		width: 100%;
		height:100%;
	}	
    .login-form input[type="checkbox"] {
        margin-top: 2px;
    }
    .login-form .btn {        
        font-size: 16px;
        font-weight: bold;
        color:white;
		background: #008b9c;
		border: none;
		margin-bottom: 20px;
    }
	.login-form .btn:hover, .login-form .btn:focus {
		background: #008b9c;
        outline: none !important;
	}    
	.login-form a {
		
		text-decoration: underline;
	}
	.login-form a:hover {
		text-decoration: none;
	}
	.login-form form a {
		color: #7a7a7a;
		text-decoration: none;
	}
	.login-form form a:hover {
		text-decoration: underline;
	}
	
	
	
	
	
	
	
	
	@import url(https://fonts.googleapis.com/css?family=Crimson+Text:400,700,900,400italic,700italic,900italic|Playfair+Display:400,700,900,400italic,700italic,900italic|Rock+Salt:400);

*,
:before,
:after {
    box-sizing: border-box;
}

body {
    background-color: #1d1f20;
    color: #e5e5e5;
    font: 16px/1.25 'Crimson Text', sans-serif;
    margin: 0;
}

#wrapper {
    margin-left: auto;
    margin-right: auto;
    max-width: 80em;
}

#container {
    float: left;
    padding: 1em;
    width: 100%;
}



/*** OPEN BOOK ***/
.open-book {
    background: #fff;
    box-shadow: rgba(0,0,0,0.5) 0 1em 3em;
    color: #000;
    padding: 2em;
}

.open-book * {
    position: relative;
}

/* Highlight */
.open-book *::-moz-selection {
    background: rgba(222,255,0,0.75);
}

.open-book *::selection {
    background: rgba(222,255,0,0.75);
}

/* Header/Footer */
.open-book header {
    padding-bottom: 1em;
}

.open-book header *,
.open-book footer * {
    font: 700 1em/1.25 'Playfair Display', sans-serif;
    letter-spacing: 0.125em;
    margin: 0;
}

.open-book header * {
    font-size: 0.75em;
    text-transform: uppercase;
}

.open-book footer {
    padding-top: 1em;
}

.open-book footer #page-numbers {
    display: none;
    list-style: none;
    padding: 0;
    text-align: left;
}

.open-book footer #page-numbers > li:last-child {
    text-align: right;
}

/* Chapter Title */
.open-book .chapter-title {
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCA2NCA2NCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNjQgNjQ7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCiAgICA8Zz4NCiAgICAJPHBhdGggZD0iTTAsMzJMMzIsMGwzMiwzMkwzMiw2NEwwLDMyeiBNOCwzMmwyNCwyNGwyNC0yNEwzMiw4TDgsMzJ6IE0xNiwzMmwxNi0xNmwxNiwxNkwzMiw0OEwxNiwzMnogTTI0LDMybDgsOGw4LThsLTgtOEwyNCwzMnoiIC8+DQogICAgPC9nPg0KPC9zdmc+) bottom center no-repeat;
    background-size: 0.5em 0.5em;
    font: 700 7vw/1.25 'Playfair Display', sans-serif;
    letter-spacing: 0.125em;
    margin: 0 0 1em 0;
    padding: 1em 0;
    position: relative;
    text-align: center;
    text-transform: uppercase;
}

.open-book .chapter-title:before,
.open-book .chapter-title:after {
    border: solid 0 #000;
    border-width: 0.05em 0;
    bottom: calc((0.125em / 2) * 3);
    content: '';
    height: 0.15em;
    position: absolute;
    width: calc(50% - (1em / 2));
}

.open-book .chapter-title:before {
    left: 0;
}

.open-book .chapter-title:after {
    right: 0;
}

/* Body Copy */
.open-book article {
    line-height: 1.5;
}

.open-book article *:not(.chapter-title):not(hr):not(dl) {
    margin: 0 auto;
    max-width: 28.125em;
}

.open-book article p {
    text-indent: 2em;
}

.open-book .chapter-title + p:first-of-type {
    text-indent: 0;
}

.open-book .chapter-title + p:first-of-type:first-letter {
    float: left;
    font: 700 3em/0.65 'Playfair Display', sans-serif;
    padding: 0.15em 0.05em 0 0;
    text-transform: uppercase;
}

.open-book article > ul,
.open-book article > ol {
    padding-left: 3em;
}

.open-book article > ul ul {
    padding-left: 1em;
}

.open-book a {
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCA4MDAgNTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDgwMCA1MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KCTxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJCS5zdDB7ZmlsbDojMDAwMENDO30NCgk8L3N0eWxlPg0KCTxnIGlkPSJZMkJjMjcudGlmIj4NCgkJPGc+DQoJCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNDMwLjksNDkuMmMtMSwwLTIsMC0zLDBjLTAuMS0wLjMtMC4yLTAuOC0wLjQtMC44Yy0xLjgtMC40LTQtMC4zLTUuNC0xLjNjLTEuOC0xLjQtNC4zLDAuMS01LjgtMS45Yy00LjMtMS04LjUtMi4zLTEyLjgtMi45Yy0zLjQtMC41LTYuOS0wLjEtMTAuMy0wLjFjLTAuMywwLjgtMC41LDEuNC0wLjcsMmMtMC41LTAuMy0wLjktMC42LTEuNC0xYy0wLjIsMS4yLTAuMywyLjEtMC42LDMuN2MtMS0xLjMtMS41LTIuMS0xLjktMi42Yy0yLjgsMC01LjMtMC41LTcuNCwwLjFjLTIuMiwwLjctMy43LDAuOC01LjktMC4xYy0yLjItMC45LTIuOS0yLjYtNC00Yy0yLjUsMS4yLTUuMSwxLjEtNy41LDAuMmMtMS4yLTAuNS0yLTAuNi0zLjEsMC4xYy0xLjIsMC43LTIuNiwxLTMuOSwxLjRjLTAuMiwwLjEtMC42LTAuMi0wLjgtMC4zYy0xLjItMS4zLDIuNC0yLjMsMC0zLjdjLTIuNiwxLjYtNS4yLDMuMy04LDVjLTAuOCwwLTEuOSwwLjMtMi43LTAuMWMtMi40LTEuMS00LjgtMi4zLTYuOS0zLjljLTEuOS0xLjUtMy45LTIuMi02LjItMmMtMSwwLjEtMiwwLTIuOCwwYy0wLjgtMS4xLTEuNC0yLTIuNy0zLjljMCwyLjMsMCwzLjYsMCw0LjljLTMuNywwLjgtNywxLjYtMTAuMywyLjNjLTEuNC0xLjgtMi42LTMuMi0zLjktNC45Yy0wLjQsMC44LTAuNiwxLjItMC43LDEuNmMtMC44LDMuMi0xLDMuMS00LjIsMi4zYy0yLjktMC43LTUuNC0yLjQtOC40LTMuNmMtMS42LDItMy4yLDQtNS4yLDYuNWMtMy44LTIuMi03LjgsMi0xMS45LDBjLTAuNCwwLjMtMC44LDAuNS0xLjIsMC44Yy0xLjQtMC45LTIuNy0xLjgtMy44LTIuNWMtMC44LTIuNy0xLjYtNS4yLTIuNC04LjJjLTEuMiwxLjMtMS45LDIuMi0zLDMuNGMwLDEsMCwyLjUsMCwzLjljLTUuMSwwLjYtOS45LDIuMS0xNS4xLDAuOWMwLTEsMC0xLjcsMC0yLjljLTEuMSwwLjUtMS45LDAuOS0yLjcsMS4zYy0xLjYtMC42LTMuMS0xLjItNC44LTEuOWMtMC42LDAuOC0xLjIsMS44LTEuOSwyLjhjLTAuNC0wLjktMC44LTEuNy0xLjItMi40YzAuMi0wLjQsMC40LTAuOSwxLjEtMi4yYy0zLDEuNS01LDIuNS03LjEsMy42Yy0xLTMtMy40LTQuNS02LTUuN2MtMC41LDAuNi0xLjEsMS4xLTEuNSwxLjZjMC41LDAuOSwwLjgsMS41LDEuMSwyLjJjLTAuOCwwLTEuMSwwLTEuNywwYy0wLjItMS0wLjQtMi0wLjctMy41Yy0xLjMsMC45LTIuMywxLjYtMy4zLDIuM2MtMC4yLTAuNi0wLjUtMS4yLTAuOC0yYy0xLjEsMS41LTIuMSwyLjktMyw0LjJjLTUuMywwLjQtNS45LTUtOS4xLTYuOWMtMC43LDEtMS40LDItMiwzYy0xLjgtMC40LTMuMy0wLjgtNC44LTEuMWMtMC4yLDAtMC40LDAuMy0wLjYsMC41YzAuMywwLjMsMC42LDAuNiwxLDFjLTAuOCwwLjYtMS42LDEuMS0yLjUsMS43Yy0wLjUtMS0wLjgtMS42LTEuMi0yLjVjLTEuNSwwLjgtMi44LDEuNi0zLjgsMi4yYy0wLjcsMS43LTEuMiwyLjktMS42LDQuMWMtMS40LTEuNy0yLjYtMy4yLTQuMS01YzAtMC40LDAtMS4yLDAtMS45Yy0xLjcsMC0zLjEsMC0zLjksMGMtMy4xLDEuOS01LjYsMy40LTguMiw1LjFjLTAuNC0wLjgtMC43LTEuNS0xLjEtMi4yYy0wLjYsMC0xLjMsMC0yLjEsMGMtMC42LDAuNi0xLjMsMS4zLTIsMS45Yy0wLjUtMC40LTEtMC43LTEuOC0xLjNjLTEsMS40LTEuOSwyLjctMi44LDMuOWMtMC4xLDAuMi0wLjQsMC4xLTAuNywwLjJjLTAuMi0xLTAuNC0xLjktMC42LTMuMmMtMC41LDEtMC44LDEuNy0xLjUsMy4zYzAtMi4yLDAtMy40LDAtMy41Yy0xLjktMS45LTMuMS0zLjEtNC4zLTQuM2MtMy41LDEuMS0zLDUuNC00LjgsNy42Yy00LjgsMC41LTkuMywwLjktMTMuOCwxLjRjLTAuMS0xLjEtMC4yLTEuOS0wLjMtMi45Yy0xLjUsMC0yLjksMC00LjIsMGMtMS40LDAuNy0yLjgsMS4zLTQuMiwyYy0wLjMtMC45LTAuNi0xLjQtMC45LTIuM2MtNi43LDAuNi0xMi41LDQuNC0xOSw2LjNjLTAuOS0xLjItMS45LTIuMy0yLjYtMy4zYy0zLDEuOC01LjYsMy4xLTguNywxLjJjLTAuNSwxLTEuMSwxLjktMS42LDIuN2MtMi43LDAuOC0zLjMtMS4yLTQtMi43Yy0yLjIsMC40LTQuMiwwLjctNS45LDFjLTAuOS0wLjktMS41LTEuNS0yLjEtMi4xYy0xLjIsMC42LTUuOSwxLjEtNi44LDEuMmMtMi41LDAuMi00LjksMC42LTguMSwxYy0wLjIsMC40LTAuNywxLjMtMS4xLDJjLTItMC42LTMuNS0xLjEtNS4zLTEuNmMtMC42LDAuOC0xLjEsMS42LTIuMSwyLjljLTAuNy0xLjktMS4yLTMuMi0xLjctNC44Yy0xLDEuMi0xLjgsMi40LTIuMywzYy0xLjgsMC0zLDAtNCwwYy0wLjEtMS0wLjEtMS44LTAuMi0yLjNjLTIsMC4zLTQuMSwwLTUuNSwwLjljLTIuMywxLjMtNC44LDEuMS02LjcsMC41Yy0yLjMtMC44LTQuNi0xLjMtNi41LTAuM2MtMi4xLDEuMS00LjctMC41LTYuNCwxLjVjMCwwLjEtMC41LTAuMy0xLTAuNWMwLjQtMSwwLjktMS45LDEuMy0yLjljLTAuOS0wLjctMS42LTEuMi0yLjgtMi4xYy0xLjYsMy4xLTMsNS44LTQuNCw4LjVjLTEsMC0yLDAtMywwYy0wLjEtMC4zLTAuMi0wLjgtMC40LTAuOGMtMS44LTAuNC00LTAuMy01LjQtMS4zYy0xLjgtMS4zLTQuMywwLTUuOC0xLjlDMTAuOSw0NC4xLDUuNiw0Mi45LDAsNDEuN2MwLTguMSwwLTE2LjYsMC0yNS4yYzEtMC45LDIuMy0xLjcsMS44LTMuOGMtMC42LTAuNy0wLjYtMS41LTEuNS0yLjZDMS45LDguMSwyLjYsNiw0LjQsMy44YzEuMywwLjYsMi41LDEuMSwzLjcsMS42QzcuNSw4LDcuOCwxMC4yLDkuMywxMi4yYzAuNiwwLDEuMywwLDIuNCwwYzAuNy0wLjgsMS42LTIsMi43LTMuNGMwLjQsMS4xLDAuNiwxLjcsMC44LDIuMmMyLjYsMCw1LjEsMCw3LjksMGMwLTEuNCwwLTIuNSwwLTMuNWMxLTAuNCwxLjgtMC43LDIuOC0xLjJjMi4yLDEuOSw0LjYsMy45LDYuNyw1LjhjMS4yLDAsMi4xLDAsMi41LDBjMS4zLTEuNiwyLjMtMi43LDMuMy0zLjljMC41LDAuOSwwLjksMS42LDEuNiwyLjZjMS0xLjUsMS42LTIuNSwyLjMtMy41YzIuOSwwLDMtMC4xLDUuNSwxLjJjNC4xLDIuMiw4LjYsMi40LDEyLjcsMS4zYzMuMi0wLjgsNi4xLTAuMyw5LjItMC42YzMuMi0wLjQsNi4zLDAuMiw5LjQsMS41YzIuNywxLjEsNS41LDEsNy43LTAuOWMyLjctMi4zLDUuNC00LjQsOC42LTUuM2MxLjIsMC40LDIuMywwLjcsNCwxLjJjMC42LDEuNiwxLjQsMy40LDIuMiw1LjVjMC42LTEsMS4zLTIsMS43LTIuN2MxLjUtMC41LDIuOS0wLjksNC4xLTEuM2MwLjYsMS40LDEuMiwyLjcsMiw0LjRjMi42LTYuMiw4LTYuOSwxMy4yLTguNWMyLjEsMy40LDQuMiw2LjksNi42LDEwLjdjMS0xLjksMS42LTMuMywyLjMtNC42YzAuNywwLDEuNCwwLDIsMGMtMC4zLTAuMy0wLjYtMC42LTAuOS0xYzAuOC0wLjEsMS43LTAuMywyLjUtMC40Yy0wLjEtMC4yLTAuMy0wLjQtMC40LTAuNWMtMS41LDAtMi45LDAtNCwwYy0wLjgtMC43LTEuMy0xLjEtMS40LTEuMmMwLjQtMS44LDAuNy0zLjMsMS00LjdjMC45LDAsMS43LDAsMi40LDBjMC4yLDAuNywwLjQsMS4zLDAuNSwxLjZjMi4xLDAuNiwzLjksMS4xLDUuNSwxLjZjMC4yLDAuNywwLjUsMS4yLDAuNywxLjhjMS4yLTAuNSwyLjQtMC43LDMuMi0xLjRjMS40LTEuMiwyLjUtMi42LDMuOS00LjJjMC42LDIuNCwxLjEsNC4zLDEuNiw2LjNjLTIuNCwwLjEtNC4zLDAuMi02LjMsMC40YzAuNiwwLjcsMC45LDEsMS4xLDEuNWMwLjIsMC40LDAuMiwwLjksMC4zLDEuM2MxLjYtMC4xLDMsMC40LDQuMy0wLjljMC43LTAuNywyLTAuOCwzLTFjMC40LTAuMSwwLjksMC4yLDEuMiwwLjJjMC4yLDEuMSwwLjMsMS45LDAuNiwzLjRjMS4zLTEuMSwyLjItMS44LDMuMy0yLjdjMC44LDEuMSwxLjcsMi4yLDIuMSwyLjhjMy40LDEsMy44LTEuMyw0LjktMy40YzAuOSwxLjMsMS40LDIsMi4xLDMuMWMxLTAuOSwxLjgtMS43LDIuNi0yLjRjMC4zLDAuNywwLjcsMS40LDEsMi4xYzEuNC0wLjQsMi41LTEsMi40LTIuNmMxLjYsMC4xLDEuOC0xLjUsMi42LTIuN2MwLjQsMS4xLDAuNiwxLjcsMC43LDJjMi4xLTEuMiw0LjEtMi40LDYuMi0zLjdjMC4zLDAuMywwLjcsMC42LDEuMiwxYzAuNy0xLDEuMy0yLDEuOS0zYzEuNywwLDMuMywwLDUuMiwwYzAuNSwwLjksMS4xLDEuOCwxLjYsMi42YzUtMS42LDkuOC0wLjUsMTQuNSwxLjdjMC41LDEuNSwxLjEsMywxLjgsNS4yYzEuNy0zLjYsMy4yLTYuNiw0LjYtOS41YzIsMS42LDQsMC42LDUuOSwxYzIsMC40LDMuOSwwLjgsNiwxLjNjMCwxLjQsMCwyLjUsMCwzLjljMS41LTEuMSwyLjgtMiw0LTIuOWMwLjQtMC4yLDAuOS0wLjIsMS4yLTAuM2MwLjYsMS4xLDEuMiwyLDEuOCwzYzEuOSwwLDQsMC42LDUuNS0wLjFjMi45LTEuMyw1LjgtMC42LDktMWMwLjQsMC41LDAuOSwxLjIsMS41LDEuN2MwLjcsMC42LDEuNSwxLDIuOCwxLjljMC0yLjYsMC00LjUsMC02LjVjMS44LDAsMy4zLDAsNC41LDBjMi44LDEuNCwwLjgsNC4xLDIuMiw2LjJjMS44LTAuOCwzLjYtMS42LDUuMi0yLjNjMC4yLTEuNCwwLjQtMi4yLDAuNS0yLjljMy42LDAuNiw2LjgsMS40LDEwLjEsMS43YzIuMSwwLjIsNC4xLDAuMyw1LjgsMS43YzEuMiwxLDIuNiwxLjYsNC4xLDIuNWM1LjgtMS44LDEwLjYtNi43LDE2LjktNi4xYzEuOCwxLjMsMy4yLDIuMiw0LjYsMy4zYzEuNCwxLjEsMi42LDIuMyw0LjQsMy44YzAsMC4yLDAsMSwwLDEuOWMxLjgtMC44LDIuNC0yLjcsNC4zLTMuMWMxLjYtMC4zLDIuOS0xLjgsNC41LTIuOWMxLjIsMC4xLDIuNywwLjIsNC4zLDAuM2MtMC41LDEuMS0wLjgsMS45LTEuMywzLjFjMi0wLjksMy40LTEuNSw0LjctMi4xYzAuMywwLjgsMC41LDEuMywwLjgsMmMwLjktMC40LDEuNS0wLjcsMi4yLTEuMWMwLjIsMC42LDAuNCwxLjIsMC43LDEuOWMxLjgtMC4zLDMuNywwLjQsNS4zLTAuOGMwLjMsMC4zLDAuNiwwLjUsMC45LDAuOGMwLjctMSwxLjQtMi4xLDIuMS0zLjFjMC4yLDAsMC40LTAuMSwwLjUsMGMwLjUsMC4zLDEuMSwwLjcsMSwwLjZjMi45LTAuMyw1LjItMC41LDcuNS0wLjhjMC4yLDEuMywwLjQsMi4yLDAuNiwzLjRjMy01LjgsMTAuNS01LjksMTMuOC0zLjZjMC44LDEuMiwxLjUsMi4zLDIuMSwzLjFjMS41LDAsMi42LDAsMy44LDBjLTAuNy0xLjMtMS4zLTIuMy0xLjktMy40YzEuMS0wLjUsMi4yLTEuMSwzLjYtMS43YzAuMywxLjMsMC41LDIuMywwLjYsMi45YzAuOSwwLjUsMS40LDAuNywyLDFjLTAuNiwxLjEtMSwxLjktMS41LDNjMS40LDAuOSwyLjcsMS42LDQuMSwyLjRjMC43LTEuMSwxLjItMiwxLjgtMi45YzAuMiwxLjYsMCwzLjYtMC41LDQuOWMtMC4xLDAuMiwwLjIsMC42LDAuMywwLjljMC4xLDAuMSwwLjMsMC4yLDAuNCwwLjJjMC4zLDAsMC42LTAuMSwwLjktMC4yYzAuNi0yLjksMC42LTIuOSwzLjMtNC41Yy0wLjQtMS0wLjctMS45LTEuMy0zLjNjMS4xLDAsMS43LTAuMSwyLjQsMGMwLjYsMC4xLDEuMiwwLjMsMS44LDAuNGM0LjgsMC44LDkuNCw0LDE0LjcsMS4yYzEsMS4yLDEuOSwyLjQsMi43LDMuM2MyLjYsMC4yLDMuOS0wLjcsMy43LTMuM2MtMC42LTAuOC0xLjQtMS43LTIuMy0yLjhjMS43LTIuMiwzLjMtNC4xLDUtNi4yYzEuMywwLjYsMi4zLDEsMi44LDEuM2MwLjcsMi44LDEuMiw1LDEuNyw3YzMuMSwwLjksMy43LTIsNS42LTIuN2MwLjMsMC43LDAuNSwxLjMsMC42LDEuN2MyLjYsMCw1LjEsMCw3LjcsMGMwLTEuMywwLTIuNCwwLTMuNGMxLTAuNSwxLjgtMC45LDMtMS41YzIuMSwxLjksNC40LDQsNi42LDZjMSwwLDIsMCwyLjYsMGMxLjItMS41LDIuMi0yLjcsMy4xLTMuOWMwLjgsMC45LDEuMywxLjUsMS45LDIuMmMwLjktMS40LDEuNS0yLjQsMi4zLTMuN2MxLjgsMC42LDMuNiwwLjgsNSwxLjZjNC4xLDIuNCw4LjUsMi4yLDEyLjgsMS42YzYuNi0wLjksMTIuNS0xLjQsMTcuMiwwLjJjMi4zLDAuOCw0LjYsMS4yLDYuNiwwLjljNC0yLjUsNy42LTQuOCwxMC42LTYuOGMyLDAuNiwzLjIsMC45LDQuNSwxLjNjMC43LDEuOCwxLjUsMy42LDIuMyw1LjZjMC43LTEuMSwxLjItMiwxLjgtMi45YzEuNC0wLjQsMi44LTAuOSw0LjEtMS4yYzAuNiwxLjUsMS4xLDIuOCwxLjgsNC41YzIuNy02LjMsOC4yLTcuMSwxMy41LTguNWMyLDMuNCw0LDYuOCw2LjQsMTAuN2MwLjktMS45LDEuNi0zLjMsMi4xLTQuM2MxLjQtMC42LDIuNi0xLjIsNC44LTIuMWMtMy0wLjgtNS41LDAuNi02LjctMS40YzAuNC0xLjgsMC43LTMuMywxLTQuOWMwLjgsMCwxLjYsMCwyLjUsMGMwLjEsMC41LDAuMiwxLDAuMywxLjZjMS44LDAuNSwzLjgsMS4xLDUuNywxLjZjMC4zLDAuNiwwLjUsMS4zLDEsMi4zYzIuNi0yLDQuOC0zLjcsNy01LjRjMC41LDEuOSwwLjksMy43LDEuNSw1LjljLTIuMywwLTQuMywwLTYuMiwwYzAuNSwxLjEsMC45LDEuOSwxLjMsMi44YzIuNCwwLjYsNC4zLTAuMyw2LjEtMS43YzAuNS0wLjQsMS41LTAuMSwyLjMtMC4xYzAuMiwxLjIsMC40LDIuMSwwLjcsMy40YzEuMy0wLjksMi4yLTEuNiwzLjctMi43YzAuOSwxLDEuOSwyLjEsMywzLjNjMS45LDAuMiwyLjctMS4xLDMuMS0yLjdjMC0wLjIsMC42LTAuMiwxLjEtMC4zYzAuMiwwLjMsMC40LDAuNiwwLjcsMWMwLjMsMC40LDAuNiwwLjksMS40LDIuMWMwLjktMS4zLDEuNC0yLjEsMi0zYzAsMCwwLjIsMC4xLDAuMywwLjJjMC4yLDAuNiwwLjQsMS4yLDAuNiwxLjhjMS43LTAuOSwzLjctMi43LDUuMy00LjljMC4yLDAuNiwwLjUsMS4xLDAuNiwxLjZjMi4xLTEuMiw0LjItMi40LDYuMi0zLjdjMC40LDAuMywwLjcsMC42LDEuMiwxYzAuNi0xLjEsMS4yLTIsMS43LTIuOWMxLjgsMCwzLjYsMCw1LjQsMGMwLjYsMSwxLjEsMS45LDEuNCwyLjNjNS4yLTEsMTAtMC42LDE0LjcsMi4xYzAuNSwxLjMsMSwyLjksMS43LDUuMWMxLjctMy41LDMuMS02LjUsNC42LTkuNmMwLjQsMC4zLDAuNiwwLjcsMC44LDAuN2MyLjQsMC4yLDQuOSwwLjQsNi44LDAuNWMxLjcsMC41LDIuOCwwLjksNCwxLjNjMC4xLDEuMiwwLjMsMi40LDAuNCwzLjdjMS45LTEuMiwzLjQtMi4zLDUtMy4zYzAuOCwxLjMsMS41LDIuMywyLjIsMy40YzQuOC0wLjUsOS41LTEsMTMuNy0xLjRjMS43LDEuNCwyLjksMi41LDQuNyw0LjFjMC4xLTIuNCwwLjEtNCwwLjItNS42YzAtMC40LDAuMi0wLjksMC40LTEuM2MxLjUsMCwyLjgsMCw0LjEsMGMwLjUsMC41LDEsMSwxLjYsMS42YzAsMS4zLDAsMi43LDAsNC4yYzIuNSwwLjYsNC4xLTAuNiw1LjctMi4xYzAuMi0wLjksMC4zLTEuOCwwLjUtMi44YzQuNSwxLjIsOC44LDIuNCwxMy4yLDJjMi4zLDEuNCw0LjQsMi43LDcsNC4yYzIuMy0xLjEsNS0yLjQsNy42LTMuN2MzLTEuNSw2LTIuOSw5LjQtMi41YzIuOSwyLjIsNS43LDQuNSw4LjUsNi43YzAuMSwwLjgsMC4yLDEuNSwwLjMsMmMyLjktMiw1LjctMy44LDguMy01LjZjMS41LDAsMywwLDQuNiwwYy0wLjEsMC43LTAuMiwxLjEtMC40LDEuNmMtMC4xLDAuMy0wLjQsMC42LTEuNCwxLjljMi42LTEuMiw0LTEuOCw1LjQtMi41YzAuMiwwLjcsMC40LDEuMywwLjcsMi4xYzAuOC0wLjUsMS41LTAuOCwyLjItMS4yYzAuMiwwLjYsMC40LDEuMSwwLjYsMS43YzIuMiwxLjEsNC4zLTEsNi42LDBjMC42LTEsMS4zLTIsMi0zYzAuOSwwLjUsMS42LDAuOSwyLjIsMS4zYzIuMy0xLjYsNC42LTEuMSw3LjEtMC45YzAsMS4xLDAsMS45LDAsMi43YzEuMi0zLDMuNi0zLjcsNi40LTMuOWMyLjctMi43LDUsMC42LDcuMywwLjJjMC45LDEuNSwxLjcsMi43LDIuMywzLjdjMS40LDAsMi41LDAsMy43LDBjLTAuNi0xLjMtMS4yLTIuNC0xLjgtMy42YzEuMy0wLjUsMi40LTEsMy42LTEuNWMwLjIsMS4zLDAuMywyLjIsMC41LDIuOWMwLjgsMC4zLDEuMywwLjUsMi4xLDAuOGMtMC41LDEuMS0wLjksMS45LTEuNSwzYzEuMywwLjksMi42LDEuNywzLjksMi41YzAuNy0xLDEuMy0yLDEuOS0yLjljMC4yLDAuMSwwLjQsMC4yLDAuNiwwLjNjLTAuMywxLjgtMC42LDMuNi0xLDUuNWMwLjUsMC4xLDAuOSwwLjEsMS40LDAuMmMwLjQtMS4xLDAuNS0yLjMsMS4xLTMuMWMwLjYtMC44LDEuNi0xLjIsMi41LTEuN2MtMC41LTEuMS0wLjktMS45LTEuMy0yLjljMy4xLTEsNS41LDAuNyw4LjEsMS4xYzEuOCwwLjMsMy41LDEuNCw1LjMsMS41YzEuNywwLjEsMy40LTAuNiw1LjEtMC45YzEuNywwLjgsMi4yLDMuNCw0LjcsM2MwLDguNywwLDE3LjMsMCwyNmMtMi4zLDAtNC42LDAtNi43LDBjLTAuMywwLjktMC41LDEuNC0wLjcsMmMtMC41LTAuNC0wLjgtMC43LTEuNC0xLjFjLTAuMiwxLjEtMC4zLDItMC40LDIuN2MtMC42LTAuNi0xLjMtMS4zLTEuOC0xLjhjLTMsMC4yLTUuNSwwLTcuOCwwLjVjLTUuMSwxLjItNy4xLDAuNS05LjUtNC4xYy0yLjcsMS01LjIsMS4xLTcuOSwwLjFjLTAuNy0wLjMtMS42LTAuNS0yLjMtMC4zYy0xLjUsMC41LTIuOCwxLjMtNC4yLDEuOWMtMC4zLDAuMS0wLjktMC4yLTEuNC0wLjNjMC40LTEuMiwwLjgtMi4zLDEuNS00LjRjLTMuNywyLjMtNi41LDMuOS05LjYsNS45Yy00LjctMC40LTguMy0zLjktMTIuOC02LjJjLTEuOCwwLTMuOCwwLTUuMywwYy0wLjgtMS4xLTEuNS0yLTIuNy0zLjZjMCwyLjEsMCwzLjIsMCw0LjNjLTMuOCwxLjYtNy42LDIuNC0xMC44LDIuM2MtMS4xLTEuMy0yLjMtMi43LTMuNi00LjNjLTEsMS44LTAuNCw0LjItMy40LDQuNWMtMi45LTEuMi02LjMtMi43LTkuOS00LjJjLTEuNiwyLTMuMiw0LTUsNi4zYy00LTEuNS04LDEuOC0xMi4xLDAuMmMtMC41LDAuMy0wLjksMC41LTEuMywwLjdjLTEuNC0xLTIuNy0xLjgtMy42LTIuNWMtMC45LTIuOC0xLjctNS4yLTIuNS03LjljLTEuMiwxLjItMiwyLTMsM2MwLDEuMywwLDIuOCwwLDQuMWMtNSwwLjUtOS43LDItMTQuNiwwLjljLTAuMi0wLjktMC4zLTEuOC0wLjYtM2MtMS4xLDAuNS0xLjksMC45LTIuNiwxLjNjLTEuNy0wLjYtMy4yLTEuMi00LjktMS44Yy0wLjUsMC45LTEuMSwxLjgtMS43LDIuOGMtMC40LTAuOS0wLjktMS44LTEuMi0yLjRjMC4yLTAuNywwLjMtMS4xLDAuNy0yLjFjLTIuNywxLjQtNC43LDIuNC02LjcsMy40Yy0xLjgtMy4zLTQuOC02LjEtNi4xLTUuNmMtMC40LDAuNC0wLjksMC45LTEuMywxLjVjMC4zLDAuNywwLjYsMS4zLDEuMSwyLjNjLTAuOC0wLjEtMS4zLTAuMS0xLjgtMC4xYy0wLjItMS4yLTAuMy0yLTAuNi0zLjVjLTEuNCwxLjEtMi4zLDEuOC0zLjMsMi41Yy0wLjMtMC44LTAuNS0xLjMtMC44LTIuMmMtMS4xLDEuNi0yLjEsMi45LTMuMSw0LjRjLTIuMy0wLjgtNC43LTAuOC01LjYtMy44Yy0wLjUtMS40LTIuMS0yLjMtMy4xLTMuNGMtMC44LDEuMS0xLjUsMi4xLTIuMiwzLjFjLTEuOS0wLjUtMy41LTAuOS01LjUtMS40YzAuNSwxLDAuNywxLjQsMSwyYy0wLjgsMC41LTEuNiwwLjktMi40LDEuM2MtMC40LTEtMC43LTEuNi0xLjEtMi40Yy0xLjUsMC44LTIuNywxLjQtMy44LDJjLTAuNywxLjYtMS4yLDMtMS44LDQuM2MtMS40LTEuOC0yLjYtMy4zLTMuOC00LjhjLTAuMS0wLjctMC4xLTEuNS0wLjItMi4xYy0xLjgsMC0zLjMsMC00LDBjLTMuMSwxLjktNS42LDMuNC04LjMsNWMtMC40LTAuOC0wLjctMS41LTEuMy0yLjZjLTEuNCwwLjctMi43LDEuNC00LjEsMi4xYy0wLjMtMC4yLTAuOS0wLjUtMS42LTFjLTEsMS40LTEuOSwyLjctMi44LDMuOWMtMC4xLDAuMS0wLjQsMC4xLTAuNywwLjFjLTAuMi0xLTAuMy0xLjgtMC41LTMuMWMtMC41LDEuMS0wLjgsMS43LTEuNiwzLjNjMC0yLjIsMC0zLjUsMC00LjdjLTAuMywwLjItMC42LDAuMy0wLjgsMC41Yy0xLjEtMS4yLTIuMy0yLjMtMy42LTMuNmMtMy4zLDEuMi0yLjksNS40LTQuNyw3LjZjLTQuOSwwLjUtOS4zLDAuOS0xMy44LDEuNGMtMC4xLTEuMi0wLjItMi0wLjMtMi45Yy0xLjUsMC0yLjksMC00LjIsMGMtMS41LDAuNy0yLjksMS4zLTQuMiwyYy0wLjMtMC45LTAuNi0xLjUtMC45LTIuNGMtNi43LDEtMTIuNSw0LjQtMTkuMSw2LjZjLTAuOS0xLjItMS45LTIuNC0yLjYtMy40Yy0yLjksMS45LTUuNSwyLjktOC43LDEuMmMtMC41LDAuOS0xLjEsMS45LTEuNiwyLjhjLTAuNywwLTEuMywwLTIuMiwwYy0wLjYtMC45LTEuMy0yLTEuOC0yLjhjLTIuMSwwLjMtNC4xLDAuNy01LjgsMC45Yy0wLjktMC45LTEuNS0xLjUtMi4xLTIuMWMtMS4zLDAuNi01LjgsMS4xLTYuOCwxLjJjLTIuNSwwLjItNC45LDAuNi04LjEsMWMtMC4yLDAuNC0wLjYsMS4zLTEsMmMtMi0wLjYtMy41LTEuMS01LjMtMS42Yy0wLjYsMC44LTEuMSwxLjYtMiwzYy0wLjctMi0xLjItMy4zLTEuNy00LjdjLTEsMS4xLTEuOSwyLjItMi40LDIuOGMtMS45LDAtMi45LDAtNCwwYy0wLjEtMS0wLjEtMS44LTAuMi0yLjRjLTIsMC4zLTQuMSwwLTUuNiwwLjljLTIuMywxLjMtNC44LDEuMS02LjcsMC41Yy0yLjMtMC44LTQuNS0xLjMtNi41LTAuM2MtMi4xLDEuMS00LjctMC41LTYuNCwxLjVjMCwwLjEtMC41LTAuMy0xLTAuNWMwLjQtMC45LDAuOS0xLjksMS4zLTIuOWMtMC45LTAuNy0xLjYtMS4yLTIuOC0yLjFDNDMzLjgsNDMuOCw0MzIuNCw0Ni41LDQzMC45LDQ5LjJ6Ii8+DQoJCTwvZz4NCgk8L2c+DQo8L3N2Zz4=) bottom repeat-x;
    background-size: auto 0.25em;
    color: inherit;
    text-decoration: none;
}

.open-book s,
.open-book strike {
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCA4MDAgNTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDgwMCA1MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KCTxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJCS5zdDB7ZmlsbDojQ0MwMDAwO30NCgk8L3N0eWxlPg0KCTxnIGlkPSJZMkJjMjcudGlmIj4NCgkJPGc+DQoJCQk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNNDMwLjksNDkuMmMtMSwwLTIsMC0zLDBjLTAuMS0wLjMtMC4yLTAuOC0wLjQtMC44Yy0xLjgtMC40LTQtMC4zLTUuNC0xLjNjLTEuOC0xLjQtNC4zLDAuMS01LjgtMS45Yy00LjMtMS04LjUtMi4zLTEyLjgtMi45Yy0zLjQtMC41LTYuOS0wLjEtMTAuMy0wLjFjLTAuMywwLjgtMC41LDEuNC0wLjcsMmMtMC41LTAuMy0wLjktMC42LTEuNC0xYy0wLjIsMS4yLTAuMywyLjEtMC42LDMuN2MtMS0xLjMtMS41LTIuMS0xLjktMi42Yy0yLjgsMC01LjMtMC41LTcuNCwwLjFjLTIuMiwwLjctMy43LDAuOC01LjktMC4xYy0yLjItMC45LTIuOS0yLjYtNC00Yy0yLjUsMS4yLTUuMSwxLjEtNy41LDAuMmMtMS4yLTAuNS0yLTAuNi0zLjEsMC4xYy0xLjIsMC43LTIuNiwxLTMuOSwxLjRjLTAuMiwwLjEtMC42LTAuMi0wLjgtMC4zYy0xLjItMS4zLDIuNC0yLjMsMC0zLjdjLTIuNiwxLjYtNS4yLDMuMy04LDVjLTAuOCwwLTEuOSwwLjMtMi43LTAuMWMtMi40LTEuMS00LjgtMi4zLTYuOS0zLjljLTEuOS0xLjUtMy45LTIuMi02LjItMmMtMSwwLjEtMiwwLTIuOCwwYy0wLjgtMS4xLTEuNC0yLTIuNy0zLjljMCwyLjMsMCwzLjYsMCw0LjljLTMuNywwLjgtNywxLjYtMTAuMywyLjNjLTEuNC0xLjgtMi42LTMuMi0zLjktNC45Yy0wLjQsMC44LTAuNiwxLjItMC43LDEuNmMtMC44LDMuMi0xLDMuMS00LjIsMi4zYy0yLjktMC43LTUuNC0yLjQtOC40LTMuNmMtMS42LDItMy4yLDQtNS4yLDYuNWMtMy44LTIuMi03LjgsMi0xMS45LDBjLTAuNCwwLjMtMC44LDAuNS0xLjIsMC44Yy0xLjQtMC45LTIuNy0xLjgtMy44LTIuNWMtMC44LTIuNy0xLjYtNS4yLTIuNC04LjJjLTEuMiwxLjMtMS45LDIuMi0zLDMuNGMwLDEsMCwyLjUsMCwzLjljLTUuMSwwLjYtOS45LDIuMS0xNS4xLDAuOWMwLTEsMC0xLjcsMC0yLjljLTEuMSwwLjUtMS45LDAuOS0yLjcsMS4zYy0xLjYtMC42LTMuMS0xLjItNC44LTEuOWMtMC42LDAuOC0xLjIsMS44LTEuOSwyLjhjLTAuNC0wLjktMC44LTEuNy0xLjItMi40YzAuMi0wLjQsMC40LTAuOSwxLjEtMi4yYy0zLDEuNS01LDIuNS03LjEsMy42Yy0xLTMtMy40LTQuNS02LTUuN2MtMC41LDAuNi0xLjEsMS4xLTEuNSwxLjZjMC41LDAuOSwwLjgsMS41LDEuMSwyLjJjLTAuOCwwLTEuMSwwLTEuNywwYy0wLjItMS0wLjQtMi0wLjctMy41Yy0xLjMsMC45LTIuMywxLjYtMy4zLDIuM2MtMC4yLTAuNi0wLjUtMS4yLTAuOC0yYy0xLjEsMS41LTIuMSwyLjktMyw0LjJjLTUuMywwLjQtNS45LTUtOS4xLTYuOWMtMC43LDEtMS40LDItMiwzYy0xLjgtMC40LTMuMy0wLjgtNC44LTEuMWMtMC4yLDAtMC40LDAuMy0wLjYsMC41YzAuMywwLjMsMC42LDAuNiwxLDFjLTAuOCwwLjYtMS42LDEuMS0yLjUsMS43Yy0wLjUtMS0wLjgtMS42LTEuMi0yLjVjLTEuNSwwLjgtMi44LDEuNi0zLjgsMi4yYy0wLjcsMS43LTEuMiwyLjktMS42LDQuMWMtMS40LTEuNy0yLjYtMy4yLTQuMS01YzAtMC40LDAtMS4yLDAtMS45Yy0xLjcsMC0zLjEsMC0zLjksMGMtMy4xLDEuOS01LjYsMy40LTguMiw1LjFjLTAuNC0wLjgtMC43LTEuNS0xLjEtMi4yYy0wLjYsMC0xLjMsMC0yLjEsMGMtMC42LDAuNi0xLjMsMS4zLTIsMS45Yy0wLjUtMC40LTEtMC43LTEuOC0xLjNjLTEsMS40LTEuOSwyLjctMi44LDMuOWMtMC4xLDAuMi0wLjQsMC4xLTAuNywwLjJjLTAuMi0xLTAuNC0xLjktMC42LTMuMmMtMC41LDEtMC44LDEuNy0xLjUsMy4zYzAtMi4yLDAtMy40LDAtMy41Yy0xLjktMS45LTMuMS0zLjEtNC4zLTQuM2MtMy41LDEuMS0zLDUuNC00LjgsNy42Yy00LjgsMC41LTkuMywwLjktMTMuOCwxLjRjLTAuMS0xLjEtMC4yLTEuOS0wLjMtMi45Yy0xLjUsMC0yLjksMC00LjIsMGMtMS40LDAuNy0yLjgsMS4zLTQuMiwyYy0wLjMtMC45LTAuNi0xLjQtMC45LTIuM2MtNi43LDAuNi0xMi41LDQuNC0xOSw2LjNjLTAuOS0xLjItMS45LTIuMy0yLjYtMy4zYy0zLDEuOC01LjYsMy4xLTguNywxLjJjLTAuNSwxLTEuMSwxLjktMS42LDIuN2MtMi43LDAuOC0zLjMtMS4yLTQtMi43Yy0yLjIsMC40LTQuMiwwLjctNS45LDFjLTAuOS0wLjktMS41LTEuNS0yLjEtMi4xYy0xLjIsMC42LTUuOSwxLjEtNi44LDEuMmMtMi41LDAuMi00LjksMC42LTguMSwxYy0wLjIsMC40LTAuNywxLjMtMS4xLDJjLTItMC42LTMuNS0xLjEtNS4zLTEuNmMtMC42LDAuOC0xLjEsMS42LTIuMSwyLjljLTAuNy0xLjktMS4yLTMuMi0xLjctNC44Yy0xLDEuMi0xLjgsMi40LTIuMywzYy0xLjgsMC0zLDAtNCwwYy0wLjEtMS0wLjEtMS44LTAuMi0yLjNjLTIsMC4zLTQuMSwwLTUuNSwwLjljLTIuMywxLjMtNC44LDEuMS02LjcsMC41Yy0yLjMtMC44LTQuNi0xLjMtNi41LTAuM2MtMi4xLDEuMS00LjctMC41LTYuNCwxLjVjMCwwLjEtMC41LTAuMy0xLTAuNWMwLjQtMSwwLjktMS45LDEuMy0yLjljLTAuOS0wLjctMS42LTEuMi0yLjgtMi4xYy0xLjYsMy4xLTMsNS44LTQuNCw4LjVjLTEsMC0yLDAtMywwYy0wLjEtMC4zLTAuMi0wLjgtMC40LTAuOGMtMS44LTAuNC00LTAuMy01LjQtMS4zYy0xLjgtMS4zLTQuMywwLTUuOC0xLjlDMTAuOSw0NC4xLDUuNiw0Mi45LDAsNDEuN2MwLTguMSwwLTE2LjYsMC0yNS4yYzEtMC45LDIuMy0xLjcsMS44LTMuOGMtMC42LTAuNy0wLjYtMS41LTEuNS0yLjZDMS45LDguMSwyLjYsNiw0LjQsMy44YzEuMywwLjYsMi41LDEuMSwzLjcsMS42QzcuNSw4LDcuOCwxMC4yLDkuMywxMi4yYzAuNiwwLDEuMywwLDIuNCwwYzAuNy0wLjgsMS42LTIsMi43LTMuNGMwLjQsMS4xLDAuNiwxLjcsMC44LDIuMmMyLjYsMCw1LjEsMCw3LjksMGMwLTEuNCwwLTIuNSwwLTMuNWMxLTAuNCwxLjgtMC43LDIuOC0xLjJjMi4yLDEuOSw0LjYsMy45LDYuNyw1LjhjMS4yLDAsMi4xLDAsMi41LDBjMS4zLTEuNiwyLjMtMi43LDMuMy0zLjljMC41LDAuOSwwLjksMS42LDEuNiwyLjZjMS0xLjUsMS42LTIuNSwyLjMtMy41YzIuOSwwLDMtMC4xLDUuNSwxLjJjNC4xLDIuMiw4LjYsMi40LDEyLjcsMS4zYzMuMi0wLjgsNi4xLTAuMyw5LjItMC42YzMuMi0wLjQsNi4zLDAuMiw5LjQsMS41YzIuNywxLjEsNS41LDEsNy43LTAuOWMyLjctMi4zLDUuNC00LjQsOC42LTUuM2MxLjIsMC40LDIuMywwLjcsNCwxLjJjMC42LDEuNiwxLjQsMy40LDIuMiw1LjVjMC42LTEsMS4zLTIsMS43LTIuN2MxLjUtMC41LDIuOS0wLjksNC4xLTEuM2MwLjYsMS40LDEuMiwyLjcsMiw0LjRjMi42LTYuMiw4LTYuOSwxMy4yLTguNWMyLjEsMy40LDQuMiw2LjksNi42LDEwLjdjMS0xLjksMS42LTMuMywyLjMtNC42YzAuNywwLDEuNCwwLDIsMGMtMC4zLTAuMy0wLjYtMC42LTAuOS0xYzAuOC0wLjEsMS43LTAuMywyLjUtMC40Yy0wLjEtMC4yLTAuMy0wLjQtMC40LTAuNWMtMS41LDAtMi45LDAtNCwwYy0wLjgtMC43LTEuMy0xLjEtMS40LTEuMmMwLjQtMS44LDAuNy0zLjMsMS00LjdjMC45LDAsMS43LDAsMi40LDBjMC4yLDAuNywwLjQsMS4zLDAuNSwxLjZjMi4xLDAuNiwzLjksMS4xLDUuNSwxLjZjMC4yLDAuNywwLjUsMS4yLDAuNywxLjhjMS4yLTAuNSwyLjQtMC43LDMuMi0xLjRjMS40LTEuMiwyLjUtMi42LDMuOS00LjJjMC42LDIuNCwxLjEsNC4zLDEuNiw2LjNjLTIuNCwwLjEtNC4zLDAuMi02LjMsMC40YzAuNiwwLjcsMC45LDEsMS4xLDEuNWMwLjIsMC40LDAuMiwwLjksMC4zLDEuM2MxLjYtMC4xLDMsMC40LDQuMy0wLjljMC43LTAuNywyLTAuOCwzLTFjMC40LTAuMSwwLjksMC4yLDEuMiwwLjJjMC4yLDEuMSwwLjMsMS45LDAuNiwzLjRjMS4zLTEuMSwyLjItMS44LDMuMy0yLjdjMC44LDEuMSwxLjcsMi4yLDIuMSwyLjhjMy40LDEsMy44LTEuMyw0LjktMy40YzAuOSwxLjMsMS40LDIsMi4xLDMuMWMxLTAuOSwxLjgtMS43LDIuNi0yLjRjMC4zLDAuNywwLjcsMS40LDEsMi4xYzEuNC0wLjQsMi41LTEsMi40LTIuNmMxLjYsMC4xLDEuOC0xLjUsMi42LTIuN2MwLjQsMS4xLDAuNiwxLjcsMC43LDJjMi4xLTEuMiw0LjEtMi40LDYuMi0zLjdjMC4zLDAuMywwLjcsMC42LDEuMiwxYzAuNy0xLDEuMy0yLDEuOS0zYzEuNywwLDMuMywwLDUuMiwwYzAuNSwwLjksMS4xLDEuOCwxLjYsMi42YzUtMS42LDkuOC0wLjUsMTQuNSwxLjdjMC41LDEuNSwxLjEsMywxLjgsNS4yYzEuNy0zLjYsMy4yLTYuNiw0LjYtOS41YzIsMS42LDQsMC42LDUuOSwxYzIsMC40LDMuOSwwLjgsNiwxLjNjMCwxLjQsMCwyLjUsMCwzLjljMS41LTEuMSwyLjgtMiw0LTIuOWMwLjQtMC4yLDAuOS0wLjIsMS4yLTAuM2MwLjYsMS4xLDEuMiwyLDEuOCwzYzEuOSwwLDQsMC42LDUuNS0wLjFjMi45LTEuMyw1LjgtMC42LDktMWMwLjQsMC41LDAuOSwxLjIsMS41LDEuN2MwLjcsMC42LDEuNSwxLDIuOCwxLjljMC0yLjYsMC00LjUsMC02LjVjMS44LDAsMy4zLDAsNC41LDBjMi44LDEuNCwwLjgsNC4xLDIuMiw2LjJjMS44LTAuOCwzLjYtMS42LDUuMi0yLjNjMC4yLTEuNCwwLjQtMi4yLDAuNS0yLjljMy42LDAuNiw2LjgsMS40LDEwLjEsMS43YzIuMSwwLjIsNC4xLDAuMyw1LjgsMS43YzEuMiwxLDIuNiwxLjYsNC4xLDIuNWM1LjgtMS44LDEwLjYtNi43LDE2LjktNi4xYzEuOCwxLjMsMy4yLDIuMiw0LjYsMy4zYzEuNCwxLjEsMi42LDIuMyw0LjQsMy44YzAsMC4yLDAsMSwwLDEuOWMxLjgtMC44LDIuNC0yLjcsNC4zLTMuMWMxLjYtMC4zLDIuOS0xLjgsNC41LTIuOWMxLjIsMC4xLDIuNywwLjIsNC4zLDAuM2MtMC41LDEuMS0wLjgsMS45LTEuMywzLjFjMi0wLjksMy40LTEuNSw0LjctMi4xYzAuMywwLjgsMC41LDEuMywwLjgsMmMwLjktMC40LDEuNS0wLjcsMi4yLTEuMWMwLjIsMC42LDAuNCwxLjIsMC43LDEuOWMxLjgtMC4zLDMuNywwLjQsNS4zLTAuOGMwLjMsMC4zLDAuNiwwLjUsMC45LDAuOGMwLjctMSwxLjQtMi4xLDIuMS0zLjFjMC4yLDAsMC40LTAuMSwwLjUsMGMwLjUsMC4zLDEuMSwwLjcsMSwwLjZjMi45LTAuMyw1LjItMC41LDcuNS0wLjhjMC4yLDEuMywwLjQsMi4yLDAuNiwzLjRjMy01LjgsMTAuNS01LjksMTMuOC0zLjZjMC44LDEuMiwxLjUsMi4zLDIuMSwzLjFjMS41LDAsMi42LDAsMy44LDBjLTAuNy0xLjMtMS4zLTIuMy0xLjktMy40YzEuMS0wLjUsMi4yLTEuMSwzLjYtMS43YzAuMywxLjMsMC41LDIuMywwLjYsMi45YzAuOSwwLjUsMS40LDAuNywyLDFjLTAuNiwxLjEtMSwxLjktMS41LDNjMS40LDAuOSwyLjcsMS42LDQuMSwyLjRjMC43LTEuMSwxLjItMiwxLjgtMi45YzAuMiwxLjYsMCwzLjYtMC41LDQuOWMtMC4xLDAuMiwwLjIsMC42LDAuMywwLjljMC4xLDAuMSwwLjMsMC4yLDAuNCwwLjJjMC4zLDAsMC42LTAuMSwwLjktMC4yYzAuNi0yLjksMC42LTIuOSwzLjMtNC41Yy0wLjQtMS0wLjctMS45LTEuMy0zLjNjMS4xLDAsMS43LTAuMSwyLjQsMGMwLjYsMC4xLDEuMiwwLjMsMS44LDAuNGM0LjgsMC44LDkuNCw0LDE0LjcsMS4yYzEsMS4yLDEuOSwyLjQsMi43LDMuM2MyLjYsMC4yLDMuOS0wLjcsMy43LTMuM2MtMC42LTAuOC0xLjQtMS43LTIuMy0yLjhjMS43LTIuMiwzLjMtNC4xLDUtNi4yYzEuMywwLjYsMi4zLDEsMi44LDEuM2MwLjcsMi44LDEuMiw1LDEuNyw3YzMuMSwwLjksMy43LTIsNS42LTIuN2MwLjMsMC43LDAuNSwxLjMsMC42LDEuN2MyLjYsMCw1LjEsMCw3LjcsMGMwLTEuMywwLTIuNCwwLTMuNGMxLTAuNSwxLjgtMC45LDMtMS41YzIuMSwxLjksNC40LDQsNi42LDZjMSwwLDIsMCwyLjYsMGMxLjItMS41LDIuMi0yLjcsMy4xLTMuOWMwLjgsMC45LDEuMywxLjUsMS45LDIuMmMwLjktMS40LDEuNS0yLjQsMi4zLTMuN2MxLjgsMC42LDMuNiwwLjgsNSwxLjZjNC4xLDIuNCw4LjUsMi4yLDEyLjgsMS42YzYuNi0wLjksMTIuNS0xLjQsMTcuMiwwLjJjMi4zLDAuOCw0LjYsMS4yLDYuNiwwLjljNC0yLjUsNy42LTQuOCwxMC42LTYuOGMyLDAuNiwzLjIsMC45LDQuNSwxLjNjMC43LDEuOCwxLjUsMy42LDIuMyw1LjZjMC43LTEuMSwxLjItMiwxLjgtMi45YzEuNC0wLjQsMi44LTAuOSw0LjEtMS4yYzAuNiwxLjUsMS4xLDIuOCwxLjgsNC41YzIuNy02LjMsOC4yLTcuMSwxMy41LTguNWMyLDMuNCw0LDYuOCw2LjQsMTAuN2MwLjktMS45LDEuNi0zLjMsMi4xLTQuM2MxLjQtMC42LDIuNi0xLjIsNC44LTIuMWMtMy0wLjgtNS41LDAuNi02LjctMS40YzAuNC0xLjgsMC43LTMuMywxLTQuOWMwLjgsMCwxLjYsMCwyLjUsMGMwLjEsMC41LDAuMiwxLDAuMywxLjZjMS44LDAuNSwzLjgsMS4xLDUuNywxLjZjMC4zLDAuNiwwLjUsMS4zLDEsMi4zYzIuNi0yLDQuOC0zLjcsNy01LjRjMC41LDEuOSwwLjksMy43LDEuNSw1LjljLTIuMywwLTQuMywwLTYuMiwwYzAuNSwxLjEsMC45LDEuOSwxLjMsMi44YzIuNCwwLjYsNC4zLTAuMyw2LjEtMS43YzAuNS0wLjQsMS41LTAuMSwyLjMtMC4xYzAuMiwxLjIsMC40LDIuMSwwLjcsMy40YzEuMy0wLjksMi4yLTEuNiwzLjctMi43YzAuOSwxLDEuOSwyLjEsMywzLjNjMS45LDAuMiwyLjctMS4xLDMuMS0yLjdjMC0wLjIsMC42LTAuMiwxLjEtMC4zYzAuMiwwLjMsMC40LDAuNiwwLjcsMWMwLjMsMC40LDAuNiwwLjksMS40LDIuMWMwLjktMS4zLDEuNC0yLjEsMi0zYzAsMCwwLjIsMC4xLDAuMywwLjJjMC4yLDAuNiwwLjQsMS4yLDAuNiwxLjhjMS43LTAuOSwzLjctMi43LDUuMy00LjljMC4yLDAuNiwwLjUsMS4xLDAuNiwxLjZjMi4xLTEuMiw0LjItMi40LDYuMi0zLjdjMC40LDAuMywwLjcsMC42LDEuMiwxYzAuNi0xLjEsMS4yLTIsMS43LTIuOWMxLjgsMCwzLjYsMCw1LjQsMGMwLjYsMSwxLjEsMS45LDEuNCwyLjNjNS4yLTEsMTAtMC42LDE0LjcsMi4xYzAuNSwxLjMsMSwyLjksMS43LDUuMWMxLjctMy41LDMuMS02LjUsNC42LTkuNmMwLjQsMC4zLDAuNiwwLjcsMC44LDAuN2MyLjQsMC4yLDQuOSwwLjQsNi44LDAuNWMxLjcsMC41LDIuOCwwLjksNCwxLjNjMC4xLDEuMiwwLjMsMi40LDAuNCwzLjdjMS45LTEuMiwzLjQtMi4zLDUtMy4zYzAuOCwxLjMsMS41LDIuMywyLjIsMy40YzQuOC0wLjUsOS41LTEsMTMuNy0xLjRjMS43LDEuNCwyLjksMi41LDQuNyw0LjFjMC4xLTIuNCwwLjEtNCwwLjItNS42YzAtMC40LDAuMi0wLjksMC40LTEuM2MxLjUsMCwyLjgsMCw0LjEsMGMwLjUsMC41LDEsMSwxLjYsMS42YzAsMS4zLDAsMi43LDAsNC4yYzIuNSwwLjYsNC4xLTAuNiw1LjctMi4xYzAuMi0wLjksMC4zLTEuOCwwLjUtMi44YzQuNSwxLjIsOC44LDIuNCwxMy4yLDJjMi4zLDEuNCw0LjQsMi43LDcsNC4yYzIuMy0xLjEsNS0yLjQsNy42LTMuN2MzLTEuNSw2LTIuOSw5LjQtMi41YzIuOSwyLjIsNS43LDQuNSw4LjUsNi43YzAuMSwwLjgsMC4yLDEuNSwwLjMsMmMyLjktMiw1LjctMy44LDguMy01LjZjMS41LDAsMywwLDQuNiwwYy0wLjEsMC43LTAuMiwxLjEtMC40LDEuNmMtMC4xLDAuMy0wLjQsMC42LTEuNCwxLjljMi42LTEuMiw0LTEuOCw1LjQtMi41YzAuMiwwLjcsMC40LDEuMywwLjcsMi4xYzAuOC0wLjUsMS41LTAuOCwyLjItMS4yYzAuMiwwLjYsMC40LDEuMSwwLjYsMS43YzIuMiwxLjEsNC4zLTEsNi42LDBjMC42LTEsMS4zLTIsMi0zYzAuOSwwLjUsMS42LDAuOSwyLjIsMS4zYzIuMy0xLjYsNC42LTEuMSw3LjEtMC45YzAsMS4xLDAsMS45LDAsMi43YzEuMi0zLDMuNi0zLjcsNi40LTMuOWMyLjctMi43LDUsMC42LDcuMywwLjJjMC45LDEuNSwxLjcsMi43LDIuMywzLjdjMS40LDAsMi41LDAsMy43LDBjLTAuNi0xLjMtMS4yLTIuNC0xLjgtMy42YzEuMy0wLjUsMi40LTEsMy42LTEuNWMwLjIsMS4zLDAuMywyLjIsMC41LDIuOWMwLjgsMC4zLDEuMywwLjUsMi4xLDAuOGMtMC41LDEuMS0wLjksMS45LTEuNSwzYzEuMywwLjksMi42LDEuNywzLjksMi41YzAuNy0xLDEuMy0yLDEuOS0yLjljMC4yLDAuMSwwLjQsMC4yLDAuNiwwLjNjLTAuMywxLjgtMC42LDMuNi0xLDUuNWMwLjUsMC4xLDAuOSwwLjEsMS40LDAuMmMwLjQtMS4xLDAuNS0yLjMsMS4xLTMuMWMwLjYtMC44LDEuNi0xLjIsMi41LTEuN2MtMC41LTEuMS0wLjktMS45LTEuMy0yLjljMy4xLTEsNS41LDAuNyw4LjEsMS4xYzEuOCwwLjMsMy41LDEuNCw1LjMsMS41YzEuNywwLjEsMy40LTAuNiw1LjEtMC45YzEuNywwLjgsMi4yLDMuNCw0LjcsM2MwLDguNywwLDE3LjMsMCwyNmMtMi4zLDAtNC42LDAtNi43LDBjLTAuMywwLjktMC41LDEuNC0wLjcsMmMtMC41LTAuNC0wLjgtMC43LTEuNC0xLjFjLTAuMiwxLjEtMC4zLDItMC40LDIuN2MtMC42LTAuNi0xLjMtMS4zLTEuOC0xLjhjLTMsMC4yLTUuNSwwLTcuOCwwLjVjLTUuMSwxLjItNy4xLDAuNS05LjUtNC4xYy0yLjcsMS01LjIsMS4xLTcuOSwwLjFjLTAuNy0wLjMtMS42LTAuNS0yLjMtMC4zYy0xLjUsMC41LTIuOCwxLjMtNC4yLDEuOWMtMC4zLDAuMS0wLjktMC4yLTEuNC0wLjNjMC40LTEuMiwwLjgtMi4zLDEuNS00LjRjLTMuNywyLjMtNi41LDMuOS05LjYsNS45Yy00LjctMC40LTguMy0zLjktMTIuOC02LjJjLTEuOCwwLTMuOCwwLTUuMywwYy0wLjgtMS4xLTEuNS0yLTIuNy0zLjZjMCwyLjEsMCwzLjIsMCw0LjNjLTMuOCwxLjYtNy42LDIuNC0xMC44LDIuM2MtMS4xLTEuMy0yLjMtMi43LTMuNi00LjNjLTEsMS44LTAuNCw0LjItMy40LDQuNWMtMi45LTEuMi02LjMtMi43LTkuOS00LjJjLTEuNiwyLTMuMiw0LTUsNi4zYy00LTEuNS04LDEuOC0xMi4xLDAuMmMtMC41LDAuMy0wLjksMC41LTEuMywwLjdjLTEuNC0xLTIuNy0xLjgtMy42LTIuNWMtMC45LTIuOC0xLjctNS4yLTIuNS03LjljLTEuMiwxLjItMiwyLTMsM2MwLDEuMywwLDIuOCwwLDQuMWMtNSwwLjUtOS43LDItMTQuNiwwLjljLTAuMi0wLjktMC4zLTEuOC0wLjYtM2MtMS4xLDAuNS0xLjksMC45LTIuNiwxLjNjLTEuNy0wLjYtMy4yLTEuMi00LjktMS44Yy0wLjUsMC45LTEuMSwxLjgtMS43LDIuOGMtMC40LTAuOS0wLjktMS44LTEuMi0yLjRjMC4yLTAuNywwLjMtMS4xLDAuNy0yLjFjLTIuNywxLjQtNC43LDIuNC02LjcsMy40Yy0xLjgtMy4zLTQuOC02LjEtNi4xLTUuNmMtMC40LDAuNC0wLjksMC45LTEuMywxLjVjMC4zLDAuNywwLjYsMS4zLDEuMSwyLjNjLTAuOC0wLjEtMS4zLTAuMS0xLjgtMC4xYy0wLjItMS4yLTAuMy0yLTAuNi0zLjVjLTEuNCwxLjEtMi4zLDEuOC0zLjMsMi41Yy0wLjMtMC44LTAuNS0xLjMtMC44LTIuMmMtMS4xLDEuNi0yLjEsMi45LTMuMSw0LjRjLTIuMy0wLjgtNC43LTAuOC01LjYtMy44Yy0wLjUtMS40LTIuMS0yLjMtMy4xLTMuNGMtMC44LDEuMS0xLjUsMi4xLTIuMiwzLjFjLTEuOS0wLjUtMy41LTAuOS01LjUtMS40YzAuNSwxLDAuNywxLjQsMSwyYy0wLjgsMC41LTEuNiwwLjktMi40LDEuM2MtMC40LTEtMC43LTEuNi0xLjEtMi40Yy0xLjUsMC44LTIuNywxLjQtMy44LDJjLTAuNywxLjYtMS4yLDMtMS44LDQuM2MtMS40LTEuOC0yLjYtMy4zLTMuOC00LjhjLTAuMS0wLjctMC4xLTEuNS0wLjItMi4xYy0xLjgsMC0zLjMsMC00LDBjLTMuMSwxLjktNS42LDMuNC04LjMsNWMtMC40LTAuOC0wLjctMS41LTEuMy0yLjZjLTEuNCwwLjctMi43LDEuNC00LjEsMi4xYy0wLjMtMC4yLTAuOS0wLjUtMS42LTFjLTEsMS40LTEuOSwyLjctMi44LDMuOWMtMC4xLDAuMS0wLjQsMC4xLTAuNywwLjFjLTAuMi0xLTAuMy0xLjgtMC41LTMuMWMtMC41LDEuMS0wLjgsMS43LTEuNiwzLjNjMC0yLjIsMC0zLjUsMC00LjdjLTAuMywwLjItMC42LDAuMy0wLjgsMC41Yy0xLjEtMS4yLTIuMy0yLjMtMy42LTMuNmMtMy4zLDEuMi0yLjksNS40LTQuNyw3LjZjLTQuOSwwLjUtOS4zLDAuOS0xMy44LDEuNGMtMC4xLTEuMi0wLjItMi0wLjMtMi45Yy0xLjUsMC0yLjksMC00LjIsMGMtMS41LDAuNy0yLjksMS4zLTQuMiwyYy0wLjMtMC45LTAuNi0xLjUtMC45LTIuNGMtNi43LDEtMTIuNSw0LjQtMTkuMSw2LjZjLTAuOS0xLjItMS45LTIuNC0yLjYtMy40Yy0yLjksMS45LTUuNSwyLjktOC43LDEuMmMtMC41LDAuOS0xLjEsMS45LTEuNiwyLjhjLTAuNywwLTEuMywwLTIuMiwwYy0wLjYtMC45LTEuMy0yLTEuOC0yLjhjLTIuMSwwLjMtNC4xLDAuNy01LjgsMC45Yy0wLjktMC45LTEuNS0xLjUtMi4xLTIuMWMtMS4zLDAuNi01LjgsMS4xLTYuOCwxLjJjLTIuNSwwLjItNC45LDAuNi04LjEsMWMtMC4yLDAuNC0wLjYsMS4zLTEsMmMtMi0wLjYtMy41LTEuMS01LjMtMS42Yy0wLjYsMC44LTEuMSwxLjYtMiwzYy0wLjctMi0xLjItMy4zLTEuNy00LjdjLTEsMS4xLTEuOSwyLjItMi40LDIuOGMtMS45LDAtMi45LDAtNCwwYy0wLjEtMS0wLjEtMS44LTAuMi0yLjRjLTIsMC4zLTQuMSwwLTUuNiwwLjljLTIuMywxLjMtNC44LDEuMS02LjcsMC41Yy0yLjMtMC44LTQuNS0xLjMtNi41LTAuM2MtMi4xLDEuMS00LjctMC41LTYuNCwxLjVjMCwwLjEtMC41LTAuMy0xLTAuNWMwLjQtMC45LDAuOS0xLjksMS4zLTIuOWMtMC45LTAuNy0xLjYtMS4yLTIuOC0yLjFDNDMzLjgsNDMuOCw0MzIuNCw0Ni41LDQzMC45LDQ5LjJ6Ii8+DQoJCTwvZz4NCgk8L2c+DQo8L3N2Zz4=) center repeat-x;
    background-size: auto 0.5em;
    color: rgba(0,0,0,0.5);
    text-decoration: none;
}

.open-book sup {
    color: #cc0000;
    font-family: 'Rock Salt', cursive;
    left: 0;
    margin-top: -1em!important;
    max-width: 100%!important;
    position: absolute;
    text-align: center;
    width: 100%;
}

.open-book mark {
    background: linear-gradient(to bottom, rgba(222,255,0,1) 0%,rgba(222,255,0,0.5) 60%,rgba(222,255,0,1) 100%);
}

.open-book mark.pink {
    background: linear-gradient(to bottom, rgba(255,69,190,1) 0%,rgba(255,107,203,0.5) 60%,rgba(255,107,203,1) 100%);
}

.open-book mark.blue {
    background: linear-gradient(to bottom, rgba(73,179,255,1) 0%,rgba(107,193,255,0.5) 60%,rgba(107,193,255,1) 100%);
}

.open-book mark.green {
    background: linear-gradient(to bottom, rgba(67,226,15,1) 0%,rgba(39,229,54,0.5) 60%,rgba(39,229,54,1) 100%);
}

.open-book mark.orange {
    background: linear-gradient(to bottom, rgba(255,134,9,1) 0%,rgba(255,177,34,0.5) 60%,rgba(255,177,34,1) 100%);
}

.open-book hr {
    background-color: #000;
    border: 0;
    height: 2px;
    margin: 1em 0;
}

.open-book dl {
    border: solid 0 #ccc;
    border-width: 0.0625em 0;
    break-inside: avoid-column;
    margin: 1em auto;
    padding: 1em 0;
}



/*** MEDIA QUERIES ***/
@media only screen and ( min-width: 50em ) {

    .open-book {
        margin: 1em;
        position: relative;
    }

    .open-book:before {
        background-color: #8B4513;
        border-radius: 0.25em;
        bottom: -1em;
        content: '';
        left: -1em;
        position: absolute;
        right: -1em;
        top: -1em;
        z-index: -1;
    }

    .open-book:after {
        background: linear-gradient(to right, transparent 0%,rgba(0,0,0,0.2) 46%,rgba(0,0,0,0.5) 49%,rgba(0,0,0,0.6) 50%,rgba(0,0,0,0.5) 51%,rgba(0,0,0,0.2) 52%,transparent 100%);
        bottom: -1em;
        content: '';
        left: 50%;
        position: absolute;
        top: -1em;
        transform: translate(-50%,0);
        width: 4em;
        z-index: 1;
    }

    .open-book > * {
        column-count: 2;
        column-gap: 6em;
        position: relative;
        z-index: 1;
    }

    /* Header/Footer */
    .open-book header:before,
    .open-book header:after,
    .open-book footer:before,
    .open-book footer:after {
        background: #fff;
        border-radius: 25%;
        content: '';
        height: 2em;
        position: absolute;
        z-index: -1;
        width: calc(50% + 2em);
    }

    .open-book header:before,
    .open-book footer:before,
    .open-book footer:after {
        border-top-left-radius: 0;
    }

    .open-book header:after,
    .open-book footer:before,
    .open-book footer:after {
        border-top-right-radius: 0;
    }

    .open-book header:before,
    .open-book header:after,
    .open-book footer:after {
        border-bottom-right-radius: 0;
    }

    .open-book header:before,
    .open-book header:after,
    .open-book footer:before {
        border-bottom-left-radius: 0;
    }

    .open-book header:before,
    .open-book header:after {
        top: -2.65em;
    }

    .open-book header:before,
    .open-book footer:before {
        right: 50%;
    }

    .open-book header:before {
        transform: rotate(-2deg);
    }

    .open-book header:after,
    .open-book footer:after {
        left: 50%;
    }

    .open-book header:after {
        transform: rotate(2deg);
    }

    .open-book footer:before,
    .open-book footer:after {
        bottom: -2.65em;
    }

    .open-book footer:before {
        transform: rotate(2deg);
    }

    .open-book footer:after {
        transform: rotate(-2deg);
    }

    .open-book header > *:last-child,
    .open-book footer > *:last-child {
        text-align: right;
    }

    .open-book footer #page-numbers {
        display: block;
    }

    /* Chapter Title */
    .open-book .chapter-title {
        font-size: 3em;
    }

    .open-book .chapter-title:before,
    .open-book .chapter-title:after {
        height: 0.125em;
    }

    /* Body Copy */
    .open-book article p {
        text-indent: 3em;
    }

    .open-book article > ul,
    .open-book article > ol {
        padding-left: 4em;
    }

}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</style>
</head>

<body>
<!-- START of modified code -->


    <nav class="navbar navbar-default navbar-transparent navbar-fixed-top" color-on-scroll="200">
        <!-- if you want to keep the navbar hidden you can add this class to the navbar "navbar-burger"-->
        <div class="container">
            <div class="navbar-header">
                <button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar bar1"></span>
                    <span class="icon-bar bar2"></span>
                    <span class="icon-bar bar3"></span>
                </button>
                <a href="http://www.creative-tim.com" class="navbar-brand" style="margin-top:17px; left:30px;">
                    Name of App - Find a Tutor
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right navbar-uppercase" style="margin-top:7px; left:30px; height:0px;">
                    <li class="dropdown" style="padding-right:20px;">
                        <a href="#gaia" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-share-alt"></i> Resources
                        </a>
                        <ul class="dropdown-menu dropdown-danger">
                            <li>
                                <a href="#"><i class="fa fa-facebook-square"></i> Facebook</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i> Twitter</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i> Instagram</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown" style="padding-right:20px;">
                        <a href="#gaia" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-share-alt"></i> About
                        </a>
                        <ul class="dropdown-menu dropdown-danger">
                            <li>
                                <a href="#"><i class="fa fa-facebook-square"></i> Facebook</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i> Twitter</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i> Instagram</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown" style="padding-right:20px;">
                        <a href="#gaia" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-share-alt"></i> Share
                        </a>
                        <ul class="dropdown-menu dropdown-danger">
                            <li>
                                <a href="#"><i class="fa fa-facebook-square"></i> Facebook</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i> Twitter</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i> Instagram</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown" style="padding-right:35px;margin-top:-13px;">
                        <a href="#gaia" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="login-form">
                            <div class="avatar avatar-danger">
	                            <?php
	                                if ($_SESSION['pictureCheck'] === "True"){
	                                    echo '<img class="img-circle" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['profilePic'] ).'"/>';
	                                }
	                                elseif ($_SESSION['pictureCheck'] === "False"){
	                                    echo '<img class="img-circle" src="headshot.jpg"/>';
	                                }
	                            ?>
	                        </div>
        	            </div>
        	            </a>
        	        </li>
        	        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo $_SESSION['username']; ?><span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-danger">
                            <li>
                                <a href="logout.php">Sign Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>

    <div class="section section-header">
        <div class="parallax filter filter-color-blue" style="height:2000px;">
            <div class="section" id="login">`
            <div class="container">

            
            <!--<div class="login-form" style="background:red;">
            <div class="page-header">
                <h1>Hi, <b><?php echo $_SESSION['username']; ?></b>. You are a <b><?php echo $_SESSION['usertype']; ?></b>. Welcome to the site.</h1>
            </div>
            <p><a href="tutorSearch.php" class="btn btn-danger">Find a tutor</a></p>
            <p><a href="manageAccount.php" class="btn btn-danger">Manage my Account</a></p>
            <p><a href="tutorInbox.php" class="btn btn-danger">Inbox</a></p>
            <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
            <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:50%;">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" value="Submit" style="width:40%; float: left; position: relative;">Register</button>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" value="Submit" style="width:40%; float: right; background:#008b9c; position: relative; margin-top:0px;">Return</button>
                    </div>
             </div>-->
             <div id="wrapper" style="margin-top:200px;">
    <div id="container">

        <section class="open-book">
            <header>
                <h1>Book Layout</h1>
                <h6>Erin E. Sullivan</h6>
            </header>
            <article>
                <h2 class="chapter-title">Waiting on projects</h2>
                <p>
                    Sublime Text 2 was opened and a new document was created. "I love this time of year," Erin gleefully thought to herself.
                </p>
                <p>
                    The "time of year" that is being referenced relates to Erin's job when the pile of projects temporarily slow down. This doesn't happen to just her. The reduction of work happens to many, but at various times throughout the year, depending on their position. She could submit to boredom and brainlessly surf the Internet, but this particular developer decided to take advantage of the situation.
                </p>
                <p>
                    Erin brainstorms on ideas that are both fun and can strengthen her development skills. After all, however she spends her free time at work should be used in a way that becomes helpful for future projects.
                </p>
                <p>
                    She already made quite the effort into fine-tuning her skills with Flexbox, creating functional and accessible code for an <a href="https://codepen.io/erinesullivan/pen/LLoXoL">organizational chart</a> and a <a href="https://codepen.io/erinesullivan/pen/MvOdOE">process chart</a>. For Erin's next personal project, she wanted something different. Something with multiple (yet possibly useful) features.
                </p>
                <p>
                    To <a href="https://codepen.io/">CodePen.io</a> she went, but not brainlessly! Erin "Oohed" and "Ahhed" at the recently picked pens. She envied the skills of those using compilers she has yet to dabble in. Then she put together a list of what she would like to achieve.
                </p>
                <p>
                    Erin chuckled to herself, "This sounds crazy, but what if I develop a section of text that looks like a book?"
                </p>
                <p>
                    She paused, realizing that what she was about to do was a trend years ago. This severely increased the chance of her project being mocked after launch. What was the specific trend Erin remembered? Skeuomorphism.
                </p>
                 <p>
                    She paused, realizing that what she was about to do was a trend years ago. This severely increased the chance of her project being mocked after launch. What was the specific trend Erin remembered? Skeuomorphism.
                </p>
                 <p>
                    She paused, realizing that what she was about to do was a trend years ago. This severely increased the chance of her project being mocked after launch. What was the specific trend Erin remembered? Skeuomorphism.
                </p>
                 <p>
                    She paused, realizing that what she was about to do was a trend years ago. This severely increased the chance of her project being mocked after launch. What was the specific trend Erin remembered? Skeuomorphism.
                </p>
                <dl>
                    <dt><strong>skeu&bull;o&bull;morph</strong></dt>
                    <dd>
                        <em>noun</em><br>
                        an object or feature that imitates the design of a similar artifact made from another material.
                    </dd>
                </dl>
                <p>
                    Outside of skeuomorphism, the idea actually was not very silly. Erin always had an appreciation towards print work. The thought of mimicking similar designs onto a web interface has always fascinated her. So, why not start with the classic print design of a novel?
                </p>
                <p>
                    She began to jot down a list of elements that are typically in a novel:
                </p>
                <ul>
                    <li>Serif typefaces</li>
                    <li>
                        Header area with the title of the book on the left, and the author of said book on the right. <em>Erin is aware that content within the header of the same page as a chapter title does not appear, but she made an exception</em>.
                    </li>
                    <li>An adorned chapter title</li>
                    <li>A dropcap for the first letter of the first paragraph of the chapter</li>
                    <li>Indented paragraphs</li>
                    <li>Page numbers</li>
                </ul>
                <p>
                    She was then picturing herself making marks on a novel like she used to in school. In her true fashion, she got carried away with "What ifs." 
                </p>
                <ul>
                    <li>
                        "What if highlighting the text actually looked <mark>like a highlighter</mark>?"
                        <ul>
                            <li>"What if I wanted it to be <mark class="pink">pink</mark>?"</li>
                            <li>"<mark class="blue">Blue</mark>?"</li>
                            <li>"<mark class="green">Green</mark>?"</li>
                            <li>"<mark class="orange">Orange</mark>?"</li>
                        </ul>
                    </li>
                    <li>"What if I found <s>a typo</s><sup>an error in the content</sup> and wanted to make a correction?"</li>
                    <li>"What if I was viewing this on mobile&mdash;"</li>
                </ul>
                <p>
                    The true obstacle showed its form. Responsiveness. How on Earth will she make this work?
                </p>
                <p>
                    Erin pulled out her notepad and started sketching. First she began to illustrate the wireframe of the book in its entirety. Then she recorded some notes on how each element would break down as the screen size got smaller. After several minutes, the blueprint was complete. She came to the conclusion that mobile viewing must stay minimal. The pages go away, which makes the page numbers no longer have a function so they must go away, and if those go away then there is no need for a cover since it is used to help hold and protect pages.
                </p>
                <p>
                    She looks back at the blinking cursor of her blank canvas in Sublime Text 2. Doubt begins to linger in the back of her mind with the thought of her new code never being used and her time spent ends up being a waste. Her fingers were typing anyway.
                </p>
                <p>
                    Erin smirked, "Well at least I think it's worth a try."
                </p>
            </article>
            <footer>
                <ol id="page-numbers">
                    <li>1</li>
                    <li>2</li>
                </ol>
            </footer>
        </section>

    </div>
</div>
            </div>
            

            </div>
        </div>
    </div>
<!-- END of modified code -->

    
        

    <footer class="footer footer-big footer-color-black" data-color="black">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="info">
                        <h5 class="title">Company</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="#">Home</a></li>
                                <li>
                                    <a href="#">Find offers</a>
                                </li>
                                <li>
                                    <a href="#">Discover Projects</a>
                                </li>
                                <li>
                                    <a href="#">Our Portfolio</a>
                                </li>
                                <li>
                                    <a href="#">About Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-1 col-sm-3">
                    <div class="info">
                        <h5 class="title"> Help and Support</h5>
                         <nav>
                            <ul>
                                <li>
                                    <a href="#">Contact Us</a>
                                </li>
                                <li>
                                    <a href="#">How it works</a>
                                </li>
                                <li>
                                    <a href="#">Terms &amp; Conditions</a>
                                </li>
                                <li>
                                    <a href="#">Company Policy</a>
                                </li>
                                <li>
                                    <a href="#">Money Back</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="info">
                        <h5 class="title">Latest News</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i> <b>Get Shit Done</b> The best kit in the market is here, just give it a try and let us...
                                        <hr class="hr-small">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i> We've just been featured on <b> Awwwards Website</b>! Thank you everybody for...
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-2 col-md-offset-1 col-sm-3">
                    <div class="info">
                        <h5 class="title">Follow us on</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="#" class="btn btn-social btn-facebook btn-simple">
                                        <i class="fa fa-facebook-square"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-dribbble btn-simple">
                                        <i class="fa fa-dribbble"></i> Dribbble
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-twitter btn-simple">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-reddit btn-simple">
                                        <i class="fa fa-google-plus-square"></i> Google+
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <hr>
            <div class="copyright">
                 © <script> document.write(new Date().getFullYear()) </script> Creative Tim, made with love
            </div>
        </div>
    </footer>

</body>

<!--   core js files    -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.js" type="text/javascript"></script>

<!--  js library for devices recognition -->
<script type="text/javascript" src="assets/js/modernizr.js"></script>

<!--  script for google maps   -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!--   file where we handle all the script from the Gaia - Bootstrap Template   -->
<script type="text/javascript" src="assets/js/gaia.js"></script>

</html>