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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="OCC Extranet App cards demo">
    <meta name="author" content="Samaritan's Purse International Relief">
    <title>Student Resources</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="logo.png">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Student Resources</title>
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
                        <a href="StudentsHome.php" style="margin-top:15px;" target="_blank">Home</a>
                    </li>
                    <li>
                        <a href="tutorSearch.php" style="margin-top:15px;" target="_blank">Tutor Search</a>
                    </li>
                    <li>
                        <a href="tutorInbox.php" style="margin-top:15px;" target="_blank">Inbox</a>
                    </li>
                    <li>
                        <a href="resources.php" style="margin-top:15px;" target="_blank">Resources</a>
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
        <div class="parallax filter filter-color-blue" style="height:500px;">
            <div class="section" id="login">`
            <div class="container">
                <h1 style="font-size:100px; margin-top:150px; text-align:center;">Resources</h1>

                    <div class="login-form form-group" style="height:100px; margin: 0 auto; margin-top:50px; padding: 10px; position: relative; width:100%; background:white;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;">
                        <a href="#social"><input href="#social" name="Social" type="submit" class="btn btn-primary btn-lg btn-block" value="Social Media" style="display:block; margin-top:8px;height: 80%; width:25%; float: left; position: relative;"></a>
                        <a href="#links"><input name="Links" type="submit" class="btn btn-primary btn-lg btn-block" value="Useful Links" style="margin-top:8px; left:170px; width:25%; height: 80%; float: center; position: relative;"></a>
                        <a href="#tools"><input name="Tools" type="submit" class="btn btn-primary btn-lg btn-block" value="Cool Tools" style="margin-top:-83px; width:25%; height: 80%; float: right; position: relative;"></a>
                    </div>
            
            </div>
            </div>
        </div>
    </div>
<!-- END of modified code -->

    <div class="section" id="social">`
        <div class="container" style="height:805px;">
            <h2 class="text-center">Social Media</h2> 
            
            <a id="twitterFeed" class="twitter-timeline"  href="https://twitter.com/search?q=%23LeavingCert%20" data-widget-id="970074385515274240">Tweets about #LeavingCert </a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          <div style=" float:right; margin-top:50px;">
            <!-- InstaWidget -->
            <a href="https://instawidget.net/v/tag/LeavingCert" id="link-ac6554064c3144875287d150993a2f4b96eb3240b90aa3c9488d0dfb82e7955e">#LeavingCert</a>
            <script src="https://instawidget.net/js/instawidget.js?u=ac6554064c3144875287d150993a2f4b96eb3240b90aa3c9488d0dfb82e7955e&width=400px"></script>
          </div>
        </div>
    </div>
    
    
    
    <div class="section" id="tools" style="background:#00899C;">
        <div class="container" style="height:650px;">
            <h2 class="text-center" style="color:white;">Cool Tools</h2> 
            <div data-type="countdown" data-id="497118" class="tickcounter" style="width: 80%; margin: 0 auto; margin-top:50px; margin-bottom:50px; position: relative; padding-bottom: 25%;"><a href="//www.tickcounter.com/countdown/497118/leaving-cert-2018" title="Leaving Cert 2018">Leaving Cert 2018</a><a href="//www.tickcounter.com/" title="Countdown">Countdown</a></div><script>(function(d, s, id) { var js, pjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//www.tickcounter.com/static/js/loader.js"; pjs.parentNode.insertBefore(js, pjs); }(document, "script", "tickcounter-sdk"));</script>
            
            <script type="text/javascript" id="WolframAlphaScript605559102ff2cf71fab6e2efb450701b" src="//www.wolframalpha.com/widget/widget.jsp?id=605559102ff2cf71fab6e2efb450701b&theme=gray&output=lightbox"></script>

        </div>
    </div>
        
    <div class="section" id="links">
        <div class="container" style="height:705px;">
            <h2 class="text-center">Useful Links</h2> 
            <div class="title-area">
                <div class="separator separator-danger">∎</div>
                <h5 class="text-center">Below you will find some links that students find useful!</h5>
                <div style="width:100%; height:700px; margin: 0 auto; margin-top:50px;">
                    <a href="https://www.studyclix.ie/"><img src="http://droghedagrindsacademy.com/wp-content/uploads/2016/09/studyclix2.png" style="height:150px; width:200px; margin: 20px;"></a>
                    <a href="http://www.studynotes.ie/"><img src="https://cdn.dribbble.com/users/11001/screenshots/1325976/9_studynotes_logo_1x.png" style="height:150px; width:200px; margin: 20px;"></a>
                    <a href="https://www.examinations.ie/"><img src="https://www.themathstutor.ie/wp-content/uploads/2017/07/4589852_orig.jpg" style="height:150px; width:200px; margin: 20px;"></a>
                    <a href="https://www.khanacademy.org/"><img src="https://images2.onionstatic.com/clickhole/4935/3/16x9/1200.jpg" style="height:150px; width:200px; margin: 20px;"></a>
                    <a href="https://www.edmodo.com/"><img src="https://assets.pcmag.com/media/images/423261-edmodo-lms-logo.jpg?width=333&height=245" style="height:150px; width:200px; margin: 20px;"></a>
                </div>
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