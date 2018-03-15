<script>function copyValue() {
    var dropboxvalue = document.getElementById('mydropbox').value;
    document.getElementById('test').value = dropboxvalue;
}</script>
<?php
// Initialize the session
session_start();
/* Code below is based on aspects from https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.phphttps://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php */
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: LandingPage.php#login");
  exit;
}/* END */

if($_SESSION['usertype'] !== 'Student'){
  header("location: ".$_SESSION['usertype']."sHome.php");
}

//DB details
        /*$dbHost     = '127.0.0.1';
        $dbUsername = 'cianmc85';
        $dbPassword = '';
        $dbName     = 'project_db';*/
        
        $dbHost     = 'eu-cdbr-west-02.cleardb.net';
        $dbUsername = 'bdff3cc89b8df5';
        $dbPassword = '25912b2f';
        $dbName     = 'heroku_6a6bf0a23aababd';
        
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

    /*$host = "127.0.0.1";
	$user = "cianmc85";
	$pass = "";
	$db = "project_db";
	$port = 3306;*/

	$host = "eu-cdbr-west-02.cleardb.net";
	$user = "bdff3cc89b8df5";
	$pass = "25912b2f";
	$db = "heroku_6a6bf0a23aababd";
	
	// Create connection
	$conn = new mysqli($host, $user, $pass, $db);
	// Check connection

	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}
	
	if (isset($_POST["mybutton"]))
   {
       $_SESSION['CVIDtoView'] = $_POST["mybutton"];
       header("location: CVViewer.php");
   }
		
	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Tutor Search</title>
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
	
	
	




















@import "compass/css3";

/*
	A. Mini Reset 
*/
*, *:after, *:before { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }

* {
  margin: 0;
  padding: 0;
}

::before,
::after {
	content: "";
}

html,
body {
	height: 100%;
	-webkit-font-smoothing: subpixel-antialiased;
}

html {
	font-size: 100%;
}

body {
	background: #ecf0f1;
	color: #34495e;
	font-family: 'Lato', 'Arial', sans-serif;
	font-weight: 400;
	line-height: 1.2;
}

ul {
	margin: 0;
	padding: 0;
	list-style: none;
}

a {
	color: #2c3e50;
	text-decoration: none;
}

.btn {
	display: inline-block;
	text-transform: uppercase;
	border: 2px solid #2c3e50;
	margin-top: 100px; 
	font-size: 0.7em;
	font-weight: 700;
	padding: 0.1em 0.4em;
	text-align: center;
	-webkit-transition: color 0.3s, border-color 0.3s;
	-moz-transition: color 0.3s, border-color 0.3s;
	transition: color 0.3s, border-color 0.3s;
}

.btn:hover {
	border-color: #16a085;
	color: white;
}

/* basic grid, only for this demo */

.align {
	clear: both;
	margin: 90px auto 20px;
	width: 100%;
	max-width: 100%;
	text-align: center;
}

.align > li {
	width: 150px;
	min-height: 0px;
	display: inline-block;
	margin: 30px 20px 30px 30px;
	padding: 0 0 0 0px;
	vertical-align: top;
}

/* ///////////////////////////////////////////////////

HARDCOVER
Table of Contents

1. container
2. background & color
3. opening cover, back cover and pages
4. position, transform y transition
5. events
6. Bonus
	- Cover design
	- Ribbon
	- Figcaption
7. mini-reset

/////////////////////////////////////////////////////*/

/*
	1. container
*/

.book {
	position: relative;
	width: 160px; 
	height: 220px;
	-webkit-perspective: 1000px;
	-moz-perspective: 1000px;
	perspective: 1000px;
	-webkit-transform-style: preserve-3d;
	-moz-transform-style: preserve-3d;
	transform-style: preserve-3d;
}

/*
	2. background & color
*/

/* HARDCOVER FRONT */
.hardcover_front li:first-child {
	background-color: #eee;
	-webkit-backface-visibility: hidden;
	-moz-backface-visibility: hidden;
	backface-visibility: hidden;
}

/* reverse */
.hardcover_front li:last-child {
	background: #fffbec;
}

/* HARDCOVER BACK */
.hardcover_back li:first-child {
	background: #fffbec;
}

/* reverse */
.hardcover_back li:last-child {
	background: #fffbec;
}

