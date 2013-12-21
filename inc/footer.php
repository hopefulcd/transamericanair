<!-- page footer -->	
	<div id="footer">
		
		<ul>
			<li>
				<ul>
					<li>User Options</li>
					<li id="logStatus"><?php echo $logStatus; ?></li>
					
					<?php
						if ($isLoggedIn)
						{
							print '<li id="regAccount"><a href="account.php">My Account</a></li>';
						}
						else
						{
							print '<li id="regAccount"><a class="registerLink" href="#">Register</a></li>';
						}
					?>
					
					<li><a class="checkLink" href="#">Check Reservation</a></li>
					<li><a href="contact.php">Contact Information</a></li>
					<li><a href="help.php">Help</a></li>
					<li><a href="rules.php">Website Rules</a></li>
					<li><a href="http://transamericanair.selfip.com">Home</a></li>
				</ul>
			</li>
			<li>
				<ul>
					<li>Call Us</li>
					<li>
						Phone:<br><br>
						
						1-800-555-7971<br>
						(within U.S., Canada, and Puerto Rico)<br><br>
						
						817-555-6100<br><br>

						Fax: 817-555-6015<br><br>
						
						8:00 a.m. - 6:00 p.m. (CT)<br>
						Monday - Friday
					</li>
				</ul>
			</li>
			<li>
				<ul>
					<li>Locate Us</li>
					<li>
						Trans American Airlines<br>
						5123 Trans American Blvd.<br>
						MD 53078<br>
						Fort Worth, TX 76155<br>
					</li>
				</ul>
			</li>
			<li>Copyright 2013 &copy Trans American Airlines Inc.</li>
		</ul>
	
	<!-- END page footer -->			
	</div>
	
	
<!-- END main container -->
</div>

<!-- END html code -->
</body>
</html>