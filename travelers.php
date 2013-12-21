<?php

/* Create the setup variables */
$INC_DIR = "/srv/www/inc/";
$title = "Traveler Information | Trans American Airlines  | Great Ticket Prices, Easy to Use, Award Winning Support";
$description = "Welcome to Trans American Airlines! Your one stop source for reserving airline tickets.";
$action = "confirm.php";
$onsubmit = "return isValid('t')";
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
$in_trip = (isset($_POST["trip"])) ? $_POST["trip"] : 1;  // the incoming TRIP value (1 = one way trip, 2 = round trip)
$cdata = (isset($_COOKIE["cdata"])) ? $_COOKIE["cdata"] : "";  // the cdata cookie value
$cid = (isset($_COOKIE["cid"])) ? $_COOKIE["cid"] : "";  // the cid cookie value
$code = "";  // variable used to hold some HTML code
$spacer = ""; // variable used to hold the spacer HTML code
$count = 1; // a counter variable
$SPACE_AMOUNT = 276; // defines how much pixel white space to show per traveler below the traveler table
$EXTRA_SPACE = 150; // defines how much extra pixel white space is created by the spacer that should be deleted
$DAYS_IN_MONTH = 31;  // variable used to hold the number of days in a month
$NUM_MONTHS = 12;  // variable used to hold the number of months
$MIN_YEAR = 1900;  // variable used to hold the minimum year value
$MAX_YEAR = 2013;  // variable used to hold the maximum year value
$ADD_BAGS_LIMIT = 100;  // variable used to hold the number of additional bags allowed per traveler
$states = ""; // variable used to hold the HTML code for the states
$passengerTypes = ""; // variable used to hold the HTML code for the passenger types
$addBags = ""; // variable used to hold the HTML code for the additional bags

// create the array of states
$statesArray = array("Alabama", "Alaska", "Arizona","Arkansas","California","Colorado","Connecticut","Delaware","District of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");

// create the passenger type arrays
$passengerTypeArray = array("Adult", "Child", "Senior Citizen", "Infant in lap", "Infant in seat");
$passengerTypeAgesArray = array("", "(16 years or younger)", "(65 years or older)", "(2 years or younger)", "(2 years or younger)");

// set the timezone
date_default_timezone_set("America/Chicago");

// update the MAX_YEAR to the current year
$MAX_YEAR = (int) date("Y");


/* Get some variables from the cdata cookie if it exists */
if ($cdata != "")
{
	list($in_dflight, $in_rflight, $in_quantity) = explode('/', $cdata);
}


// update the trip variable if a return flight exists
if ($in_rflight != "")
{
	$in_trip = 2;
}


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


// the HTML for the passenger types
for($i=0; $i < count($passengerTypeArray); $i++)
{
	$passengerTypes .= '<option value="'.$passengerTypeArray[$i].'">'.$passengerTypeArray[$i].' '.$passengerTypeAgesArray[$i].'</option>';
}


// the HTML for the additional bags
for($i=0; $i <= $ADD_BAGS_LIMIT; $i++)
{
	$addBags .= '<option value="'.$i.'">'.$i.'</option>';
}

/* Create the selectable Date of Birth values */

$dobDay = "";
$dobMonth = "";
$dobYear = "";

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





/* Create the Travelers List */

$htmlTravelersList = array();


