	<!-- page body -->			
	<div id="body">
	
	<!-- Login container -->
	<div id="loginContainer">
		
		<!-- Login form -->
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="loginForm" id="loginForm">
		
			<ul id="login">
				<li>
					<table class="search" align="center" cellpadding="5">
						<tr><td class="searchlimit" colspan="100">Login:</td></tr>
						<tr>
							<td class="prettyText" style="border:0px">Email:</td>
							<td><input class="inText" type="text" name="email" id="email" placeholder="Email Address" /></td>
						</tr>
						<tr>
							<td class="prettyText" style="border:0px">Password:</td>
							<td><input class="inText" type="password" name="password" id="password" placeholder="Password" /></td>
						</tr>
						<tr>
							<td class="prettyText" style="border:0px" colspan="100">
								Don't Have An Account? &nbsp; <a class="registerLink" href="#">Create An Account</a>
							</td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $error; ?></td></tr>
						<tr>
							<td class="searchlimit" colspan="100">
								<input type="submit" title="Login and go to the Traveler Information" value="Login" />
								<input type="hidden" name="ddate" value="<?php echo $in_ddate; ?>" />
								<input type="hidden" name="rdate" value="<?php echo $in_rdate; ?>" />
								<input type="hidden" name="from" value="<?php echo $in_orig; ?>" />
								<input type="hidden" name="to" value="<?php echo $in_dest; ?>" />
								<input type="hidden" name="dflight" value="<?php echo $in_dflight; ?>" />
								<input type="hidden" name="rflight" value="<?php echo $in_rflight; ?>" />
								<input type="hidden" name="origCity" value="<?php echo $origCity; ?>" />
								<input type="hidden" name="origState" value="<?php echo $origState; ?>" />
								<input type="hidden" name="destCity" value="<?php echo $destCity; ?>" />
								<input type="hidden" name="destState" value="<?php echo $destState; ?>" />
								<input type="hidden" id="quantity" name="quantity" value="<?php echo $in_quantity; ?>" />
								<input type="hidden" id="trip" name="trip" value="<?php echo $in_trip; ?>" />
							</td>
						</tr>
					</table>
					<input type="button" title="Skip Login and Go to the Traveler Information" value="Continue without Logging in" onclick="skipLogin()" />
				</li>
			</ul>
		
		</form>
		<!-- END Login form -->
		
	</div>
	<!-- END Login container -->
			
	</div>
	<!-- END page body -->	