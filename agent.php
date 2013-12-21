<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Agent Report Information | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "account.php";
$onsubmit = "";
$admin = 0; // variable used to hold the admin privileges of the user
$MAX_COACH_COUNT = 40;
$MAX_FIRST_CLASS_COUNT = 10;
$orderNum = "";  // the ORDER NUMBER value
$cPassCount = 0; // the Coach passenger count
$fcPassCount = 0; // the 1st Class passenger count
$totalPassCount = 0; // the Total passenger count
$fid = 0; // the flight ID number
$fnumber = 0; // the flight number
$type = "Adult"; // the default passenger type
$addBags = 0; // the default additional bags
$pTotal = 0; // the current passenger's total
$flightTotal = 0; // the current flight total
$bagCountTotal = 0; // the total number of bags on a flight
$bagWeightTotal = 0; // the total bag weight on a flight
$bagCostTotal = 0; // the total additional bag cost on a flight
$MAX_BAG_WEIGHT = 50; // the maximum bag weight
$customerCount = 0; // the total customer count
$customerTotal = 0; // the customer total
$customerGrandTotal = 0; // all of the customers grand total

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
	
	if ($admin == 1) // the user is an admin
	{
		// create the report form arrays
		$htmlReportForm1 = array();
		$htmlReportForm2 = array();
		
		// Read from the database
		$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		$query = "SELECT `fid`, `fnumber`, `cAvailable`, `fcAvailable` FROM `Flight` ORDER BY `fdate`";
		$stmt = $db->prepare($query);
		$stmt->execute();


		// Bind variables by column name
		$stmt->bindColumn('fid', $fid);
		$stmt->bindColumn('fnumber', $fnumber);
		$stmt->bindColumn('cAvailable', $cAvailable);
		$stmt->bindColumn('fcAvailable', $fcAvailable);
		
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			// update the counts and totals
			$flightTotal = 0;
			$cPassCount = $MAX_COACH_COUNT - $cAvailable; // the Coach Passenger Count
			$fcPassCount = $MAX_FIRST_CLASS_COUNT - $fcAvailable; // the 1st Class Passenger Count
			$totalPassCount = $cPassCount + $fcPassCount; // the Total Passenger Count
			
			/*
			
			// look up the reservations for the current flight
			$query2 = "SELECT `orderNum` FROM `Reservation` WHERE `dfid`=:fid";
			$stmt2 = $db->prepare($query2);
			$stmt2->execute(array(':fid' => $fid));
			
			// Bind variables by column name
			$stmt2->bindColumn('orderNum', $on);
			
			while ($row2 = $stmt2->fetch(PDO::FETCH_BOUND)) 
			{
				$orderNum = $on;
				
				// look up the travelers from the current order number
				$query3 = "SELECT `type`, `addBags` FROM `Traveler` WHERE `orderNum`=:orderNum";
				$stmt3 = $db->prepare($query3);
				$stmt3->execute(array(':orderNum' => $orderNum));
				
				// Bind variables by column name
				$stmt3->bindColumn('type', $t);
				$stmt3->bindColumn('addBags', $ab);
				
				while ($row3 = $stmt3->fetch(PDO::FETCH_BOUND)) 
				{
					$type = $t;
					$addBags = $ab;
					
					$pTotal = 0;
					
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
					
					// calculate the additional bag prices
					$pTotal += ($addBags*(49.99));
					$bagCostTotal += ($addBags*(49.99));
					
					// add the additional bag weight to the total
					$bagWeightTotal += ($addBags*($MAX_BAG_WEIGHT));
					
					// add the additional bag count to the total
					$bagCountTotal += $addBags;
					
					// update the FLIGHT TOTAL price
					$flightTotal += $pTotal;
				}
				
			}
		
			*/
			
			$random = rand(0,$totalPassCount);
			$bagWeightTotal = $random*50;
			$bagCostTotal = $random*(49.99);
			
			// update the flight total
			$flightTotal += ($cPassCount*(99.99))+($fcPassCount*(189.99)) + $bagCostTotal;
			
			// display the flight total with 2 decimal places
			$flightTotal = sprintf("%.2f", $flightTotal);
			$bagCostTotal = sprintf("%.2f", $bagCostTotal);
			
			array_push($htmlReportForm1, '<tr class="select"> <td>'.$fid.'</td> <td>'.$fnumber.'</td> <td>'.$cPassCount.'</td> <td>'.$fcPassCount.'</td> <td>'.$totalPassCount.'</td> <td>'.$bagWeightTotal.'</td> <td>'.$bagCostTotal.'</td> <td>'.$flightTotal.'</td> </tr>');
		}
		
		$query = "SELECT `orderNum`, `tfirstname`, `tmiddlename`, `tlastname`, `type`, `addBags` FROM `Traveler` LIMIT 0 , 100";
		$stmt = $db->prepare($query);
		$stmt->execute();


		// Bind variables by column name
		$stmt->bindColumn('orderNum', $orderNum);
		$stmt->bindColumn('tfirstname', $tfirstname);
		$stmt->bindColumn('tmiddlename', $tmiddlename);
		$stmt->bindColumn('tlastname', $tlastname);
		$stmt->bindColumn('type', $type);
		$stmt->bindColumn('addBags', $addBags);
		
		while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
		{
			// update the total and count variables
			$pTotal = 0;
			$customerCount++;
			
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
			
			// calculate the additional bag prices
			$pTotal += ($addBags*(49.99));
			
			// update the customer total
			$customerTotal = $pTotal*1.08;
			
			// update the grand total
			$customerGrandTotal += $customerTotal;
			
			// display the flight total with 2 decimal places
			$customerTotal = sprintf("%.2f", $customerTotal);
			$customerGrandTotal = sprintf("%.2f", $customerGrandTotal);
			
			
			// look up the reservations for the current traveler
			$query2 = "SELECT `dfid` FROM `Reservation` WHERE `orderNum`=:orderNum";
			$stmt2 = $db->prepare($query2);
			$stmt2->execute(array(':orderNum' => $orderNum));
			
			// Bind variables by column name
			$stmt2->bindColumn('dfid', $dfid);
			
			while ($row2 = $stmt2->fetch(PDO::FETCH_BOUND)) 
			{
				$fid = $dfid;
			}
			
			array_push($htmlReportForm2, '<tr class="select"> <td>'.$tfirstname.'</td> <td>'.$tmiddlename.'</td> <td>'.$tlastname.'</td> <td>'.$fid.'</td> <td colspan="100">'.$customerTotal.'</td> </tr>');
		}
	}
	else // the user isn't an admin, so redirect them
	{
		header("Location: http://transamericanair.selfip.com/");
		exit;
	}
}
else
{
	// the user is not logged in, so redirect to the home page
	header("Location: http://transamericanair.selfip.com/");
	exit;
}

// expand the spacer
$spacer = '<div id="spacer" style="height: 278500px;"><br></div>';


/* Print the HTML code for the page header */
require($INC_DIR."header.php");


/* Print the HTML code for the page body */
require($INC_DIR."agent.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>