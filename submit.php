<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Order Complete | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "";
$onsubmit = "";
$in_rflight = (isset($_POST["rflight"])) ? $_POST["rflight"] : "";  // the incoming RETURN FLIGHT value
$in_dflight = (isset($_POST["dflight"])) ? $_POST["dflight"] : "";  // the incoming DEPARTURE FLIGHT value
$in_ddate = (isset($_POST["ddate"])) ? $_POST["ddate"] : "";  // the incoming DESTINATION DATE value
$in_rdate = (isset($_POST["rdate"])) ? $_POST["rdate"] : "";  // the incoming RETURNING DATE value
$in_orig  = (isset($_POST["from"])) ? $_POST["from"] : "";  // the incoming FROM value
$in_dest  = (isset($_POST["to"])) ? $_POST["to"] : "";  // the incoming TO value
$origCity  = (isset($_POST["origCity"])) ? $_POST["origCity"] : "";  // the incoming ORIGIN CITY value
$origState = (isset($_POST["origState"])) ? $_POST["origState"] : "";  // the incoming ORIGIN STATE value
$destCity  = (isset($_POST["destCity"])) ? $_POST["destCity"] : "";  // the incoming DESTINATION CITY value
$destState = (isset($_POST["destState"])) ? $_POST["destState"] : "";  // the incoming DESTINATION STATE value
$in_quantity = (isset($_POST["quantity"])) ? $_POST["quantity"] : "";  // the incoming TICKET QUANTITY value
$in_trip = (isset($_POST["trip"])) ? $_POST["trip"] : "";  // the incoming TRIP value (1 = one way trip, 2 = round trip)
$orderNum = (isset($_POST["orderNum"])) ? $_POST["orderNum"] : "";  // the incoming ORDER NUMBER value
$in_cardNum = (isset($_POST["cardNum"])) ? $_POST["cardNum"] : "";  // the incoming CARD NUMBER value
$in_cardMonth = (isset($_POST["cardMonth"])) ? $_POST["cardMonth"] : "";  // the incoming CARD MONTH value
$in_cardYear = (isset($_POST["cardYear"])) ? $_POST["cardYear"] : "";  // the incoming CARD YEAR value
$in_cardFirstName = (isset($_POST["cardFirstName"])) ? $_POST["cardFirstName"] : "";  // the incoming CARD FIRST NAME value
$in_cardMiddleName = (isset($_POST["cardMiddleName"])) ? $_POST["cardMiddleName"] : "";  // the incoming CARD MIDDLE NAME value
$in_cardLastName = (isset($_POST["cardLastName"])) ? $_POST["cardLastName"] : "";  // the incoming CARD LAST NAME value
$in_cardType = (isset($_POST["cardType"])) ? $_POST["cardType"] : "";  // the incoming CARD TYPE value
$in_address = (isset($_POST["address"])) ? $_POST["address"] : "";  // the incoming ADDRESS value
$in_city = (isset($_POST["city"])) ? $_POST["city"] : "";  // the incoming CITY value
$in_state = (isset($_POST["state"])) ? $_POST["state"] : "";  // the incoming STATE value
$in_zip = (isset($_POST["zip"])) ? $_POST["zip"] : "";  // the incoming ZIP value
$total = (isset($_POST["total"])) ? $_POST["total"] : "";  // the incoming ORDER TOTAL
$dClass = (isset($_POST["dClass"])) ? $_POST["dClass"] : "";  // the incoming departure flight class (0 = Coach, 1 = 1st Class)
$rClass = (isset($_POST["rClass"])) ? $_POST["rClass"] : "";  // the incoming return flight class (0 = Coach, 1 = 1st Class)
$cid = (isset($_COOKIE["cid"])) ? $_COOKIE["cid"] : "";  // the cid cookie value
$dflight = "";  // variable used to hold some HTML code for the DEPARTURE FLIGHT
$rflight = "";  // variable used to hold some HTML code for the RETURN FLIGHT
$travelerSummary = "";  // variable used to hold some HTML code for the TRAVELER SUMMARY
$result = "";  // variable used to hold the result
$resultMessage = "";  // variable used to hold the result message
$orderDate = "";  // variable used to hold the order date of the reservation
$htmlOrderNum = "";  // variable used to hold the HTML for the order number of the reservation
$dAvailable = 0; // variable used to hold the available number of tickets for the departure flight
$rAvailable = 0; // variable used to hold the available number of tickets for the return flight
$successfulOrder = true; // boolean variable used to tell if the order is successful or not
$within7DaysPrice = 0.00; // variable that holds the fee amount if the departure date is within 7 days
$pTotal = 0;  // variable that holds the current passenger's TOTAL PRICE
$taxes = 8;  // variable that holds the TAX rate percentage
$count = 1; // a counter variable
$emailList = array(); // an array that holds all the emails to send the ORDER SUMMARY

