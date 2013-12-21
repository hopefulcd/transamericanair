<?php

/* Create the HTML City List */
$htmlCityList = array();

// Read from the database
$db = new PDO('mysql:host=c-98-193-125-8.hsd1.in.comcast.net;dbname=cs416_project;charset=utf8', 'admin', 'AdminPass');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$query = "SELECT `cityid`, `title`, `state` FROM `City` ORDER BY `title`, `state`";
$stmt = $db->prepare($query);
$stmt->execute();


// Bind variables by column name
$stmt->bindColumn('cityid', $cityid);
$stmt->bindColumn('title', $title);
$stmt->bindColumn('state', $state);

$htmlCityList = array('<option value="NA" selected="selected"></option>');

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) 
{
	array_push($htmlCityList, '<option value="'.$cityid.'">'.$title.', '.$state.'</option>');
}


// Create the HTML Travelers List
$htmlTravelersList = array();

$MAX_TICKET_PURCHASE = 40; // the maximum number of tickets a user can purchase at once

for ($i=1; $i<=$MAX_TICKET_PURCHASE; $i++)
{
	array_push($htmlTravelersList, '<option value="'.$i.'">'.$i.'</option>');
}

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "selectdf.php";
$onsubmit = "return isHomeValid()";

/* Print the HTML code for the page header */
require($INC_DIR."header.php");

/* Print the HTML code for the page body */
require($INC_DIR."home.php");

/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");

?>
