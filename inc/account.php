	<!-- page body -->			
	<div id="body">
	
	<!-- Register container -->
	<div id="registerContainer">
		
		<!-- Register form -->
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="registerForm" id="registerForm">
		
			<ul id="register">
				<li>
					<table class="search" align="center" cellpadding="5">
						<tr><td class="searchlimit" colspan="100">Update Your Account Information:</td></tr>
						<tr>
							<td class="register" style="border:0px">First Name:</td>
							<td><input type="text" name="cfirstname" value="<?php echo $cfirstname; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px">Middle Name:</td>
							<td><input type="text" name="cmiddlename" value="<?php echo $cmiddlename; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px">Last Name:</td>
							<td><input type="text" name="clastname" value="<?php echo $clastname; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> Address:</td>
							<td><input type="text" name="address" value="<?php echo $address; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> City:</td>
							<td><input type="text" name="city" value="<?php echo $city; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> State:</td>
							<td>
								<select id="state" name="state">
									<option value=""></option>
									<?php echo $states; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> Zip Code:</td>
							<td><input type="text" name="zip" maxlength="5" value="<?php echo $zip; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> Phone Number:</td>
							<td><input type="text" name="phone" value="<?php echo $phone; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> Passport Number:</td>
							<td><input type="text" name="passport" maxlength="9" value="<?php echo $passport; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"> Date of Birth:</td>
							<td>
								<select class="smallSelect" id="dobMonth" name="dobMonth">
									<option value=""></option>
									<?php echo $dobMonth; ?>
								</select>
								<select class="smallSelect" id="dobDay" name="dobDay">
									<option value=""></option>
									<?php echo $dobDay; ?>
								</select>
								<select class="smallSelect" id="dobYear" name="dobYear">
									<option value=""></option>
									<?php echo $dobYear; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="searchlimit" colspan="100">
								<input class="submitButton" type="submit" title="Save Your Account Information" value="Save" />
							</td>
						</tr>
					</table>
				</li>
			</ul>
		
		</form>
		<!-- END Register form -->
		
	</div>
	<!-- END Register container -->
	
	</div>
	<!-- END page body -->	