/* Redirect if not from the correct page */
if ($_SERVER['HTTP_REFERER'] == "http://transamericanair.selfip.com/billing.php")
{; /* do nothing */}
else
{
	/* Redirect the browser */
	header("Location: http://transamericanair.selfip.com/");
}


// get the DEPARTURE flight ID and class information
list($dfid, $dClass) = explode('-', $in_dflight);

// get the RETURN flight ID and class information
list($rfid, $rClass) = explode('-', $in_rflight);


// Read from the database
$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

/* Get the Result of the Order */

// make sure that the tickets are still available
if ($in_trip == 2) // round trip
{
	$query = "SELECT `cAvailable`, `fcAvailable` FROM `Flight` WHERE `fid` IN (:dfid, :rfid)";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':dfid' => $dfid, ':rfid' => $rfid));
}
else // one way trip
{
	$query = "SELECT `cAvailable`, `fcAvailable` FROM `Flight` WHERE `fid` IN (:dfid)";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':dfid' => $dfid));
}


// set the departure class to the correct value
if ($dClass == 0)
{
	$dClassValue = "Coach";
}
else
{
	$dClassValue = "1<sup>st</sup> Class";
}

// set the return class to the correct value
if ($rClass == 0)
{
	$rClassValue = "Coach";
}
else
{
	$rClassValue = "1<sup>st</sup> Class";
}


/* Bind variables by column name */
$stmt->bindColumn('cAvailable', $cAvailable);
$stmt->bindColumn('fcAvailable', $fcAvailable);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	// check the departure flight values
	if ($count == 1)
	{
		if ($dClass == 0) // Coach
		{
			if ( ($cAvailable - $in_quantity) < 0)
			{
				$successfulOrder = false;
			}
		}
		else // 1st Class
		{
			if ( ($fcAvailable - $in_quantity) < 0 )
			{
				$successfulOrder = false;
			}
		}
	}
	else // check the return flight values
	{
		if ($rClass == 0) // Coach
		{
			if ( ($cAvailable - $in_quantity) < 0)
			{
				$successfulOrder = false;
			}
		}
		else // 1st Class
		{
			if ( ($fcAvailable - $in_quantity) < 0 )
			{
				$successfulOrder = false;
			}
		}
	}
	
	$count++;
}


/* RESULT was Unsuccessful */
if (!$successfulOrder)
{
	// update the result title
	$result = '<span class="fail">Unsucessful Reservation!</span>';
	
	// don't show an order number
	$htmlOrderNum = "";
	
	// update the message to the user
	$resultMessage = "Sorry, one of your selected flights is no longer available for the amount of tickets that you're trying to reserve. If you'd still like to purchase tickets, please select a lower quantity.";
	
	/* Print the HTML code for the page header */
	require($INC_DIR."header.php");
	
	/* Print the HTML code for the page body */
	require($INC_DIR."submit.php");

	/* Print the HTML code for the page footer */
	require($INC_DIR."footer.php");
	
	exit;
}

/* RESULT was Successful */

// update the result title
$result = '<span class="sucess">Successful Reservation!</span>';

// set the timezone
date_default_timezone_set("America/Chicago");

// set the order date
$orderDate = date("Y-m-d");

// create the HTML for the order number
$htmlOrderNum = '<tr><td class="submit"><br><br>Thank you for your reservation! 
<br><br>Your order number is: '.$orderNum.'
<br><br>You will receive a confirmation email shortly with your order details.
<br><br>Please keep your order number for your personal records.
<br><br>Order Reservation Summary Information: <a target="_blank" href="http://transamericanair.selfip.com/check.php?orderCheck='.$orderNum.'">Your Order Reservation</a>
<br><u>Note:</u> You should print and keep a copy of your order reservation summary information!</td></tr>';