.book_spine li:first-child {
	background: #eee;
}
.book_spine li:last-child {
	background: #333;
}

/* thickness of cover */

.hardcover_front li:first-child:after,
.hardcover_front li:first-child:before,
.hardcover_front li:last-child:after,
.hardcover_front li:last-child:before,
.hardcover_back li:first-child:after,
.hardcover_back li:first-child:before,
.hardcover_back li:last-child:after,
.hardcover_back li:last-child:before,
.book_spine li:first-child:after,
.book_spine li:first-child:before,
.book_spine li:last-child:after,
.book_spine li:last-child:before {
	background: #999;
}

/* page */

.page > li {
	background: -webkit-linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	background: -moz-linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	background: -ms-linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	background: linear-gradient(left, #e1ddd8 0%, #fffbf6 100%);
	box-shadow: inset 0px -1px 2px rgba(50, 50, 50, 0.1), inset -1px 0px 1px rgba(150, 150, 150, 0.2);
	border-radius: 0px 5px 5px 0px;
}

/*
	3. opening cover, back cover and pages
*/

.hardcover_front {
	-webkit-transform: rotateY(-34deg) translateZ(8px);
	-moz-transform: rotateY(-34deg) translateZ(8px);
	transform: rotateY(-34deg) translateZ(8px);
	z-index: 100;
}

.hardcover_back {
	-webkit-transform: rotateY(-15deg) translateZ(-8px);
	-moz-transform: rotateY(-15deg) translateZ(-8px);
	transform: rotateY(-15deg) translateZ(-8px);
}

.page li:nth-child(1) {
	-webkit-transform: rotateY(-28deg);
	-moz-transform: rotateY(-28deg);
	transform: rotateY(-28deg);
}

.page li:nth-child(2) {
	-webkit-transform: rotateY(-30deg);
	-moz-transform: rotateY(-30deg);
	transform: rotateY(-30deg);
}

.page li:nth-child(3) {
	-webkit-transform: rotateY(-32deg);
	-moz-transform: rotateY(-32deg);
	transform: rotateY(-32deg);
}

.page li:nth-child(4) {
	-webkit-transform: rotateY(-34deg);
	-moz-transform: rotateY(-34deg);
	transform: rotateY(-34deg);
}

.page li:nth-child(5) {
	-webkit-transform: rotateY(-36deg);
	-moz-transform: rotateY(-36deg);
	transform: rotateY(-36deg);
}

/*
	4. position, transform & transition
*/

.hardcover_front,
.hardcover_back,
.book_spine,
.hardcover_front li,
.hardcover_back li,
.book_spine li {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	-webkit-transform-style: preserve-3d;
	-moz-transform-style: preserve-3d;
	transform-style: preserve-3d;
}

.hardcover_front,
.hardcover_back {
	-webkit-transform-origin: 0% 100%;
	-moz-transform-origin: 0% 100%;
	transform-origin: 0% 100%;
}

.hardcover_front {
	-webkit-transition: all 0.8s ease, z-index 0.6s;
	-moz-transition: all 0.8s ease, z-index 0.6s;
	transition: all 0.8s ease, z-index 0.6s;
}

/* HARDCOVER front */
.hardcover_front li:first-child {
	cursor: default;
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
	-webkit-transform: translateZ(2px);
	-moz-transform: translateZ(2px);
	transform: translateZ(2px);
}

.hardcover_front li:last-child {
	-webkit-transform: rotateY(180deg) translateZ(2px);
	-moz-transform: rotateY(180deg) translateZ(2px);
	transform: rotateY(180deg) translateZ(2px);
}

/* HARDCOVER back */
.hardcover_back li:first-child {
	-webkit-transform: translateZ(2px);
	-moz-transform: translateZ(2px);
	transform: translateZ(2px);
}

.hardcover_back li:last-child {
	-webkit-transform: translateZ(-2px);
	-moz-transform: translateZ(-2px);
	transform: translateZ(-2px);
}

/* thickness of cover */
.hardcover_front li:first-child:after,
.hardcover_front li:first-child:before,
.hardcover_front li:last-child:after,
.hardcover_front li:last-child:before,
.hardcover_back li:first-child:after,
.hardcover_back li:first-child:before,
.hardcover_back li:last-child:after,
.hardcover_back li:last-child:before,
.book_spine li:first-child:after,
.book_spine li:first-child:before,
.book_spine li:last-child:after,
.book_spine li:last-child:before {
	position: absolute;
	top: 0;
	left: 0;
}

/* HARDCOVER front */
.hardcover_front li:first-child:after,
.hardcover_front li:first-child:before {
	width: 4px;
	height: 100%;
}

.hardcover_front li:first-child:after {
	-webkit-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	-moz-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	transform: rotateY(90deg) translateZ(-2px) translateX(2px);
}

.hardcover_front li:first-child:before {
	-webkit-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	-moz-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	transform: rotateY(90deg) translateZ(158px) translateX(2px);
}

.hardcover_front li:last-child:after,
.hardcover_front li:last-child:before {
	width: 4px;
	height: 160px;
}

.hardcover_front li:last-child:after {
	-webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(-2px) translateY(-78px);
	-moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(-2px) translateY(-78px);
	transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(-2px) translateY(-78px);
}
.hardcover_front li:last-child:before {
	box-shadow: 0px 0px 30px 5px #333;
	-webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(-2px) translateY(-78px);
	-moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(-2px) translateY(-78px);
	transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(-2px) translateY(-78px);
}

/* thickness of cover */

.hardcover_back li:first-child:after,
.hardcover_back li:first-child:before {
	width: 4px;
	height: 100%;
}

.hardcover_back li:first-child:after {
	-webkit-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	-moz-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	transform: rotateY(90deg) translateZ(-2px) translateX(2px);
}
.hardcover_back li:first-child:before {
	-webkit-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	-moz-transform: rotateY(90deg) translateZ(158px) translateX(2px);
	transform: rotateY(90deg) translateZ(158px) translateX(2px);
}

.hardcover_back li:last-child:after,
.hardcover_back li:last-child:before {
	width: 4px;
	height: 160px;
}

.hardcover_back li:last-child:after {
	-webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(2px) translateY(-78px);
	-moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(2px) translateY(-78px);
	transform: rotateX(90deg) rotateZ(90deg) translateZ(80px) translateX(2px) translateY(-78px);
}

.hardcover_back li:last-child:before {
	box-shadow: 10px -1px 80px 20px #666;
	-webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(2px) translateY(-78px);
	-moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(2px) translateY(-78px);
	transform: rotateX(90deg) rotateZ(90deg) translateZ(-140px) translateX(2px) translateY(-78px);
}

/* BOOK SPINE */
.book_spine {
	-webkit-transform: rotateY(60deg) translateX(-5px) translateZ(-12px);
	-moz-transform: rotateY(60deg) translateX(-5px) translateZ(-12px);
	transform: rotateY(60deg) translateX(-5px) translateZ(-12px);
	width: 16px;
	z-index: 0;
}

.book_spine li:first-child {
	-webkit-transform: translateZ(2px);
	-moz-transform: translateZ(2px);
	transform: translateZ(2px);
}

.book_spine li:last-child {
	-webkit-transform: translateZ(-2px);
	-moz-transform: translateZ(-2px);
	transform: translateZ(-2px);
}

/* thickness of book spine */
.book_spine li:first-child:after,
.book_spine li:first-child:before {
	width: 4px;
	height: 100%;
}

.book_spine li:first-child:after {
	-webkit-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	-moz-transform: rotateY(90deg) translateZ(-2px) translateX(2px);
	transform: rotateY(90deg) translateZ(-2px) translateX(2px);
}

.book_spine li:first-child:before {
	-webkit-transform: rotateY(-90deg) translateZ(-12px);
	-moz-transform: rotateY(-90deg) translateZ(-12px);
	transform: rotateY(-90deg) translateZ(-12px);
}

.book_spine li:last-child:after,
.book_spine li:last-child:before {
	width: 4px;
	height: 16px;
}

.book_spine li:last-child:after {
	-webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(8px) translateX(2px) translateY(-6px);
	-moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(8px) translateX(2px) translateY(-6px);
	transform: rotateX(90deg) rotateZ(90deg) translateZ(8px) translateX(2px) translateY(-6px);
}

.book_spine li:last-child:before {
	box-shadow: 5px -1px 100px 40px rgba(0, 0, 0, 0.2);
	-webkit-transform: rotateX(90deg) rotateZ(90deg) translateZ(-210px) translateX(2px) translateY(-6px);
	-moz-transform: rotateX(90deg) rotateZ(90deg) translateZ(-210px) translateX(2px) translateY(-6px);
	transform: rotateX(90deg) rotateZ(90deg) translateZ(-210px) translateX(2px) translateY(-6px);
}

.page,
.page > li {
	position: absolute;
	top: 0;
	left: 0;
	-webkit-transform-style: preserve-3d;
	-moz-transform-style: preserve-3d;
	transform-style: preserve-3d;
}

.page {
	width: 100%;
	height: 98%;
	top: 1%;
	left: 3%;
	z-index: 10;
}

.page > li {
	width: 100%;
	height: 100%;
	-webkit-transform-origin: left center;
	-moz-transform-origin: left center;
	transform-origin: left center;
	-webkit-transition-property: transform;
	-moz-transition-property: transform;
	transition-property: transform;
	-webkit-transition-timing-function: ease;
	-moz-transition-timing-function: ease;
	transition-timing-function: ease;
}

.page > li:nth-child(1) {
	-webkit-transition-duration: 0.6s;
	-moz-transition-duration: 0.6s;
	transition-duration: 0.6s;
}

.page > li:nth-child(2) {
	-webkit-transition-duration: 0.6s;
	-moz-transition-duration: 0.6s;
	transition-duration: 0.6s;
}

.page > li:nth-child(3) {
	-webkit-transition-duration: 0.4s;
	-moz-transition-duration: 0.4s;
	transition-duration: 0.4s;
}

.page > li:nth-child(4) {
	-webkit-transition-duration: 0.5s;
	-moz-transition-duration: 0.5s;
	transition-duration: 0.5s;
}

.page > li:nth-child(5) {
	-webkit-transition-duration: 0.6s;
	-moz-transition-duration: 0.6s;
	transition-duration: 0.6s;
}

/*
	5. events
*/

.book:hover > .hardcover_front {
	-webkit-transform: rotateY(-145deg) translateZ(0);
	-moz-transform: rotateY(-145deg) translateZ(0);
	transform: rotateY(-145deg) translateZ(0);
	z-index: 0;
}

.book:hover > .page li:nth-child(1) {
	-webkit-transform: rotateY(-30deg);
	-moz-transform: rotateY(-30deg);
	transform: rotateY(-30deg);
	-webkit-transition-duration: 1.5s;
	-moz-transition-duration: 1.5s;
	transition-duration: 1.5s;
}

.book:hover > .page li:nth-child(2) {
	-webkit-transform: rotateY(-35deg);
	-moz-transform: rotateY(-35deg);
	transform: rotateY(-35deg);
	-webkit-transition-duration: 1.8s;
	-moz-transition-duration: 1.8s;
	transition-duration: 1.8s;
}

.book:hover > .page li:nth-child(3) {
	-webkit-transform: rotateY(-118deg);
	-moz-transform: rotateY(-118deg);
	transform: rotateY(-118deg);
	-webkit-transition-duration: 1.6s;
	-moz-transition-duration: 1.6s;
	transition-duration: 1.6s;
}

.book:hover > .page li:nth-child(4) {
	-webkit-transform: rotateY(-130deg);
	-moz-transform: rotateY(-130deg);
	transform: rotateY(-130deg);
	-webkit-transition-duration: 1.4s;
	-moz-transition-duration: 1.4s;
	transition-duration: 1.4s;
}

.book:hover > .page li:nth-child(5) {
	-webkit-transform: rotateY(-140deg);
	-moz-transform: rotateY(-140deg);
	transform: rotateY(-140deg);
	-webkit-transition-duration: 1.2s;
	-moz-transition-duration: 1.2s;
	transition-duration: 1.2s;
}

/*
	6. Bonus
*/

/* cover CSS */

.coverDesign {
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	overflow: hidden;
	-webkit-backface-visibility: hidden;
	-moz-backface-visibility: hidden;
	backface-visibility: hidden;
}

.coverDesign::after {
	background-image: -webkit-linear-gradient( -135deg, rgba(255, 255, 255, 0.45) 0%, transparent 100%);
	background-image: -moz-linear-gradient( -135deg, rgba(255, 255, 255, 0.45) 0%, transparent 100%);
	background-image: linear-gradient( -135deg, rgba(255, 255, 255, 0.45) 0%, transparent 100%);
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
}

.coverDesign h1 {
	color: #fff;
	font-size: 2.2em;
	letter-spacing: 0.05em;
	text-align: center;
	margin: 54% 0 0 0;
	text-shadow: -1px -1px 0 rgba(0,0,0,0.1);
}

.coverDesign p {
	color: #f8f8f8;
	font-size: 1em;
	text-align: center;
	text-shadow: -1px -1px 0 rgba(0,0,0,0.1);
}

.yellow {
	background-color: #f1c40f;
	background-image: -webkit-linear-gradient(top, #f1c40f 58%, #e7ba07 0%);
	background-image: -moz-linear-gradient(top, #f1c40f 58%, #e7ba07 0%);
	background-image: linear-gradient(top, #f1c40f 58%, #e7ba07 0%);
}

.blue {
	background-color: #3498db;
	background-image: -webkit-linear-gradient(top, #3498db 58%, #2a90d4 0%);
	background-image: -moz-linear-gradient(top, #3498db 58%, #2a90d4 0%);
	background-image: linear-gradient(top, #3498db 58%, #2a90d4 0%);
}

.grey {
	background-color: #f8e9d1;
	background-image: -webkit-linear-gradient(top, #f8e9d1 58%, #e7d5b7 0%);
	background-image: -moz-linear-gradient(top, #f8e9d1 58%, #e7d5b7 0%);
	background-image: linear-gradient(top, #f8e9d1 58%, #e7d5b7 0%);
}

/* Basic ribbon */

.ribbon {
	color: #fff;
	display: block;
	font-size: 0.7em;
	position: absolute;
	top: 11px;
	right: 1px;
	width: 40px;
	height: 20px;
	line-height: 20px;
	letter-spacing: 0.15em; 
	text-align: center;
	-webkit-transform: rotateZ(45deg) translateZ(1px);
	-moz-transform: rotateZ(45deg) translateZ(1px);
	transform: rotateZ(45deg) translateZ(1px);
	-webkit-backface-visibility: hidden;
	-moz-backface-visibility: hidden;
	backface-visibility: hidden;
	z-index: 10;
  &.new{
    background: #63c930;
    &:before,
    &:after{
      border-bottom: 20px solid #63c930;
    }
  }
  &.bestseller{
    background: #c0392b;
    &:before,
    &:after{
      border-bottom: 20px solid #c0392b;
    }
  }
  
    
}

.ribbon::before,
.ribbon::after{
	position: absolute;
	top: -20px;
	width: 0;
	height: 0;
	
	border-top: 20px solid transparent;
}

.ribbon::before{
	left: -20px;
	border-left: 20px solid transparent;
}

.ribbon::after{
	right: -20px;
	border-right: 20px solid transparent;
}

/* figcaption */

figcaption {
	padding-left: 40px;
	text-align: left;
	position: absolute;
	top: 0%;
	left: 160px;
	width: 310px;
}

figcaption h1 {
	margin: 0;
}

figcaption span {
	color: #16a085;
	padding: 0.6em 0 1em 0;
	display: block;
}

figcaption p {
	color: #63707d;
	line-height: 1.3;
}

/* Media Queries */
@media screen and (max-width: 37.8125em) {
	.align > li {
		width: 100%;
		min-height: 280px;
		height: auto;
		padding: 0;
		margin: 0 0 30px 0;
	}

	.book {
		margin: 0 auto;
	}

	figcaption {
		text-align: center;
		width: 320px;
		top: 250px;
		padding-left: 0;
		left: -80px;
		font-size: 90%;
	}
}


#info-container:after {
    clear: both;
    content: "";
    display: table;
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
                <a href="" style="margin-left:0px; margin-top:15px;" class="navbar-brand">
                    TutorLink
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right navbar-uppercase" style="margin-top:7px; left:30px; height:0px;">
                    <li>
                        <a href="StudentsHome.php" style="margin-top:15px;" >Home</a>
                    </li>
                    <li>
                        <a href="tutorSearch.php" style="margin-top:15px;" >Tutor Search</a>
                    </li>
                    <li>
                        <a href="tutorInbox.php" style="margin-top:15px;" >Inbox</a>
                    </li>
                    <li>
                        <a href="resources.php" style="margin-top:15px;" >Resources</a>
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
        <div class="parallax filter filter-color-blue" style="height:1400px;">
            <div class="section" id="login">
            <div class="container">
             <div class="component" style="max-width:1300px; margin: 0 auto;margin-top:150px; ">
             	<h1 id="subjectChange" style="text-align:center; text-shadow: none;font-size:28px; margin-bottom:-60px;">Hi <b><?php echo $_SESSION['username']; ?>! </b>To search for a tutor, simply choose your subject below!</h1>
  <ul class="align">
    <!-- Book 1 -->
    <li>
      <figure class='book'>        
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/english.jpg" alt="" width="100%" height="100%">
            <span class="ribbon bestseller">Nº1</span>
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li style="color:white;">
          	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger" style="background:#00899C; color:white; font-weight:bold;" type="submit" value="English"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>  
    <!-- Book 2 -->
    <li>
      <figure class='book'>        
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/maths.jpg" alt="" width="100%" height="100%">
            <span class="ribbon new">NEW</span>
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="Maths"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
    <!-- Book 2 -->
    <li>
      <figure class='book'>        
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/irish.jpg" alt="" width="100%" height="100%">
            <span class="ribbon new">NEW</span>
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger" style="background:#00899C; color:white; font-weight:bold;"  type="submit" value="Irish"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li> 
    <!-- Book 2 -->
    <li>
      <figure class='book'>        
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/physics.jpg" alt="" width="100%" height="100%">
            <span class="ribbon new">NEW</span>
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="Physics"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li> 
    <!-- Book 2 -->
    <li>
      <figure class='book'>        
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/chemistry.jpg" alt="" width="100%" height="100%">
            <span class="ribbon new">NEW</span>
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="Chemistry"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li> 
    <!-- Book 2 -->
    <li>
      <figure class='book'>        
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/biology.jpg" alt="" width="100%" height="100%">
            <span class="ribbon new">NEW</span>
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="Biology"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li> 
    <!-- Book 3 -->
    <li>
      <figure class='book'>       
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/french.jpg" alt="" width="100%" height="100%">
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="French"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
    <!-- Book 3 -->
    <li>
      <figure class='book'>       
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/german.jpg" alt="" width="100%" height="100%">
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="German"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
    <!-- Book 3 -->
    <li>
      <figure class='book'>       
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/geography.jpg" alt="" width="100%" height="100%">
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger"  style="background:#00899C; color:white; font-weight:bold;" type="submit" value="Geography"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
    <!-- Book 3 -->
    <li>
      <figure class='book'>       
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/history.jpg" alt="" width="100%" height="100%">
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger" style="background:#00899C; color:white; font-weight:bold;"  type="submit" value="History"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
    <!-- Book 3 -->
    <li>
      <figure class='book'>       
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/music.jpg" alt="" width="100%" height="100%">
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger" style="background:#00899C; color:white; font-weight:bold;"  type="submit" value="Music"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
    <!-- Book 3 -->
    <li>
      <figure class='book'>       
        <!-- Front -->        
        <ul class='hardcover_front'>
          <li>
            <img src="assets/img/faces/business.jpg" alt="" width="100%" height="100%">
          </li>
          <li></li>
        </ul>        
        <!-- Pages -->        
        <ul class='page'>
          <li></li>
          <li>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults">
        		<input name="subjectChoice" class="btn btn-danger" style="background:#00899C; color:white; font-weight:bold;"  type="submit" value="Business"></input>
        	</form>
          </li>
          <li></li>
          <li></li>
          <li></li>
        </ul>        
        <!-- Back -->        
        <ul class='hardcover_back'>
          <li></li>
          <li></li>
        </ul>
        <ul class='book_spine'>
          <li></li>
          <li></li>
        </ul>
      </figure>
    </li>
  </ul> 
</div>
<h1 id="customise" style="text-align:center;  text-shadow: none;font-size:28px; margin-top:60px;">Or expand your search below!</h1>
<div class="login-form" style="margin-top:-100px;">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#searchResults" method="post" enctype="multipart/form-data" style="padding-bottom:50px;
                			-webkit-border-radius: 40px 40px 40px 40px;-moz-border-radius: 40px 40px 40px 40px;border-radius: 40px 40px 40px 40px;">
                    <h2 class="text-center">Use the fields below to customize your search!</h2>   
                    <div class="form-group <?php echo (!empty($lcGrade_err)) ? 'has-error' : ''; ?>">
                		<select required type="text" class="form-control" name="subjectChoiceCustom">
                    		<option selected value="">Select Subject</option>
                    		<option value="Biology">Biology</option>
                    		<option value="Business">Business</option>
                    		<option value="Chemistry">Chemistry</option>
                    		<option value="English">English</option>
                    		<option value="French">French</option>
                    		<option value="Geography">Geography</option>
                    		<option value="German">German</option>
                    		<option value="History">History</option>
                    		<option value="Irish">Irish</option>
                    		<option value="Maths">Maths</option>
                    		<option value="Music">Music</option>
                    		<option value="Physics">Physics</option>
                		</select>
                		<span class="help-block"><?php echo $lcGrade_err; ?></span>
            		</div>
            		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            		<?php
            		
            		//jsfiddle.net/My7D5/ & https://www.sitepoint.com/community/t/populate-dropdown-menu-from-mysql-database/6481/7
					/*$mysqli = new mysqli('127.0.0.1', 'cianmc85', '', 'project_db')*/ 
            		$mysqli = new mysqli('eu-cdbr-west-02.cleardb.net', 'bdff3cc89b8df5',
            					'25912b2f', 'heroku_6a6bf0a23aababd')
            			or die ('Cannot connect to db');

    				$result = mysqli_query($mysqli, "SELECT DISTINCT pastSchool FROM tutors ORDER BY pastSchool");
    				
    				echo "<select required class='form-control' name='schoolChoiceCUstom' id='mydropbox' onchange='copyValue()'>";
					echo "<option selected value=''>Select a School from our list</option>";
					
    				while ($row = $result->fetch_assoc()) {

                		unset($schoolToAdd);
                		$schoolToAdd = $row['pastSchool'];
                		echo $schoolToAdd;
                		echo '<option value="'.$schoolToAdd.'">'.$schoolToAdd.'</option>';

					}

    				echo "</select>";

					?>
					</div>
                    <div class="form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:40%;">
                        <button name="customizeSearch" type="submit" class="btn btn-primary btn-lg btn-block" value="Submit" style="width:100%; float: center; background:#008b9c; position: relative; margin-top:0px;">Search for Tutors</button>
                    </div>
                </form>
            </div>
             
             
             
            </div>
            

            </div>
        </div>
    </div>
<!-- END of modified code -->

    <div id="searchResults" class="section section-our-clients-freebie" style="height:1300px;">
        <div class="container">
            <div class="title-area">
                <h2 style="margin-top:100px;">The following tutors are available in this subject:</h2>
                <div class="separator separator-danger">∎</div>
            </div>

            <?php

if (isset($_POST['subjectChoice'])) {
	
    $choice = $_POST['subjectChoice'];

	echo "<div class='title-area'>
                <h5>These " . $choice . " tutors attended your school and had the same teacher that you do now.</h5>
                <h5>If you would like to search for tutors from a different school, feel free to customise your search above.</h5>
            </div>";

    $sql = "SELECT * FROM CVs WHERE subject = '".$choice."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
    	
        echo "<form action='' method='POST'><table class='table'><thead><tr><th>Tutor Name:</th><th>Verified Tutor?</th><th>Select tutor</th></tr></thead><tbody>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            
        
            $tutorID = $row['tutorID'];
            $schoolSearch = "SELECT pastSchool, firstname, surname FROM tutors where tutorID = '".$tutorID."'";
            $schoolSearchResult = $conn->query($schoolSearch);
            
            if ($schoolSearchResult->num_rows === 1) {
                $rowSchool = $schoolSearchResult->fetch_assoc();
            
                $schoolCondition = $rowSchool['pastSchool'];

                if ($schoolCondition === $_SESSION['school']){
                    echo "<tr><td>" . $rowSchool["firstname"]. " " . $rowSchool["surname"]. "</td><td>" . $row["verification"]. "</td><td><button class='btn btn-primary btn-lg btn-block' style='margin-top:0px; background:#008b9c;color:white; border:0px;'name='mybutton' value=". $row["cvID"]." type='submit'>View CV</button></td></tr>";
                }
            }
            else {
                echo "<div class='title-area'>
                <h5>There are no tutors in this subject who attended your school. Please customise your search to look for tutors from a different school.</h5>
            </div>";
            }
        }
        echo "</tbody></table></form>";
    } else {
        echo "<div class='title-area'>
                <h5>There are no tutors in this subject who attended your school. Please customise your search to look for tutors from a different school.</h5>
            </div>";
    }
}
elseif (isset($_POST['customizeSearch'])){
	
	$choice = $_POST['subjectChoiceCustom'];
	$choiceSchool = $_POST['schoolChoiceCUstom'];
    $sql = "SELECT * FROM CVs WHERE subject = '".$choice."'";
    $result = $conn->query($sql);
	if ($choice === ""){
		echo "<div class='title-area'>
                <h5>You must select a subject from the dropdown in order to see tutor search results</h5>
            </div>";
	}
    elseif ($result->num_rows > 0) { 
    	
        echo "<form action='' method='POST'><table class='table'><tr><th>Tutor Name:</th><th>Verified Tutor?</th><th>Select tutor</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        
            $tutorID = $row['tutorID'];
            $schoolSearch = "SELECT pastSchool, firstname, surname FROM tutors where tutorID = '".$tutorID."'";
            $schoolSearchResult = $conn->query($schoolSearch);
            
            if ($schoolSearchResult->num_rows === 1) {
                $rowSchool = $schoolSearchResult->fetch_assoc();
            
                $schoolCondition = $rowSchool['pastSchool'];

                if ($schoolCondition === $choiceSchool){
                    echo "<tr><td>" . $rowSchool["firstname"]. " " . $rowSchool["surname"]. "</td><td>" . $row["verification"]. "</td><td><button name='mybutton' class='btn btn-primary btn-lg btn-block' style='margin-top:0px; background:#008b9c;color:white; border:0px;' value=". $row["cvID"]." type='submit'>View CV</button></td></tr>";
                }
            }
            else {
                echo "<div class='title-area'>
                <h5>There are no tutors who fit your search. Please customise your search terms and try again.</h5>
            </div>";
            }
        }
        echo "</table></form>";
    } else {
        echo "<div class='title-area'>
                <h5>There are no tutors who fit your search. Please customise your search terms and try again.</h5>
            </div>";
    }
	
}
else {
	echo "<div class='title-area'>
                <h5>You must select a subject from above in order to see tutor search results</h5>
            </div>";
	
}
   
?>
		<div class="login-form form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:40%; float: left;">
            <a href="#subjectChange"><button type="submit" class="btn btn-primary btn-lg btn-block" value="Submit" style="width:70%; float: right; background:#008b9c; position: relative; margin-top:35px;">Choose different subject</button></a>
        </div>
        <div class="login-form form-group" style="height:auto; margin: 0 auto; padding: 10px; position: relative; width:40%; float: right;">
            <a href="#customise"><button type="submit" class="btn btn-primary btn-lg btn-block" value="Submit" style="width:70%; float: left; background:#008b9c; position: relative; margin-top:35px;">Customise Search</button></a>
        </div>
        </div>
    </div>
        

    <footer class="footer footer-big footer-color-black" data-color="black">
        <div class="container" style="height:300px;">
            <div class="row" style="margin-left:370px;">
                <div class="col-md-3 col-sm-3" style=>
                    <div class="info">
                        <h5 class="title">Useful Links</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="https://www.examinations.ie/">
                                        <p>State Examinations Commission</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.studyclix.ie/">
                                        <p>StudyClix</p>
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
                                    <a href="https://www.facebook.com/" class="btn btn-social btn-facebook btn-simple">
                                        <i class="fa fa-facebook-square"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/" class="btn btn-social btn-twitter btn-simple">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="https://plus.google.com/discover" class="btn btn-social btn-reddit btn-simple">
                                        <i class="fa fa-google-plus-square"></i> Google+
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="copyright" style="margin-top:0px;">
                 © <script> document.write(new Date().getFullYear()) </script> Creative Tim, edited by Cian McCarthy for TutorLink
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