for ($i=1; $i <= ((int) $in_quantity); $i++) 
{
	$code = '
	<tr><td class="travelerTop"><h3>Traveler '.$count.'</h3></td></tr>
	<tr>
		<td>
			<table class="tTable">
				<tr>	
					<td class="tCell_1">
						<table style="width:350px;">
							
							<tr><td>
								<label for="tfirstname_'.$count.'">First Name: </label>
								<input type="text" id="tfirstname_'.$count.'" name="tfirstname_'.$count.'" placeholder="First Name" />
							</td></tr>
							<tr><td>
								<label for="tmiddlename_'.$count.'">Middle Name: </label>
								<input type="text" id="tmiddlename_'.$count.'" name="tmiddlename_'.$count.'" placeholder="Middle Name" />
							</td></tr>
							<tr><td>
								<label for="tlastname_'.$count.'">Last Name: </label>
								<input type="text" id="tlastname_'.$count.'" name="tlastname_'.$count.'" placeholder="Last Name" />
							</td></tr>
							<tr><td>
								<label for="phone_'.$count.'">Phone: </label>
								<input type="text" id="phone_'.$count.'" name="phone_'.$count.'" placeholder="Phone Number (xxx) xxx-xxxx" />
							</td></tr>
							<tr><td>
								<label for="email_'.$count.'">Email: </label>
								<input type="text" id="email_'.$count.'" name="email_'.$count.'" placeholder="Email Address" />
							</td></tr>
							
						</table>
					</td>
					<td class="tCell_2">
						<table style="width:430px;">
							
							<tr><td>
								<label for="dob_'.$count.'">Date of Birth: </label>
								
								<select class="smallSelect" id="dobMonth_'.$count.'" name="dobMonth_'.$count.'">
									<option value="00"></option>
									'.$dobMonth.'
								</select>
								
								<select class="smallSelect" id="dobDay_'.$count.'" name="dobDay_'.$count.'">
									<option value="00"></option>
									'.$dobDay.'
								</select>
								
								<select class="smallSelect right20" id="dobYear_'.$count.'" name="dobYear_'.$count.'">
									<option value="0000"></option>
									'.$dobYear.'
								</select>
								
							</td></tr>
							
							<tr><td>
								<label for="address_'.$count.'">Address: </label>
								<input type="text" id="address_'.$count.'" name="address_'.$count.'" placeholder="Street Address" />
							</td></tr>
							<tr><td>
								<label for="city_'.$count.'">City: </label>
								<input type="text" id="city_'.$count.'" name="city_'.$count.'" placeholder="City" />
							</td></tr>
							<tr><td>
								<label for="state_'.$count.'">State: </label>
								<select class="normalSelect right20" id="state_'.$count.'" name="state_'.$count.'">
									<option value=""></option>
									'.$states.'
								</select>
							</td></tr>
							<tr><td>
								<label for="zip_'.$count.'">Zip: </label>
								<input type="text" id="zip_'.$count.'" name="zip_'.$count.'" maxlength="5" placeholder="Zip Code" />
							</td></tr>
						
						</table>
					</td>
					<td class="tCell_3">
						<table style="width:400px;">
							
							<tr><td>
								<label for="passport_'.$count.'">Passport: </label>
								<input type="text" id="passport_'.$count.'" name="passport_'.$count.'" maxlength="9" placeholder="Passport Number" />
							</td></tr>
							
							<tr><td>
								<label for="type_'.$count.'">Passenger Type: </label>
								<select class="normalSelect right20" id="type_'.$count.'" name="type_'.$count.'">
									'.$passengerTypes.'
								</select>
							</td></tr>
							<tr><td>
								<label for="addBags_'.$count.'">Additional Bags: </label>
								<select class="smallSelect right20" id="addBags_'.$count.'" name="addBags_'.$count.'">
									'.$addBags.'
								</select>
							</td></tr>
							<tr><td>
								<p class="info"><u>Note:</u> Passengers are allowed 1 carry-on and 2 50lb bags. Additional Bags are $49.99 each. No bags over 50lbs will be allowed.</p>
							</td></tr>
							
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>';
	
	array_push($htmlTravelersList, $code);
	$count++;
}


// expand the spacer when there are 3 or more travelers
if ($count >= 3)
{
	$spacer = '<div id="spacer" style="height: '.(($count-2)*$SPACE_AMOUNT-$EXTRA_SPACE).'px;"><br></div>';
}


/* Print the HTML code for the page header */
require($INC_DIR."header.php");


/* Print the HTML code for the page body */
require($INC_DIR."travelers.php");


/* Print the HTML code for the page footer */
require($INC_DIR."footer.php");


?>