/* Insert the Flight Reservation into the Database */
$query = "INSERT INTO `Reservation` (`orderNum`, `cid`, `dfid`, `rfid`, `qty`, `cardFirstName`, `cardMiddleName`, `cardLastName`, `cardType`, `cardNum`, `cardMonth`, `cardYear`, `address`, `city`, `state`, `zip`, `orderDate`) VALUES (:orderNum, :cid, :dfid, :rfid, :qty, :cardFirstName, :cardMiddleName, :cardLastName, :cardType, :cardNum, :cardMonth, :cardYear, :address, :city, :state, :zip, :orderDate)";
$stmt = $db->prepare($query);
$stmt->execute(array(':orderNum' => $orderNum, ':cid' => $cid, ':dfid' => $in_dflight, ':rfid' => $in_rflight, ':qty' => $in_quantity, ':cardFirstName' => $in_cardFirstName, ':cardMiddleName' => $in_cardMiddleName, ':cardLastName' => $in_cardLastName, ':cardType' => $in_cardType, ':cardNum' => $in_cardNum, ':cardMonth' => $in_cardMonth, ':cardYear' => $in_cardYear, ':address' => $in_address, ':city' => $in_city, ':state' => $in_state, ':zip' => $in_zip, ':orderDate' => $orderDate));


/* Send The Confirmation Email */

/* Get the Departure Flight Information */
$query = "SELECT `fnumber`, `fdate`, `fDepartTime`, `fArrivalTime` FROM `Flight` WHERE `fid`=:dfid";
$stmt = $db->prepare($query);
$stmt->execute(array(':dfid' => $dfid));

/* Bind variables by column name */
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('fDepartTime', $fDepartTime);
$stmt->bindColumn('fArrivalTime', $fArrivalTime);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	$dflight = '
	<tr class="select display" colspan="100">
		<td>'.$fnumber.'</td>
		<td>'.$fdate.'</td>
		<td>'.$fDepartTime.'</td>
		<td>'.$fArrivalTime.'</td>
		<td>'.$dClassValue.'</td>
	</tr>';
}


/* Get the Return Flight Information */
$rflight = '<tr class="select display"><td colspan="100">No Return Flight Selected</td></tr>';

// get the return flight only if it's a round trip
if ($in_trip == 2)
{
	$query = "SELECT `fnumber`, `fdate`, `fDepartTime`, `fArrivalTime` FROM `Flight` WHERE `fid`=:rfid";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':rfid' => $rfid));

	/* Bind variables by column name */
	$stmt->bindColumn('fnumber', $fnumber);
	$stmt->bindColumn('fdate', $fdate);
	$stmt->bindColumn('fDepartTime', $fDepartTime);
	$stmt->bindColumn('fArrivalTime', $fArrivalTime);

	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
	{
		$rflight = '
		<tr class="select display" colspan="100">
			<td>'.$fnumber.'</td>
			<td>'.$fdate.'</td>
			<td>'.$fDepartTime.'</td>
			<td>'.$fArrivalTime.'</td>
			<td>'.$rClassValue.'</td>
		</tr>';
	}
}

/* Get the Order Summary Information */

// read from the database
$query = "SELECT `tfirstname`,`tmiddlename`, `tlastname`, `email`, `address`, `city`, `state`, `zip`, `phone`, `passport`, `dob`, `type`, `addBags` FROM `Traveler` WHERE `orderNum`=:orderNum";
$stmt = $db->prepare($query);
$stmt->execute(array(':orderNum' => $orderNum));

