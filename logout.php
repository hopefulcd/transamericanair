<?php

// log the user out if they're logged in
if(isset($_COOKIE['cid']))
{
	unset($_COOKIE['cid']); // remove the login cookie
	setcookie('cid', '', time() - 3600); // empty value and old timestamp
	
	unset($_COOKIE['cdata']); // remove the customer data cookie
	setcookie('cdata', '', time() - 3600); // empty value and old timestamp
}

// redirect the browser to the home page
header("Location: http://transamericanair.selfip.com/");

?>