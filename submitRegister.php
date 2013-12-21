<?php
	
	$in_email = $_POST["email"];  // the incoming EMAIL value
	$in_password = $_POST["password"];  // the incoming PASSWORD value
	$emailExists = false; // boolean variable to determine if the submitted email exists or not
	
	// setup the inital HTML responses
	$logStatus  = '<a class="loginLink" href="#">Login</a>';
	$welcome = '<div class="smallText">'.$logStatus.'&nbsp; | &nbsp;<a class="registerLink" href="#">Register</a>&nbsp; | &nbsp;<a class="checkLink" href="#">Check Reservation</a></div>';
	$logStatus  = '<a class="loginLink" href="#">Login</a>';
	
	// correctly format the submitted email
	$in_email = str_replace(' ', '', $in_email);
	$in_email = strtolower($in_email);
	
	// Read from the database
	$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
	/* Get the Customer's Information */
	$query = "SELECT `email` FROM `Customer` WHERE lower(`email`)=:email";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':email' => $in_email));
	
	/* Bind variables by column name */
	$stmt->bindColumn('email', $email);
	
	// make sure the submitted email doesn't exist already
	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
	{
		if ($email != "")
		{
			$emailExists = true;
			print "0";
			exit;
		}
	}
	
	// if the email doesn't exist, then register the user
	if (!$emailExists)
	{
		$query = "INSERT INTO `Customer` (`cfirstname`, `cmiddlename`, `clastname`, `email`, `address`, `city`, `state`, `zip`, `phone`, `password`, `passport`, `dob`, `admin`) VALUES ('', '', '', :email, '', '', '', '', '', :password, '', '0000-00-00', 0)";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':email' => $in_email, ':password' => $in_password));
		
		// get the new user's cid value set user cookies
		$query = "SELECT `cid` FROM `Customer` WHERE lower(`email`)=:email";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':email' => $in_email));
		
		/* Bind variables by column name */
		$stmt->bindColumn('cid', $cid);
		
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			// create the HTML for the new registered user
			$logStatus = '<a href="logout.php">Logout</a>';
			$welcome = "<div class=\"smallText\"><span>Welcome <b>".$in_email."!</b></span><br>".$logStatus."&nbsp; | &nbsp;<a href=\"account.php\">My Account</a>&nbsp; | &nbsp;<a class=\"checkLink\" href=\"#\">Check Reservation</a></div>";
			$logStatus = '<a href="logout.php">Logout</a>';
			
			/* Create the Customer ID cookie */
			setcookie('cid',$cid,time()+(2*3600)); // cookie expires after 2 hours
			
			/* Create the Customer DATA cookie */
			$cdata = "";
			setcookie('cdata',$cdata,time()+(.25*3600)); // cookie expires after 30 minutes
			
			
			/* Send the user a registration email */
			
			// setup the email variables
			$to = $in_email;
			$from = 'contact@transamericanair.com';
			$subject = 'Thank You for Registering at Trans American Airlines!';

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'To: <'.$in_email.'>' . "\r\n";
			$headers .= 'From: Trans American Airlines <'.$from.'>' . "\r\n";


			// create the HTML email message
			$message = '
				<html>
				<head>
				<title>'.$subject.'</title>
				<style>
					p {
						font-weight:700;
						font-size:20px;
					}
					
					.footer { 
						text-align: center; 
						background-color:#E0E0E0; 
						font-size: 12px; 
						font-family: Arial, Verdana, sans-serif; 
						color: #030085;
					}
					
					#wrapper {
						width:100%;
						height:100%;
					}
					
					#content {
						text-align:center;
					}
				</style>
				
				</head>
				<body>
				<div id="wrapper">
					<div align="center" id="content">
						<img alt="Trans American Airlines" src="http://transamericanair.selfip.com/img/logo2.png">
						<h1>Thank you for registering!</h1>
						<p>Here\'s your Account information. Please keep this in a safe location!</p>
						<br><br>
						Registered Email Address: '.$in_email.'<br>
						Your Password: '.$in_password.'<br>
						<br><br>
						<span>If you have any questions, please contact us at contact@transamericanair.com</span>
						<br><br>
						<div class="footer">Copyright 2013 &copy Trans American Airlines Inc.</div>
						
					</div>
				</div>
				</body>
				</html>
				';


			// Send the email
			mail($to, $subject, $message, $headers);
		}
	}
		
	print $welcome."&LOGSTATUS=".$logStatus;
	
?>