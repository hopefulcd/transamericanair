<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "User Account Information | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "account.php";
$onsubmit = "";
$in_cfirstname = (isset($_POST["cfirstname"])) ? $_POST["cfirstname"] : "";  // the incoming CUSTOMER FIRST NAME value
$in_cmiddlename = (isset($_POST["cmiddlename"])) ? $_POST["cmiddlename"] : "";  // the incoming CUSTOMER MIDDLE NAME value
$in_clastname = (isset($_POST["clastname"])) ? $_POST["clastname"] : "";  // the incoming CUSTOMER LAST NAME value
$in_address = (isset($_POST["address"])) ? $_POST["address"] : "";  // the incoming ADDRESS value
$in_city = (isset($_POST["city"])) ? $_POST["city"] : "";  // the incoming CITY value
$in_state = (isset($_POST["state"])) ? $_POST["state"] : "";  // the incoming STATE value
$in_zip = (isset($_POST["zip"])) ? $_POST["zip"] : "";  // the incoming ZIP value
$in_phone = (isset($_POST["phone"])) ? $_POST["phone"] : "";  // the incoming PHONE value
$in_passport = (isset($_POST["passport"])) ? $_POST["passport"] : "";  // the incoming PASSPORT value
$in_dobMonth = (isset($_POST["dobMonth"])) ? $_POST["dobMonth"] : "";  // the incoming DATE OF BIRTH - MONTH value
$in_dobDay = (isset($_POST["dobDay"])) ? $_POST["dobDay"] : "";  // the incoming DATE OF BIRTH - DAY value
$in_dobYear = (isset($_POST["dobYear"])) ? $_POST["dobYear"] : "";  // the incoming DATE OF BIRTH - YEAR value
$in_dob = "";  // the combined incoming values of the DATE OF BIRTH month,day,year
$cdata = "";  // variable used to hold some cookie data
$DAYS_IN_MONTH = 31;  // variable used to hold the number of days in a month
$NUM_MONTHS = 12;  // variable used to hold the number of months
$MIN_YEAR = 1900;  // variable used to hold the minimum year value
$MAX_YEAR = 2013;  // variable used to hold the maximum year value
$email = ""; // variable user to hold the user's email address
$password = ""; // variable user to hold the user's password
$admin = ""; // variable user to hold the user's admin privileges
$states = ""; // variable used to hold the HTML code for the states

// create the array of states
$statesArray = array("Alabama", "Alaska", "Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");


// set the timezone
date_default_timezone_set("America/Chicago");

// update the MAX_YEAR to the current year
$MAX_YEAR = (int) date("Y");

