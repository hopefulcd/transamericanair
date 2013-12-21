#!/usr/bin/perl -w

use strict;
use CGI qw(:standard);
use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use DBI;

my
(
	$html,			#This prints out some html
	$count,			#This is a counter variable
	$tablename,		#This is the tablename of the database
	$dbh,			#This is the database handle variable
	$sql,			#This is the mysql code
	$sth			#This prepares the database handle with the sql
);

	$dbh = DBI->connect("DBI:mysql:woodmarc_cs442", "woodmarc_cs442", "cs442") or die "Error: $DBI::errstr\n";
	$sql = "CREATE TRIGGER `reservation_date` AFTER INSERT ON `Reservation` FOR EACH ROW UPDATE `Reservation` SET `order_date` = CURDATE() WHERE `ordernum` = NEW.`ordernum`";
	$dbh->do($sql) or die "Can't execute SQL statement: $DBI::errstr\n";
		
	print header;
	print start_html('Test File');
	print "Check to see if this worked...";
	print end_html;
	
	$dbh->disconnect;
