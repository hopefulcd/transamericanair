<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Login | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "";
$onsubmit = "";
$in_rflight = $_POST["radio"];  // the incoming RETURN FLIGHT value
$in_dflight = $_POST["dflight"];  // the incoming DEPARTURE FLIGHT value
$in_ddate = $_POST["ddate"];  // the incoming DESTINATION DATE value
$in_rdate = $_POST["rdate"];  // the incoming RETURNING DATE value
$in_orig  = $_POST["from"];  // the incoming FROM value
$in_dest  = $_POST["to"];  // the incoming TO value
$origCity  = $_POST["origCity"];  // the incoming ORIGIN CITY value
$origState = $_POST["origState"];  // the incoming ORIGIN STATE value
$destCity  = $_POST["destCity"];  // the incoming DESTINATION CITY value
$destState = $_POST["destState"];  // the incoming DESTINATION STATE value
$in_quantity = $_POST["quantity"];  // the incoming TICKET QUANTITY value
$in_trip = $_POST["trip"];  // the incoming TRIP value (1 = one way trip, 2 = round trip)
$in_email = (isset($_POST["email"])) ? $_POST["email"] : "";  // the incoming EMAIL value
$in_password = (isset($_POST["password"])) ? $_POST["password"] : "";  // the incoming PASSWORD value
$error = "";  // variable used to hold some HTML code
$loggedIn = 0;  // variable used to determine if the customer is logged in or not


// Check to make sure that the user is coming from a valid referer
if ( ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/selectdf.php") || ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/selectrf.php") || ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/login.php") )
{

	/* Check if the user is logged in already */

	// get the customer id cookie (if it exists)
	$cookie = ''; // initially set the cookie value to null

	if (isset($_COOKIE['cid']))
	{
		$cookie = $_COOKIE['cid']; // set the cookie value to the 'cid' value
	}

	// if the cookie exists and is not null
	if ($cookie != '')
	{
		/* Update the Customer DATA cookie with the newest information */
		$cdata = $in_dflight.'/'.$in_rflight.'/'.$in_quantity;
		setcookie('cdata',$cdata,time()+(.25*3600)); // cookie expires after 30 minutes
		
		/* Redirect the browser */
		header("Location: http://transamericanair.selfip.com/travelers.php");
		exit;
	}

	/* If the login form is submitted, then check the login information */
	if ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/login.php")
	{
		// correctly format the submitted email
		$in_email = str_replace(' ', '', $in_email);
		$in_email = strtolower($in_email);
		$loggedIn = 2;
		
		// Read from the database
		$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		/* Get the Customer's Information */
		$query = "SELECT `cid`, `email`, `password` FROM `Customer` WHERE lower(`email`)=:email";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':email' => $in_email));
		
		/* Bind variables by column name */
		$stmt->bindColumn('cid', $cid);
		$stmt->bindColumn('email', $email);
		$stmt->bindColumn('password', $password);
		
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			if ($password == $in_password) {$loggedIn = 1;}
			
			if ($loggedIn == 1)
			{
				/* Create the Customer ID cookie */
				setcookie('cid',$cid,time()+(2*3600)); // cookie expires after 2 hours
				
				/* Create the Customer DATA cookie */
				$cdata = $in_dflight.'/'.$in_rflight.'/'.$in_quantity;
				setcookie('cdata',$cdata,time()+(.25*3600)); // cookie expires after 30 minutes
				
				/* Redirect the browser */
				header("Location: http://transamericanair.selfip.com/travelers.php");
			}
		}
	}
}
else
{
	// the user came to this page illegally, so redirect to the home page
	header("Location: http://transamericanair.selfip.com/");
	exit;
}

/* Print the HTML code for the page header */
require($INC_DIR."header.php");

// if the login information submitted was incorrect
if ($loggedIn == 2) {$error = "Incorrect Login Information.<br>Please Login Again.";}
else {$error = "";}


/* Print the HTML code for the page body */
require($INC_DIR."login.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>