/* Bind variables by column name */
$stmt->bindColumn('tfirstname', $tfirstname);
$stmt->bindColumn('tmiddlename', $tmiddlename);
$stmt->bindColumn('tlastname', $tlastname);
$stmt->bindColumn('email', $email);
$stmt->bindColumn('address', $address);
$stmt->bindColumn('city', $city);
$stmt->bindColumn('state', $state);
$stmt->bindColumn('zip', $zip);
$stmt->bindColumn('phone', $phone);
$stmt->bindColumn('passport', $passport);
$stmt->bindColumn('dob', $dob);
$stmt->bindColumn('type', $type);
$stmt->bindColumn('addBags', $addBags);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	// fix the empty date of birth for printing
	if ($dob == "0000-00-00")
	{
		$dob = "";
	}
	
	// calculate the ticket prices of the passenger
	
	// set the current passenger's total to zero
	$pTotal = 0;
	
	// calculate the departure flight ticket price
	if ($dClass == 0) // Coach
	{
		if ($type == "Adult")
		{
			$pTotal += 99.99;
		}
		if ($type == "Child")
		{
			$pTotal += 49.99;
		}
		if ($type == "Senior Citizen")
		{
			$pTotal += 69.99;
		}
		if ($type == "Infant in seat")
		{
			$pTotal += 49.99;
		}
		if ($type == "Infant in lap")
		{
			$pTotal += 9.99;
		}
	}
	else // 1st Class
	{
		if ($type == "Adult")
		{
			$pTotal += 189.99;
		}
		if ($type == "Child")
		{
			$pTotal += 69.99;
		}
		if ($type == "Senior Citizen")
		{
			$pTotal += 99.99;
		}
		if ($type == "Infant in seat")
		{
			$pTotal += 49.99;
		}
		if ($type == "Infant in lap")
		{
			$pTotal += 29.99;
		}
	}
	
	// calculate the return flight ticket price
	
	// make sure this is a 2 way round trip
	if ($in_trip == 2)
	{
		if ($rClass == 0) // Coach
		{
			if ($type == "Adult")
			{
				$pTotal += 99.99;
			}
			if ($type == "Child")
			{
				$pTotal += 49.99;
			}
			if ($type == "Senior Citizen")
			{
				$pTotal += 69.99;
			}
			if ($type == "Infant in seat")
			{
				$pTotal += 49.99;
			}
			if ($type == "Infant in lap")
			{
				$pTotal += 9.99;
			}
		}
		else // 1st Class
		{
			if ($type == "Adult")
			{
				$pTotal += 189.99;
			}
			if ($type == "Child")
			{
				$pTotal += 69.99;
			}
			if ($type == "Senior Citizen")
			{
				$pTotal += 99.99;
			}
			if ($type == "Infant in seat")
			{
				$pTotal += 49.99;
			}
			if ($type == "Infant in lap")
			{
				$pTotal += 29.99;
			}
		}
	}
	
	// calculate the additional bag prices
	$pTotal += ($addBags*(49.99));
	
	// display the passenger total with 2 decimal places
	$pTotal = sprintf("%.2f", $pTotal);
	
	// add the email to the email array if it's not empty
	if ($email != "")
	{
		array_push($emailList, $email);
	}
	
	// create the HTML for the traveler
	$travelerSummary .= '
	<tr class="select display">
		<td>'.$tfirstname.'</td>
		<td>'.$tmiddlename.'</td>
		<td>'.$tlastname.'</td>
		<td>'.$email.'</td>
		<td>'.$address.'</td>
		<td>'.$city.'</td>
		<td>'.$state.'</td>
		<td>'.$zip.'</td>
		<td>'.$phone.'</td>
		<td>'.$passport.'</td>
		<td>'.$dob.'</td>
		<td>'.$type.'</td>
		<td>'.$addBags.'</td>
		<td>$'.$pTotal.'</td>
	</tr>';
}


// see if the date is within 7 days
$now = date('Y-m-d');
$start = strtotime($now);
$end = strtotime($in_ddate);

// calculate the difference (the server time is off by one day)
$dateDiff = ceil(abs($end - $start) / 86400)+1;

// if the departure date is within a 7 days, then a fee is added
if ($dateDiff < 7)
{
	$within7DaysPrice = 25;
}

// display the numbers with 2 decimal places
$within7DaysPrice = sprintf("%.2f", $within7DaysPrice);
$taxes = sprintf("%.2f", $taxes);


