<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "The Internet Airline  | Select Your Ticket Quantity";
$description = "Welcome to The Internet Airline! Your one stop source for reserving airline tickets.";
$action = "http://iamun.com/cs416/project/login.php";
$onsubmit = "return isvalid('stq')";
$in_rflight = $_POST["radio"];  // the incoming RETURN FLIGHT value
$in_dflight = $_POST["dflight"];  // the incoming DEPARTURE FLIGHT value
$origCity  = $_POST["origCity"];  // the incoming ORIGIN CITY value
$origState = $_POST["origState"];  // the incoming ORIGIN STATE value
$destCity  = $_POST["destCity"];  // the incoming DESTINATION CITY value
$destState = $_POST["destState"];  // the incoming DESTINATION STATE value
$dflight = "";  // variable used to hold some HTML code for the DEPARTURE FLIGHT
$rflight = "";  // variable used to hold some HTML code for the RETURN FLIGHT

/* Print the HTML code for the page header */
require($INC_DIR."header.php");


// Read from the database
$db = new PDO('mysql:host=localhost;dbname=woodmarc_cs442;charset=utf8', 'woodmarc_cs442', 'cs442');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

/* Get the Departure Flight Information */
$query = "SELECT `fnumber`, `fdate`, `ftime`, `class`, `price` FROM `Flight` WHERE `fid`=:dflight";
$stmt = $db->prepare($query);
$stmt->execute(array(':dflight' => $in_dflight));

/* Bind variables by column name */
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('ftime', $ftime);
$stmt->bindColumn('class', $class);
$stmt->bindColumn('price', $price);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	$dflight = '
	<tr class="select" style="cursor:auto;">
		<td>'.$fnumber.'</td>
		<td>'.$fdate.'</td>
		<td>'.$ftime.'</td>
		<td>'.$class.'</td>
		<td>$'.$price.'</td>
	</tr>';
}

/* Get the Return Flight Information */
$rflight = '<tr class="select" style="cursor:auto;"><td colspan="100">No Return Flight Selected</td></tr>';

$query = "SELECT `fnumber`, `fdate`, `ftime`, `class`, `price` FROM `Flight` WHERE `fid`=:rflight";
$stmt = $db->prepare($query);
$stmt->execute(array(':rflight' => $in_rflight));

/* Bind variables by column name */
$stmt->bindColumn('fnumber', $fnumber);
$stmt->bindColumn('fdate', $fdate);
$stmt->bindColumn('ftime', $ftime);
$stmt->bindColumn('class', $class);
$stmt->bindColumn('price', $price);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	if (isset($in_rflight))
	{
		$rflight = '
		<tr class="select" style="cursor:auto;">
			<td>'.$fnumber.'</td>
			<td>'.$fdate.'</td>
			<td>'.$ftime.'</td>
			<td>'.$class.'</td>
			<td>$'.$price.'</td>
		</tr>';
	}
}


/* Print the HTML code for the page body */
require($INC_DIR."selecttq.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>
