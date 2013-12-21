<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Billing Information | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "submit.php";
$onsubmit = "return isValid('b')";
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
$dClass = (isset($_POST["dClass"])) ? $_POST["dClass"] : "";  // the incoming departure flight class (0 = Coach, 1 = 1st Class)
$rClass = (isset($_POST["rClass"])) ? $_POST["rClass"] : "";  // the incoming return flight class (0 = Coach, 1 = 1st Class)
$total = (isset($_POST["total"])) ? $_POST["total"] : "";  // the incoming ORDER TOTAL
$orderNum = (isset($_POST["orderNum"])) ? $_POST["orderNum"] : "";  // the incoming ORDER NUMBER value
$cdata = (isset($_COOKIE["cdata"])) ? $_COOKIE["cdata"] : "";  // the cdata cookie value
$cid = (isset($_COOKIE["cid"])) ? $_COOKIE["cid"] : "";  // the cid cookie value
$dob = "";  // the combined incoming values of the DATE OF BIRTH month,day,year
$states = ""; // variable used to hold the HTML code for the states
$cardTypes = ""; // variable used to hold the HTML code for the credit card type
$ORDER_NUM_DIGITS = 11; // variable used to hold the number of digits in the order number
$NUM_MONTHS = 12; // variable used to hold the number of months
$CURRENT_YEAR = 2013;  // variable used to hold the current year value
$CARD_YEARS = 10; // variable used to hold the number of years past the current year to allow for the credit card

/* Redirect if not from the correct page */
if ($_SERVER['HTTP_REFERER'] != "http://transamericanair.selfip.com/confirm.php")
{
	/* Redirect the browser */
	header("Location: http://transamericanair.selfip.com/");
}


// create the array of states
$statesArray = array("Alabama", "Alaska", "Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");

// the HTML for the states
for($i=0; $i < count($statesArray); $i++)
{
	$states .= '<option value="'.$statesArray[$i].'">'.$statesArray[$i].'</option>';
}

// create the array for the credit card types
$cardTypesArray = array("Visa", "Discovery", "American Express", "Master Card");

// the HTML for the credit card types
for($i=0; $i < count($cardTypesArray); $i++)
{
	$cardTypes .= '<option value="'.$cardTypesArray[$i].'">'.$cardTypesArray[$i].'</option>';
}


// set the timezone
date_default_timezone_set("America/Chicago");

// update the $CURRENT_YEAR to the current year
$CURRENT_YEAR = (int) date("Y");


/* Create the HTML CARD MONTH list */
$htmlCardMonthList = array();

for ($i=1; $i <= $NUM_MONTHS; $i++)
{
	$monthName = date("F", mktime(0, 0, 0, $i, 22, $CURRENT_YEAR));
	array_push($htmlCardMonthList, '<option value="'.$i.'">'.$monthName.' ('.$i.')</option>');
}


/* Create the HTML CARD YEAR list */
$htmlCardYearList = array();

for ($i=0; $i < $CARD_YEARS; $i++)
{
	$year = intval(date("Y", mktime(0, 0, 0, 8, 22, $CURRENT_YEAR+$i)));
	array_push($htmlCardYearList, '<option value="'.$year.'">'.$year.'</option>');
}


/* Print the HTML code for the page header */
require($INC_DIR."header.php");


/* Print the HTML code for the page body */
require($INC_DIR."billing.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>
