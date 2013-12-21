<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Select Departure Flight | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "selectrf.php";
$onsubmit = "return isValid('sdf')";
$continue = '<input type="submit" title="Continue To Select Your Return Flight" value="Continue" />';
$in_orig  = $_POST["from"];  // the incoming FROM value
$in_dest  = $_POST["to"];  // the incoming TO value
$in_ddate = $_POST["ddate"];  // the incoming DESTINATION DATE value
$in_rdate = $_POST["rdate"];  // the incoming RETURNING DATE value
$in_quantity = $_POST["quantity"];  // the incoming TRAVELERS ticket quantity value
$in_trip = $_POST["trip"];  // the incoming TRIP value (1 = one way trip, 2 = round trip)
$code = "";  // variable used to hold some HTML code
$count = 0; // a counter variable

// Create the HTML Coach Flight List
$htmlCoachFlightList = array();

// Create the HTML First Class Flight List
$htmlFirstClassFlightList = array();

// correctly format the date values for the database query (yyyy-mm-dd)

// the departure date
$dDateArray = explode('/', $in_ddate);
$in_ddate = $dDateArray[2]."-".$dDateArray[0]."-".$dDateArray[1];

// the return date
$rDateArray = explode('/', $in_rdate);
$in_rdate = $rDateArray[2]."-".$rDateArray[0]."-".$rDateArray[1];


/* Print the HTML code for the page header */
require($INC_DIR."header.php");


// Read from the database
$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

/* Get the origin city information */
$query = "SELECT `title`, `state` FROM `City` WHERE `cityid`=:1";
$stmt = $db->prepare($query);
$stmt->execute(array(':1' => $in_orig));
$result = $stmt->fetch();

$origCity = $result[0];
$origState = $result[1];

/* Get the destination city information */
$query = "SELECT `title`, `state` FROM `City` WHERE `cityid`=:dest";
$stmt = $db->prepare($query);
$stmt->execute(array(':dest' => $in_dest));
$result = $stmt->fetch();

$destCity = $result[0];
$destState = $result[1];

/* Get the flight information for the available COACH seats */
$query = "SELECT `fid` , `fnumber` , `fdate` , `fDepartTime` , `fArrivalTime` , `cAvailable` , `fcAvailable`, `orig` , `dest` FROM `Flight` WHERE `fdate`=:date AND `orig` =:orig AND `dest` =:dest AND `cAvailable` >=:quantity ORDER BY `fDepartTime`";
$stmt = $db->prepare($query);
$stmt->execute(array(':date' => $in_ddate, ':orig' => $in_orig, ':dest' => $in_dest, ':quantity' => $in_quantity));


/* Bind variables by column name */
$stmt->bindColumn('fid', $fid);
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('fDepartTime', $fDepartTime);
$stmt->bindColumn('fArrivalTime', $fArrivalTime);
$stmt->bindColumn('cAvailable', $cAvailable);
$stmt->bindColumn('fcAvailable', $fcAvailable);
$stmt->bindColumn('orig', $orig);
$stmt->bindColumn('dest', $dest);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	// the available Coach seats
	if ($cAvailable >= $in_quantity)
	{
		$code = '
		<tr class="select" id="row_'.$count.'" onclick="select('.$count.',\'s\')">
			<td><input type="radio" name="radio" id="radio_'.$count.'" value="'.$fid.'-0" /></td>
			<td>'.$fnumber.'</td>
			<td>'.$fdate.'</td>
			<td>'.$fDepartTime.'</td>
			<td>'.$fArrivalTime.'</td>
			<td>'.$cAvailable.'</td>
			<td>'.$origCity.', '.$origState.'</td>
			<td>'.$destCity.', '.$destState.'</td>
			<td>Coach</td>
		</tr>';
		
		array_push($htmlCoachFlightList, $code);
	}
	
	// update the counter
	$count++;
}


/* Get the flight information for the available FIRST CLASS seats */
$query = "SELECT `fid` , `fnumber` , `fdate` , `fDepartTime` , `fArrivalTime` , `cAvailable` , `fcAvailable`, `orig` , `dest` FROM `Flight` WHERE `fdate`=:date AND `orig` =:orig AND `dest` =:dest AND `fcAvailable` >=:quantity ORDER BY `fDepartTime`";
$stmt = $db->prepare($query);
$stmt->execute(array(':date' => $in_ddate, ':orig' => $in_orig, ':dest' => $in_dest, ':quantity' => $in_quantity));


/* Bind variables by column name */
$stmt->bindColumn('fid', $fid);
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('fDepartTime', $fDepartTime);
$stmt->bindColumn('fArrivalTime', $fArrivalTime);
$stmt->bindColumn('cAvailable', $cAvailable);
$stmt->bindColumn('fcAvailable', $fcAvailable);
$stmt->bindColumn('orig', $orig);
$stmt->bindColumn('dest', $dest);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	// the available First Class seats
	if ($fcAvailable >= $in_quantity)
	{
		$code = '
		<tr class="select" id="row_'.$count.'" onclick="select('.$count.',\'s\')">
			<td><input type="radio" name="radio" id="radio_'.$count.'" value="'.$fid.'-1" /></td>
			<td>'.$fnumber.'</td>
			<td>'.$fdate.'</td>
			<td>'.$fDepartTime.'</td>
			<td>'.$fArrivalTime.'</td>
			<td>'.$fcAvailable.'</td>
			<td>'.$origCity.', '.$origState.'</td>
			<td>'.$destCity.', '.$destState.'</td>
			<td>1<sup>st</sup> Class</td>
		</tr>';
		
		array_push($htmlFirstClassFlightList, $code);
	}
	
	// update the counter
	$count++;
}


if ( (count($htmlCoachFlightList) == 0) && (count($htmlFirstClassFlightList) == 0) )
{
	$code = '<tr style="cursor:auto;"><td colspan="100">Sorry, no Departure Fights are available for your date and locations.</td></tr>';
	array_push($htmlCoachFlightList, $code);
	$continue = "";
}


/* Print the HTML code for the page body */
require($INC_DIR."selectdf.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");

?>