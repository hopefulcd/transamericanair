<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Register | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "register.php";
$onsubmit = "";
$in_rflight = $_POST["rflight"];  // the incoming RETURN FLIGHT value
$in_dflight = $_POST["dflight"];  // the incoming DEPARTURE FLIGHT value
$in_quantity = $_POST["quantity"];  // the incoming QUANTITY value
$in_cfirstname = $_POST["cfirstname"];  // the incoming CUSTOMER FIRST NAME value
$in_cmiddlename = $_POST["cmiddlename"];  // the incoming CUSTOMER MIDDLE NAME value
$in_clastname = $_POST["clastname"];  // the incoming CUSTOMER LAST NAME value
$in_address = $_POST["address"];  // the incoming ADDRESS value
$in_city = $_POST["city"];  // the incoming CITY value
$in_state = $_POST["state"];  // the incoming STATE value
$in_zip = $_POST["zip"];  // the incoming ZIP value
$in_phone = $_POST["phone"];  // the incoming PHONE value
$in_email = $_POST["email"];  // the incoming EMAIL value
$in_password = $_POST["password"];  // the incoming PASSWORD value
$in_repassword = $_POST["repassword"];  // the incoming REPASSWORD value
$in_passport = $_POST["passport"];  // the incoming PASSPORT value
$in_dobMonth = $_POST["dobMonth"];  // the incoming DATE OF BIRTH - MONTH value
$in_dobDay = $_POST["dobDay"];  // the incoming DATE OF BIRTH - DAY value
$in_dobYear = $_POST["dobYear"];  // the incoming DATE OF BIRTH - YEAR value
$in_dob = "";  // the combined incoming values of the DATE OF BIRTH month,day,year
$error = "";  // variable used to hold some HTML code
$loggedIn = 0;  // boolean variable used to determine if the customer is logged in or not
$count = NULL;  // variable used to determine the correct area to branch to next
$cdata = "";  // variable used to hold some cookie data
$DAYS_IN_MONTH = 31;  // variable used to hold the number of days in a month
$NUM_MONTHS = 12;  // variable used to hold the number of months
$MIN_YEAR = 1900;  // variable used to hold the minimum year value
$MAX_YEAR = 2013;  // variable used to hold the maximum year value

// set the timezone
date_default_timezone_set("America/Chicago");

// update the MAX_YEAR to the current year
$MAX_YEAR = (int) date("Y");

/* If submitted, then check the registration information */
if ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/register.php")
{
	// set the date of birth variable
	$in_dob = $in_dobYear."-".$in_dobMonth."-".$in_dobDay;
	
	// make the email without spaces and lowercase
	$in_email = str_replace(' ', '', $in_email);
	$in_email = strtolower($in_email);
	
	// Read from the database
	$db = new PDO('mysql:host=127.0.0.1;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
	/* Get the Customer's Information */
	$query = "SELECT `email` FROM `Customer` WHERE lower(`email`)=:email";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':email' => $in_email));
	
	/* Bind variables by column name */
	$stmt->bindColumn('email', $email);
	
	// make sure the submitted email doesn't exist already
	$count = 1;
	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
	{
		if ($email != "") {$count = 0;}
	}
	
	if ($count == 1)
	{
		if ( ($in_email != "") && ($in_cfirstname != "") && ($in_clastname != "") && ($in_address != "") && ($in_password == $in_repassword) && ($in_password != "") )
		{
			$query = "INSERT INTO `Customer` (`cfirstname`, `cmiddlename`, `clastname`, `email`, `address`, `city`, `state`, `zip`, `phone`, `password`, `passport`, `dob`, `admin`) VALUES (:cfirstname, :cmiddlename, :clastname, :email, :address, :city, :state, :zip, :phone, :password, :passport, :dob, 0)";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':cfirstname' => $in_cfirstname, ':cmiddlename' => $in_cmiddlename, ':clastname' => $in_clastname, ':email' => $in_email, ':address' => $in_address, ':city' => $in_city, ':state' => $in_state, ':zip' => $in_zip, ':phone' => $in_phone, ':password' => $in_password, ':passport' => $in_passport, ':dob' => $in_dob));
			$count = 3;
			
			// get the new user's cid value set user cookies
			$query = "SELECT `cid` FROM `Customer` WHERE lower(`email`)=:email";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':email' => $in_email));
			
			/* Bind variables by column name */
			$stmt->bindColumn('cid', $cid);
			
			while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
			{
				/* Create the Customer ID cookie */
				setcookie('cid',$cid,time()+(2*3600)); // cookie expires after 2 hours
				
				/* Create the Customer DATA cookie */
				$cdata = $in_dflight.'/'.$in_rflight.'/'.$in_quantity;
				setcookie('cdata',$cdata,time()+(.25*3600)); // cookie expires after 30 minutes
			}
		}
		
		if ( ($in_dflight != "") && ($count == 3) )
		{
			/* Redirect the browser to billing.php */
			header("Location: http://transamericanair.selfip.com/billing.php");
			exit;
		}
		if ($count == 3)
		{
			/* Redirect the browser back to index.php */
			header("Location: http://transamericanair.selfip.com/");
			exit;
		}
	}
	
	$count = 2;
}