for ($i=0; $i < count($emailList); $i++)
{
	// get the current email address
	$email = $emailList[$i];
	
	// setup the email variables
	$to = $email;
	$from = 'sales@transamericanair.com';
	$subject = 'Your Flight Reservation Order Summary | Trans American Airlines';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'To: <'.$email.'>' . "\r\n";
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
			
			p font {
				font-weight:800;
				text-decoration:underline;
				color:#008800;
				margin-bottom:20px;
			}
			
			table {
				border:2px solid #000000;
				font:bold 15px Arial;
				width:500px;
				text-align:left;
			}
			
			table tr {
				border:2px solid #000000;
			}
			
			.select { 
				text-align: center; 
				background-color:#030085; 
				border:1px #E0E0E0 solid; 
				font-size: 12px; 
				font-family: Arial, Verdana, sans-serif; 
				color: #FFFFFF; 
				cursor: auto;
			}
			
			.selectlimit { 
				text-align: center; 
				background-color:#FFFFFF; 
				font-size: 12px; 
				font-family: Arial, Verdana, sans-serif; 
				font-weight: bold; 
				color: #030085;
			}
			
			.searchlimit { 
				text-align: center; 
				background-color:#FFFFFF; 
				font-size: 16px; 
				font-family: Arial, Verdana, sans-serif; 
				font-weight: bold; 
				color: #030085;
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
				<h2>Thank you for your reservation!</h2>
				<p>Here\'s your Flight Reservation information. Your Order Number is: <font>'.$orderNum.'</font>:</p>
				<br><br>
				<table align="center" style="width:100%" cellpadding="5">
					<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Your Departure Flight:</span></td></tr>
					<tr class="selectlimit" colspan="100" style="height:25px;">
						<td>Flight Number</td>
						<td>Flight Date</td>
						<td>Flight Time</td>
						<td>Class</td>
						<td colspan="3">Price</td>
					</tr>
					'.$dflight.'
					<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Your Return Flight:</span></td></tr>
					<tr class="selectlimit" colspan="100" style="height:25px;">
						<td>Flight Number</td>
						<td>Flight Date</td>
						<td>Flight Time</td>
						<td>Class</td>
						<td colspan="3">Price</td>
					</tr>
					'.$rflight.'
					<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Your Flight Reservation Summary:</span></td></tr>
					<tr class="selectlimit" style="height:25px;">
						<td>First Name</td>
						<td>Last Name</td>
						<td>Email</td>
						<td>Shipping Address</td>
						<td>Ticket Quantity</td>
						<td>Discount</td>
						<td>Total</td>
					</tr>
					'.$travelerSummary.'
				</table>
				<br><br>
				<span>If you have any questions, please contact us at sales@transamericanair.com</span>
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

/* Update the Flight Availability Lists */

// Update the departure flight availability number
if ($dClass == 0) // if the departure class is Coach
{
	$query = "SELECT `cAvailable` FROM `Flight` WHERE `fid`=:dfid";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':dfid' => $dfid));

	/* Bind variables by column name */
	$stmt->bindColumn('cAvailable', $cAvailable);

	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
	{
		$dAvailable = intval($cAvailable) - intval($in_quantity);
	}

	// Update the departure flight availability
	$query = "UPDATE `Flight` SET `cAvailable`=:dAvailable WHERE `fid`=:dfid";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':dAvailable' => $dAvailable, ':dfid' => $dfid));
}
else // if the departure class is 1st Class
{
	$query = "SELECT `fcAvailable` FROM `Flight` WHERE `fid`=:dfid";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':dfid' => $dfid));

	/* Bind variables by column name */
	$stmt->bindColumn('fcAvailable', $fcAvailable);

	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
	{
		$dAvailable = intval($fcAvailable) - intval($in_quantity);
	}

	// Update the departure flight availability
	$query = "UPDATE `Flight` SET `fcAvailable`=:dAvailable WHERE `fid`=:dfid";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':dAvailable' => $dAvailable, ':dfid' => $dfid));
}

// Update the return flight availability number

// make sure it's a round trip flight
if ($in_trip == 2)
{
	if ($rClass == 0) // if the return class is Coach
	{
		$query = "SELECT `cAvailable` FROM `Flight` WHERE `fid`=:rfid";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':rfid' => $rfid));

		/* Bind variables by column name */
		$stmt->bindColumn('cAvailable', $cAvailable);

		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			$rAvailable = intval($cAvailable) - intval($in_quantity);
		}

		// Update the return flight availability
		$query = "UPDATE `Flight` SET `cAvailable`=:rAvailable WHERE `fid`=:rfid";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':rAvailable' => $rAvailable, ':rfid' => $rfid));
	}
	else // if the return class is 1st Class
	{
		$query = "SELECT `fcAvailable` FROM `Flight` WHERE `fid`=:rfid";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':rfid' => $rfid));

		/* Bind variables by column name */
		$stmt->bindColumn('fcAvailable', $fcAvailable);

		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			$rAvailable = intval($fcAvailable) - intval($in_quantity);
		}

		// Update the departure flight availability
		$query = "UPDATE `Flight` SET `fcAvailable`=:rAvailable WHERE `fid`=:rfid";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':rAvailable' => $rAvailable, ':rfid' => $rfid));
	}
}

/* Print the HTML code for the page header */
require($INC_DIR."header.php");


/* Print the HTML code for the page body */
require($INC_DIR."submit.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>