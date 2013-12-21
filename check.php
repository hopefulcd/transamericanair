<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Reservation Lookup | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "submit.php";
$onsubmit = "";
$orderNum = (isset($_GET["orderCheck"])) ? $_GET["orderCheck"] : "";  // the incoming RESERVATION ORDER NUMBER value
$dflight = "";  // variable used to hold some HTML code for the DEPARTURE FLIGHT
$rflight = "";  // variable used to hold some HTML code for the RETURN FLIGHT
$travelerSummary = "";  // variable used to hold some HTML code for the TRAVELER SUMMARY
$in_dflight = ""; // the dfid of the Order from the Database
$in_rflight = ""; // the rfid of the Order from the Database
$in_trip = 1; // // variable used to hold the TRIP value (1 = one way trip, 2 = round trip)
$in_quantity = 0;  // variable used to hold the TRAVELERS TICKET QUANTITY
$in_ddate = "";  // the DESTINATION DATE value
$in_rdate = "";  // the RETURNING DATE value
$total = 0;  // variable that holds the ORDER TOTAL PRICE
$taxes = 8;  // variable that holds the TAX rate percentage
$cid = (isset($_COOKIE["cid"])) ? $_COOKIE["cid"] : "";  // the cid cookie value
$SPACE_AMOUNT = 90; // defines how much vertical pixel white space to show per traveler below the traveler table
$EXTRA_SPACE = 20; // defines how much total extra pixel white space is created by the spacer that should be deleted
$within7DaysPrice = 0.00; // variable that holds the fee amount if the departure date is within 7 days


/* Redirect if the order number is empty */
if ($orderNum == "")
{
	/* Redirect the browser */
	header("Location: http://transamericanair.selfip.com/");
}


// Read from the database
$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

/* Get the Departure and Return Flight IDs */
$query = "SELECT `dfid`, `rfid` FROM `Reservation` WHERE `orderNum`=:orderNum";
$stmt = $db->prepare($query);
$stmt->execute(array(':orderNum' => $orderNum));

/* Bind variables by column name */
$stmt->bindColumn('dfid', $dfid);
$stmt->bindColumn('rfid', $rfid);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	$in_dflight = $dfid;
	$in_rflight = $rfid;
}


// redirect if the dflight was not found
if ($in_dflight == "")
{
	/* Redirect the browser */
	header("Location: http://transamericanair.selfip.com/");
}

// update the trip variable if a return flight exists
if ($in_rflight != "")
{
	$in_trip = 2;
}

// get the DEPARTURE flight ID and class information
list($dfid, $dClass) = explode('-', $in_dflight);

// set the departure class to the correct value
if ($dClass == 0)
{
	$dClassValue = "Coach";
}
else
{
	$dClassValue = "1<sup>st</sup> Class";
}

// get the RETURN flight ID and class information
list($rfid, $rClass) = explode('-', $in_rflight);

// set the return class to the correct value
if ($rClass == 0)
{
	$rClassValue = "Coach";
}
else
{
	$rClassValue = "1<sup>st</sup> Class";
}

/* Get the Departure Flight Information */
$query = "SELECT `fnumber`, `fdate`, `fDepartTime`,`fArrivalTime` FROM `Flight` WHERE `fid`=:fid";
$stmt = $db->prepare($query);
$stmt->execute(array(':fid' => $dfid));

/* Bind variables by column name */
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('fDepartTime', $fDepartTime);
$stmt->bindColumn('fArrivalTime', $fArrivalTime);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	$in_ddate = $fdate;
	
	$dflight = '
	<tr class="select display" colspan="100">
		<td colspan="3">'.$fnumber.'</td>
		<td colspan="3">'.$fdate.'</td>
		<td colspan="3">'.$fDepartTime.'</td>
		<td colspan="3">'.$fArrivalTime.'</td>
		<td colspan="2">'.$dClassValue.'</td>
	</tr>';
}

/* Get the Return Flight Information */
$rflight = '<tr class="select display"><td colspan="100">No Return Flight Selected</td></tr>';

$query = "SELECT `fnumber`, `fdate`, `fDepartTime`,`fArrivalTime` FROM `Flight` WHERE `fid`=:fid";
$stmt = $db->prepare($query);
$stmt->execute(array(':fid' => $rfid));

/* Bind variables by column name */
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('fDepartTime', $fDepartTime);
$stmt->bindColumn('fArrivalTime', $fArrivalTime);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	$in_rdate = $fdate;
	
	$rflight = '
	<tr class="select display" colspan="100">
		<td colspan="3">'.$fnumber.'</td>
		<td colspan="3">'.$fdate.'</td>
		<td colspan="3">'.$fDepartTime.'</td>
		<td colspan="3">'.$fArrivalTime.'</td>
		<td colspan="2">'.$rClassValue.'</td>
	</tr>';
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
	
	// update the ORDER TOTAL price
	$total += $pTotal;
	
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
	
	// update the total number of tickets bought
	$in_quantity++;
}

// set the timezone
date_default_timezone_set("America/Chicago");

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

// calculate the total with taxes
$total = ($total + $within7DaysPrice) * (1+($taxes/100));

// display the numbers with 2 decimal places
$within7DaysPrice = sprintf("%.2f", $within7DaysPrice);
$taxes = sprintf("%.2f", $taxes);
$total = sprintf("%.2f", $total);

// expand the spacer
$spacer = '<div id="spacer" style="height: '.(($in_quantity)*$SPACE_AMOUNT-$EXTRA_SPACE).'px;"><br></div>';


/* Print the HTML code for the page header */
require($INC_DIR."header.php");


/* Print the HTML code for the page body */
require($INC_DIR."check.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>