/* Print the HTML code for the page header */
require($INC_DIR."header.php");



/* Check the submitted registration information */

// Customer First Name
if ( ($in_cfirstname == "") && ($count == 2) )
{
	$errorcFirstName = "ERROR: You Must Enter A First Name.<br>";
	$cfirstname = "";
}
else
{
	$errorcFirstName = "";
	$cfirstname = $in_cfirstname;
}

// Customer Middle Name
if ( ($in_cmiddlename == "") && ($count == 2) )
{
	$errorcMiddleName = "ERROR: You Must Enter A Middle Name.<br>";
	$cmiddlename = "";
}
else
{
	$errorcMiddleName = "";
	$cmiddlename = $in_cmiddlename;
}

// Customer Last Name
if ( ($in_clastname == "") && ($count == 2) )
{
	$errorcLastName = "ERROR: You Must Enter A Last Name.<br>";
	$clastname = "";
}
else
{
	$errorcLastName = "";
	$clastname = $in_clastname;
}

// Address
if ( ($in_address == "") && ($count == 2) )
{
	$errorAddress = "ERROR: You Must Enter An Address.<br>";
	$address = "";
}
else 
{
	$errorAddress = "";
	$address = $in_address;
}

// City
if ( ($in_city == "") && ($count == 2) )
{
	$errorCity = "ERROR: You Must Enter A City.<br>";
	$city = "";
}
else 
{
	$errorCity = "";
	$city = $in_city;
}

// State
if ( ($in_state == "") && ($count == 2) )
{
	$errorState = "ERROR: You Must Select A State.<br>";
	$state = "";
}
else 
{
	$errorState = "";
	$state = $in_state;
}

// Zip
if ( ($in_zip == "") && ($count == 2) )
{
	$errorZip = "ERROR: You Must Enter A Zip Code.<br>";
	$zip = "";
}
else 
{
	$errorZip = "";
	$zip = $in_zip;
}

// Phone
if ( ($in_phone == "") && ($count == 2) )
{
	$errorPhone = "ERROR: You Must Enter A Phone Number.<br>";
	$phone = "";
}
else 
{
	$errorPhone = "";
	$phone = $in_phone;
}

// Passport
if ( ($in_passport == "") && ($count == 2) )
{
	$errorPassport = "ERROR: You Must Enter A Passport Number.<br>";
	$passport = "";
}
else 
{
	$errorPassport = "";
	$passport = $in_passport;
}

// Email
if ( (($email != "") || ($in_email == "")) && ($count == 2) )
{
	$errorEmail = "ERROR: The Email Entered Is Invalid.<br>";
	$email = "";
}
else 
{
	$errorEmail = "";
	$email = $in_email;
}

// Password
if ( (($in_password != $in_repassword) || ($in_password == "")) && ($count == 2) )
{
	$errorPassword = "ERROR: The Passwords Entered Are Invalid.<br>";
	$password = "";
	$repassword = "";
}
else
{
	$errorPassword = "";
	$password = $in_password;
	$repassword = $in_repassword;
}

/* Create the selectable Date of Birth values */
$dobDay = "";
$dobMonth = "";
$dobYear = "";

// the Date of Birth DAY values
for($i=1; $i <= $DAYS_IN_MONTH; $i++)
{
	$dobDay .= '<option value="'.$i.'">'.$i.'</option>';
}

// the Date of Birth MONTH values
for($i=1; $i <= $NUM_MONTHS; $i++)
{
	$dobMonth .= '<option value="'.$i.'">'.$i.'</option>';
}

// the Date of Birth YEAR values
for($i=$MAX_YEAR; $i >= $MIN_YEAR; $i--)
{
	$dobYear .= '<option value="'.$i.'">'.$i.'</option>';
}



/* Print the HTML code for the page body */
require($INC_DIR."register.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>