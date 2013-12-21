/*
Name: Trans American Airlines
Description: This file holds all (or nearly all) of the Javascript and Jquery functions that are used for transamericanair.selfip.com
*/

// This function selects the appropriate radio button for the user selected departure and return flights.
// Also, the hidden variable selected is updated.
function select(num, ch)
{
	var row   = "row_" + num;
	var radio = "radio_" + num;
	var sel   = document.getElementById("selected");
	
	if (ch == 's')
	{
		document.getElementById(radio).checked = "checked";
		sel.value = row;
	}
}

// check if the submitted input values of the home page are valid or not
function isHomeValid()
{
	// setup the input variables
	var from  = document.getElementById("from"); // the FROM location
	var to    = document.getElementById("to"); // the TO location
	var ddate = document.getElementById("ddate").value; // the departure date
	var rdate = document.getElementById("rdate").value; // the return date
	
	// test for any errors in the form values
	var error1 = (from.options[from.selectedIndex].value == "NA") ? "Error: You haven't selected an Origin City.\n" : "";
	var error2 = (to.options[to.selectedIndex].value == "NA") ? "Error: You haven't selected a Destination City.\n" : "";
	var error3 = (ddate == "") ? "Error: You haven't selected a Departure Date.\n" : "";
	var error4 = (rdate == "") ? "Error: You haven't selected a Return Date.\n" : "";
	
	// if any errors exist, display an error message and return false
	if ( (error1 != "") || (error2 != "") || (error3 != "") || (error4 != "") ) 
	{
		alert(error1 + error2 + error3 + error4); 
		return false;
	}
	
	return true;
}

// used to check if the form submission information is valid or not
function isValid(ch)
{
	
	// check if the departure flight page values are valid
	if (ch == 'sdf')
	{
		var sel = document.getElementById("selected");
		var trip = document.getElementById("trip");
		
		if (sel.value == "") {alert("Error: You Haven't Selected A Flight."); return false;}
		if (trip.value == "1")
		{
			document.resultsForm.action = "login.php";
			document.resultsForm.submit();
		}
	}
	
	// check if the return flight page values are valid
	if (ch == 'srf')
	{
		var sel = document.getElementById("selected");
		
		if (sel.value == "") {alert("Error: You Haven't Selected A Flight."); return false;}
	}
	
	// check if the travelers page values are valid
	if (ch == 't')
	{
		var quantity = parseInt(document.getElementById("quantity").value, 10); // gets the total number of travelers
		var emailCount = 0; // the number of emails that are filled out (at least 1 required)
		
		for (var i=1; i <= quantity; i++)
		{
			var fname = document.getElementById("tfirstname_"+i).value; // the traveler's first name
			var lname = document.getElementById("tlastname_"+i).value; // the traveler's last name
			var email = document.getElementById("email_"+i).value; // the traveler's email address
			
			// check the first and last name values
			var error1 = (fname == "") ? "Error: Traveler "+i+" First Name is blank.\n" : "";
			var error2 = (lname == "") ? "Error: Traveler "+i+" Last Name is blank.\n" : "";
			
			// check the email address
			if (isValidEmailAddress(email))
			{
				emailCount++;
			}
		}
		
		// check the number of valid email addresses
		var error3 = (emailCount == 0) ? "Error: At least one valid email address is required.\n" : "";
		
		// print the error messages, if any
		if ( (error1 != "") || (error2 != "") || (error3 != "") ) {alert(error1 + error2 + error3); return false;}
	}
	
	// check if the billing page values are valid
	if (ch == 'b')
	{
		var cardFirstName = document.getElementById("cardFirstName").value; // the card first name
		var cardMiddleName = document.getElementById("cardMiddleName").value; // the card middle initial
		var cardLastName = document.getElementById("cardLastName").value; // the card last name
		var address = document.getElementById("address").value; // the billing address
		var city = document.getElementById("city").value; // the billing city
		var zip = document.getElementById("zip").value; // the billing zip
		var cardNum   = document.getElementById("cardNum").value; // the card number
		
		var error1 = (cardNum.length != 16) ? "Error: Invalid Credit Card Number.\n" : "";
		var error2 = (cardFirstName == "") ? "Error: First Name is blank.\n" : "";
		var error3 = (cardMiddleName == "") ? "Error: Middle Initial is blank.\n" : "";
		var error4 = (cardLastName == "") ? "Error: Last Name is blank.\n" : "";
		var error5 = (address == "") ? "Error: Billing Address is blank.\n" : "";
		var error6 = (city == "") ? "Error: City is blank.\n" : "";
		var error7 = (zip.length != 5) ? "Error: Invalid Zip Code.\n" : "";
		
		if ( (error1 != "") || (error2 != "") || (error3 != "") || (error4 != "") || (error5 != "") || (error6 != "") || (error7 != "") )
		{alert(error1 + error2 + error3 + error4 + error5 + error6 + error7); return false;}
	}
	
	return true;
}

