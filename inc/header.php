<!DOCTYPE html>
<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta name="keywords" content="airplane, airline, internet, tickets" />
<meta name="description" content="<?php echo $description; ?>" />

<title><?php echo $title; ?></title>

<!-- The small site logo -->
<link rel="icon" type="image/jpeg" href="img/logo2.png" />

<!-- The CSS Stylesheets -->
<link rel="stylesheet" href="css/style1.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

<!-- The Javascript / Jquery Files -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/jquery.fittext.js"></script>
<script src="js/jquery.lettering.js"></script>
<script src="js/jquery.textillate.js"></script>
<script src="js/all.js"></script>

</head>

<body>

<!-- main container -->	
<div id="container">
	
	<!-- page header -->	
	<div id="header">
	
		<!-- page top -->
		<ul id="page-top">
			<li>
				<a id="titleLink" href="http://transamericanair.selfip.com">
					<ul>
						<li><img src="img/logo2.png" width="110" height="80" alt="TAA" title="Trans American Airlines" /></li>
						<li><h1 id="title" class="tlt">Trans American Airlines</h1></li>
					</ul>
				</a>
			</li>
			<li>
				<!-- user options -->
				<div id="user-options">
				
				<?php
					$isLoggedIn = false; // boolean variable to determine if the user is logged in or not
					$logStatus  = '<a class="top loginLink" href="#">Login</a>';
					$welcome = $logStatus.'&nbsp; | &nbsp;<a class="top registerLink" href="#">Register</a>&nbsp; | &nbsp;<a class="top checkLink" href="#">Check Reservation</a>';
					$logStatus  = '<a class="top loginLink" href="#">Login</a>';

					// get the customer id cookie (if it exists)
					$cookie = ''; // initially set the cookie value to null
					
					// check the cookie to see if the user is logged in or not
					if (isset($_COOKIE['cid']))
					{
						$cookie = $_COOKIE['cid']; // set the cookie value to the 'cid' value
					}
					
					// if the cookie exists and is not null, then get the user's email
					if ($cookie != '')
					{	
						// Get the customer name from the database
						$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
						
						$query = "SELECT `email`, `admin` FROM `Customer` WHERE `cid`=:1";
						
						$stmt = $db->prepare($query);
						$stmt->execute(array(':1' => $cookie));
						
						// Bind variables by column name
						$stmt->bindColumn('email', $e);
						$stmt->bindColumn('admin', $a);
						
						while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
						{
							$email = $e;
							$admin = $a;
							
							if ($admin == 1)
							{
								// create the HTML for the logged in admin
								$cEmail = $email;
								$logStatus = '<a href="logout.php">Logout</a>';
								$welcome = "<div class=\"smallText\"><span>Welcome <b>".$cEmail."!</b></span><br>".$logStatus."&nbsp; | &nbsp;<a href=\"agent.php\">Agent Reports</a>&nbsp; | &nbsp;<a class=\"checkLink\" href=\"#\">Check Reservation</a></div>";
								$logStatus = '<a href="logout.php">Logout</a>';
								$isLoggedIn = true;
							}
							else
							{
								// create the HTML for the logged in user
								$cEmail = $email;
								$logStatus = '<a href="logout.php">Logout</a>';
								$welcome = "<div class=\"smallText\"><span>Welcome <b>".$cEmail."!</b></span><br>".$logStatus."&nbsp; | &nbsp;<a href=\"account.php\">My Account</a>&nbsp; | &nbsp;<a class=\"checkLink\" href=\"#\">Check Reservation</a></div>";
								$logStatus = '<a href="logout.php">Logout</a>';
								$isLoggedIn = true;
							}
						}
					}
					
					echo $welcome;
					
					?>
								
				</div>
				<!-- END user options -->
			</li>
		</ul>
		<!-- END page-top -->
		
		<!-- hidden drop-down menus -->
		
		<!-- Login -->
		<div id="loginDrop" class="hidden dropDown">
			<input type="text" id="emailLogin" name="emailLogin" placeholder="Email Address" title="Enter your email address" />
			<input type="password" id="passLogin" name="passLogin" placeholder="Password" title="Enter your password" />
			<input type="button" class="submitButton" id="submitLogin" name="submitLogin" onclick="submitLogin()" value="Login"/>
		</div>
		
		<!-- Register -->
		<div id="registerDrop" class="hidden dropDown">
			<input type="text" id="emailRegister" name="emailRegister" placeholder="Email Address" title="Enter your email address" />
			<input type="password" id="passRegister" name="passRegister" placeholder="Password" title="Enter your password" />
			<input type="password" id="rePassRegister" name="rePassRegister" placeholder="Re-Enter Password" title="Re-Enter your password" />
			<input type="button" class="submitButton" id="submitRegister" name="submitRegister" onclick="submitRegister()" value="Register"/>
		</div>
		
		<!-- Check Reservation -->
		<div id="checkDrop" class="hidden dropDown">
			<form action="check.php" method="GET" name="checkForm" id="checkForm">
				<input type="text" id="orderCheck" name="orderCheck" placeholder="Order Number" title="Enter your Reservation Order Number" />
				<input type="submit" class="submitButton" value="Check Reservation"/>
			</form>
		</div>
		
		<!-- END hidden drop-down menus -->
		
		<!-- background picture -->
		<div id="main_pic">
			<img src="img/beach.jpg" title="Helping you get from point A to point B...faster" alt="Trans American Airlines" />
		</div>
		<!-- END background picture -->
		
		<!-- The internal Jquery code for the header -->
		<script>
		
		// the animation for the Trans American Airlines text
		$(function() {
			$('.tlt').textillate({
			// enable looping
			loop: false,
			
			// sets the minimum display time for each text before it is replaced
			minDisplayTime: 2000,
			
			// sets the initial delay before starting the animation
			// (note that depending on the in effect you may need to manually apply 
			// visibility: hidden to the element before running this plugin)
			initialDelay: 0,
			
			// set whether or not to automatically start animating
			autoStart: true,
			
			// custom set of 'in' effects. This effects whether or not the 
			// character is shown/hidden before or after an animation  
			inEffects: [],
			
			// custom set of 'out' effects
			outEffects: [],
			
			// in animation settings
			in: {
				// set the effect name
				effect: 'fadeInDown',
				
				// set the delay factor applied to each consecutive character
				delayScale: 1.5,
				
				// set the delay between each character
				delay: 50,
				
				// set to true to animate all the characters at the same time
				sync: false,
				
				// randomize the character sequence 
				// (note that shuffle doesn't make sense with sync = true)
				shuffle: false
			},
			
			// out animation settings.
			out: {
				//effect: 'hinge',
				//delayScale: 1.5,
				//delay: 50,
				//sync: false,
				//shuffle: false,
			}
			});
		})
		
		// the login, register, and check reservation animation
		$(function() {
			
			// the login drop down menu
			$('.loginLink').hover(function() {
				$('#loginDrop').css({
					'opacity': 0,
					'margin-top': -15
				}).show().animate({
					'margin-top': 0,
					'opacity': 1
				}, 400);
				
				$('#registerDrop').hide();
				$('#checkDrop').hide();
				
			}, function() {
			});
			
			// the register drop down menu
			$('.registerLink').hover(function() {
				$('#registerDrop').css({
					'opacity': 0,
					'margin-top': -15
				}).show().animate({
					'margin-top': 0,
					'opacity': 1
				}, 400);
				
				$('#loginDrop').hide();
				$('#checkDrop').hide();
				
			}, function() {
			});
			
			// the check reservation drop down menu
			$('.checkLink').hover(function() {
				$('#checkDrop').css({
					'opacity': 0,
					'margin-top': -15
				}).show().animate({
					'margin-top': 0,
					'opacity': 1
				}, 400);
				
				$('#loginDrop').hide();
				$('#registerDrop').hide();
				
			}, function() {
			});
			
			// make the drop down menus disappear 
			
			// hide the login menu
			$('#loginDrop').hover(function() {
			}, function() {
				$('#loginDrop').hide();
			});
			
			// hide the register menu
			$('#registerDrop').hover(function() {
			}, function() {
				$('#registerDrop').hide();
			});
			
			// hide the check reservation menu
			$('#checkDrop').hover(function() {
			}, function() {
				$('#checkDrop').hide();
			});
			
		});
		
		</script>
	
	</div>
	<!-- END page header -->
	