/* If submitted, then update the account information */
if ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/account.php")
{
	// fix the date of birth variables if they're blank
	if ($in_dobYear == "")
	{
		$in_dobYear = "0000";
	}
	
	if ($in_dobMonth == "")
	{
		$in_dobMonth = "00";
	}
	
	if ($in_dobDay == "")
	{
		$in_dobDay = "00";
	}
	
	// set the date of birth variable
	$in_dob = $in_dobYear."-".$in_dobMonth."-".$in_dobDay;
	
	// get the customer id cookie (if it exists)
	$cookie = ''; // initially set the cookie value to null
	
	// check the cookie to see if the user is logged in or not
	if (isset($_COOKIE['cid']))
	{
		$cookie = $_COOKIE['cid']; // set the cookie value to the 'cid' value
	}
	
	// if the cookie exists and is not null, then get the user's information
	if ($cookie != '')
	{
		// Get the customer information from the database
		$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		$query = "SELECT `email`, `password`, `admin` FROM `Customer` WHERE `cid`=:1";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':1' => $cookie));
		
		/* Bind variables by column name */
		$stmt->bindColumn('email', $em);
		$stmt->bindColumn('password', $pw);
		$stmt->bindColumn('admin', $ad);
			
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			$email = $em;
			$password = $pw;
			$admin = $ad;
		}
		
		// update the user's account information
		$query = "UPDATE `Customer` SET `cfirstname`=:cfirstname,`cmiddlename`=:cmiddlename,`clastname`=:clastname,`address`=:address,`city`=:city,`state`=:state,`zip`=:zip,`phone`=:phone,`passport`=:passport,`dob`=:dob WHERE `cid`=:cid";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':cid' => $cookie, ':cfirstname' => $in_cfirstname, ':cmiddlename' => $in_cmiddlename, ':clastname' => $in_clastname, ':address' => $in_address, ':city' => $in_city, ':state' => $in_state, ':zip' => $in_zip, ':phone' => $in_phone, ':passport' => $in_passport, ':dob' => $in_dob));
	}
	
	// update the input variables for the HTML
	$cfirstname = $in_cfirstname;
	$cmiddlename = $in_cmiddlename;
	$clastname = $in_clastname;
	$address = $in_address;
	$city = $in_city;
	$zip = $in_zip;
	$phone = $in_phone;
	$passport = $in_passport;
	
	// the HTML for the states
	for($i=0; $i < count($statesArray); $i++)
	{
		if ($in_state != "")
		{
			if ($statesArray[$i] == $in_state)
			{
				$states .= '<option value="'.$statesArray[$i].'" selected="selected">'.$statesArray[$i].'</option>';
				$i++;
			}
		}
		
		$states .= '<option value="'.$statesArray[$i].'">'.$statesArray[$i].'</option>';
	}
	
	/* Create the selectable Date of Birth values */
	$dobDay = "";
	$dobMonth = "";
	$dobYear = "";

	// the Date of Birth DAY values
	for($i=1; $i <= $DAYS_IN_MONTH; $i++)
	{
		if ($in_dobDay != "")
		{
			if ($i == ((int) $in_dobDay))
			{
				$dobDay .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				$i++;
			}
		}
		
		$dobDay .= '<option value="'.$i.'">'.$i.'</option>';
	}

	// the Date of Birth MONTH values
	for($i=1; $i <= $NUM_MONTHS; $i++)
	{
		if ($in_dobMonth != "")
		{
			if ($i == ((int) $in_dobMonth))
			{
				$dobMonth .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				$i++;
			}
		}
		
		$dobMonth .= '<option value="'.$i.'">'.$i.'</option>';
	}

	// the Date of Birth YEAR values
	for($i=$MAX_YEAR; $i >= $MIN_YEAR; $i--)
	{
		if ($in_dobYear != "")
		{
			if ($i == ((int) $in_dobYear))
			{
				$dobYear .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				$i--;
			}
		}
		
		$dobYear .= '<option value="'.$i.'">'.$i.'</option>';
	}
	
}
else
{
	// if the form is not submitted, then try to show the user's information
	
	// get the customer id cookie (if it exists)
	$cookie = ''; // initially set the cookie value to null
	
	// check the cookie to see if the user is logged in or not
	if (isset($_COOKIE['cid']))
	{
		$cookie = $_COOKIE['cid']; // set the cookie value to the 'cid' value
	}
	
	// if the cookie exists and is not null, then get the user's information
	if ($cookie != '')
	{
		// Get the customer information from the database
		$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		$query = "SELECT * FROM `Customer` WHERE `cid`=:1";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':1' => $cookie));
		
		/* Bind variables by column name */
		$stmt->bindColumn('cid', $cidDB);
		$stmt->bindColumn('cfirstname', $cfirstnameDB);
		$stmt->bindColumn('cmiddlename', $cmiddlenameDB);
		$stmt->bindColumn('clastname', $clastnameDB);
		$stmt->bindColumn('email', $emailDB);
		$stmt->bindColumn('address', $addressDB);
		$stmt->bindColumn('city', $cityDB);
		$stmt->bindColumn('state', $stateDB);
		$stmt->bindColumn('zip', $zipDB);
		$stmt->bindColumn('phone', $phoneDB);
		$stmt->bindColumn('password', $passwordDB);
		$stmt->bindColumn('passport', $passportDB);
		$stmt->bindColumn('dob', $dobDB);
		$stmt->bindColumn('admin', $adminDB);
			
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			// set the HTML values to the values from the database
			$cfirstname = $cfirstnameDB;
			$cmiddlename = $cmiddlenameDB;
			$clastname = $clastnameDB;
			$address = $addressDB;
			$city = $cityDB;
			$state = $stateDB;
			$zip = $zipDB;
			$phone = $phoneDB;
			$passport = $passportDB;
			$dob = $dobDB;
			
			
			// the HTML for the states
			for($i=0; $i < count($statesArray); $i++)
			{
				if ($state != "")
				{
					if ($statesArray[$i] == $state)
					{
						$states .= '<option value="'.$statesArray[$i].'" selected="selected">'.$statesArray[$i].'</option>';
						$i++;
					}
				}
				
				$states .= '<option value="'.$statesArray[$i].'">'.$statesArray[$i].'</option>';
			}
			
			/* Create the selectable Date of Birth values */
			
			$dobArray = explode('-', $dob);
			
			$dobDay = $dobArray[2];
			$dobMonth = $dobArray[1];
			$dobYear = $dobArray[0];

			// the Date of Birth DAY values
			for($i=1; $i <= $DAYS_IN_MONTH; $i++)
			{
				if ($dobDay != "00")
				{
					if ($i == ((int) $dobDay))
					{
						$dobDay .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
						$i++;
					}
				}
				
				$dobDay .= '<option value="'.$i.'">'.$i.'</option>';
			}

			// the Date of Birth MONTH values
			for($i=1; $i <= $NUM_MONTHS; $i++)
			{
				if ($dobMonth != "00")
				{
					if ($i == ((int) $dobMonth))
					{
						$dobMonth .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
						$i++;
					}
				}
				
				$dobMonth .= '<option value="'.$i.'">'.$i.'</option>';
			}

			// the Date of Birth YEAR values
			for($i=$MAX_YEAR; $i >= $MIN_YEAR; $i--)
			{
				if ($dobYear != "")
				{
					if ($i == ((int) $dobYear))
					{
						$dobYear .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
						$i--;
					}
				}
				
				$dobYear .= '<option value="'.$i.'">'.$i.'</option>';
			}
					
		}
		
	}
	else
	{
		// the user is not logged in, so redirect to the home page
		header("Location: http://transamericanair.selfip.com/");
	}
}

/* Print the HTML code for the page header */
require($INC_DIR."header.php");


/* Print the HTML code for the page body */
require($INC_DIR."account.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>