// skips the login and goes to the traveler's information page
function skipLogin()
{
	document.loginForm.action = "travelers.php";
	document.loginForm.submit();
}

// login the user with AJAX
function submitLogin()
{
	var topLinks = document.getElementById("user-options"); // the user links at the top of the pages
	var logStatusLink = document.getElementById("logStatus"); // the logStatus link at the bottom of the pages
	var regAccountLink = document.getElementById("regAccount"); // the regAccount link at the bottom of the pages
	var xmlhttp; // the AJAX variable
	var data = ""; // the data that will get sent to the program
	var email = document.getElementById("emailLogin"); // the email that the user typed in
	var pass = document.getElementById("passLogin"); // the password that the user typed in
	var responseArray = new Array(); // holds the different parts of the AJAX response
	
	// prepare the user's submitted data
	data = "email="+email.value+"&password="+pass.value;
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var response = xmlhttp.responseText;
			responseArray = response.split('&LOGSTATUS=');
			
			// if the user is logged in, then reset the links
			if (responseArray[1].indexOf("Logout") != -1)
			{
				topLinks.innerHTML = responseArray[0];
				logStatusLink.innerHTML = '<a href="account.php">My Account</a>';
				regAccountLink.innerHTML = responseArray[1];
				
				// if current login was from the login page, then redirect the user to the travelers page
				if (document.URL == "http://transamericanair.selfip.com/login.php")
				{
					var pageEmail = document.getElementById("email"); // the email field on the login page
					var pagePass = document.getElementById("password"); // the password field on the login page
					
					// set the correct values in the login form
					pageEmail.value = email;
					pagePass.value = pass;
					
					// submit the login form from the login page
					document.loginForm.submit();
				}
			}
			else
			{
				alert("Incorrect Login Information");
				return false;
			}
		}
	}
	xmlhttp.open("POST","submitLogin.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(data);
}


// register the user with AJAX
function submitRegister()
{
	var topLinks = document.getElementById("user-options"); // the user links at the top of the pages
	var logStatusLink = document.getElementById("logStatus"); // the logStatus link at the bottom of the pages
	var regAccountLink = document.getElementById("regAccount"); // the regAccount link at the bottom of the pages
	var xmlhttp; // the AJAX variable
	var data = ""; // the data that will get sent to the program
	var email = document.getElementById("emailRegister"); // the email that the user typed in
	var pass = document.getElementById("passRegister"); // the password that the user typed in
	var repass = document.getElementById("rePassRegister"); // the re-password that the user typed in
	var responseArray = new Array(); // holds the different parts of the AJAX response
	
	// if the submitted password and re-password don't match
	if (pass.value != repass.value)
	{
		alert("Your passwords entered don't match");
		return false;
	}
	
	// check if the submitted password and re-password are empty
	if ( (pass.value == "") || (repass.value == "") )
	{
		alert("Your passwords are empty");
		return false;
	}
	
	// check if the email is valid and not blank
	if (email.value !== "")
	{	
		if (!isValidEmailAddress(email.value))
		{
			alert("The Email you entered is not a valid email address");
			return false;
		}
	}
	
	// prepare the user's submitted data
	data = "email="+email.value+"&password="+pass.value;
	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var response = xmlhttp.responseText;
			
			if (response == "0")
			{
				alert("That Email address is already registered");
				return false;
			}
			
			responseArray = response.split('&LOGSTATUS=');
			
			// if the user is logged in, then reset the links
			if (responseArray[1].indexOf("Logout") != -1)
			{
				topLinks.innerHTML = responseArray[0];
				logStatusLink.innerHTML = '<a href="account.php">My Account</a>';
				regAccountLink.innerHTML = responseArray[1];
				
				// if current register was from the login page, then redirect the user to the travelers page
				if (document.URL == "http://transamericanair.selfip.com/login.php")
				{
					var pageEmail = document.getElementById("email"); // the email field on the login page
					var pagePass = document.getElementById("password"); // the password field on the login page
					
					// set the correct values in the login form
					pageEmail.value = email;
					pagePass.value = pass;
					
					// submit the login form from the login page
					document.loginForm.submit();
				}
			}
		}
	}
	xmlhttp.open("POST","submitRegister.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(data);
}

// function that checks if an email address is valid
function isValidEmailAddress(emailAddress)
{
	// test the email address against the RFC standard format for an email address
	var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
};

