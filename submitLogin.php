<?php
	
	$in_email = $_POST["email"];  // the incoming EMAIL value
	$in_password = $_POST["password"];  // the incoming PASSWORD value
	$isLoggedIn = false; // boolean variable to determine if the user is logged in or not
	
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
	$query = "SELECT `cid`, `email`, `password`, `admin`  FROM `Customer` WHERE lower(`email`)=:email";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':email' => $in_email));
	
	/* Bind variables by column name */
	$stmt->bindColumn('cid', $cid);
	$stmt->bindColumn('email', $email);
	$stmt->bindColumn('password', $password);
	$stmt->bindColumn('admin', $admin);
	
	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
	{
		if ($password == $in_password) {$isLoggedIn = true;}
		
		if ($isLoggedIn)
		{
			if ($admin == 1)
			{
				// create the HTML for the logged in admin
				$logStatus = '<a href="logout.php">Logout</a>';
				$welcome = "<div class=\"smallText\"><span>Welcome <b>".$email."!</b></span><br>".$logStatus."&nbsp; | &nbsp;<a href=\"agent.php\">Agent Reports</a>&nbsp; | &nbsp;<a class=\"checkLink\" href=\"#\">Check Reservation</a></div>";
				$logStatus = '<a href="logout.php">Logout</a>';
			}
			else
			{
				// create the HTML for the logged in user
				$logStatus = '<a href="logout.php">Logout</a>';
				$welcome = '<div class="smallText"><span>Welcome <b>'.$email.'!</b></span><br>'.$logStatus.'&nbsp; | &nbsp;<a href="account.php">My Account</a>&nbsp; | &nbsp;<a class="checkLink" href="#">Check Reservation</a></div>';
				$logStatus = '<a href="logout.php">Logout</a>';
			}
			
			/* Create the Customer ID cookie */
			setcookie('cid',$cid,time()+(2*3600)); // cookie expires after 2 hours
			
			/* Create the Customer DATA cookie */
			$cdata = "";
			setcookie('cdata',$cdata,time()+(.25*3600)); // cookie expires after 30 minutes
		}
	}
	
	echo $welcome."&LOGSTATUS=".$logStatus;
	
?>