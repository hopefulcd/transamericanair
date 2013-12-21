	<!-- page body -->			
	<div id="body">
	
	<!-- Register container -->
	<div id="registerContainer">
		
		<!-- Register form -->
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="registerForm" id="registerForm">
		
			<ul id="register">
				<li>
					<table class="search" align="center" cellpadding="5">
						<tr><td class="searchlimit" colspan="100">Create Your Account:</td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span>First Name:</td>
							<td><input type="text" name="cfirstname" value="<?php echo $cfirstname; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorcFirstName; ?></td></tr>
						<tr>
							<td class="register" style="border:0px">Middle Name:</td>
							<td><input type="text" name="cmiddlename" value="<?php echo $cmiddlename; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span>Last Name:</td>
							<td><input type="text" name="clastname" value="<?php echo $clastname; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorcLastName; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> Address:</td>
							<td><input type="text" name="address" value="<?php echo $address; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorAddress; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> City:</td>
							<td><input type="text" name="city" value="<?php echo $city; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorCity; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> State:</td>
							<td>
								<select id="state" name="state">
									<option value=""></option>
									<option value="Alabama">Alabama</option>
									<option value="Alaska">Alaska</option>
									<option value="Arizona">Arizona</option>
									<option value="Arkansas">Arkansas</option>
									<option value="California">California</option>
									<option value="Colorado">Colorado</option>
									<option value="Connecticut">Connecticut</option>
									<option value="Delaware">Delaware</option>
									<option value="District of Columbia">District of Columbia</option>
									<option value="Florida">Florida</option>
									<option value="Georgia">Georgia</option>
									<option value="Hawaii">Hawaii</option>
									<option value="Idaho">Idaho</option>
									<option value="Illinois">Illinois</option>
									<option value="Indiana">Indiana</option>
									<option value="Iowa">Iowa</option>
									<option value="Kansas">Kansas</option>
									<option value="Kentucky">Kentucky</option>
									<option value="Louisiana">Louisiana</option>
									<option value="Maine">Maine</option>
									<option value="Maryland">Maryland</option>
									<option value="Massachusetts">Massachusetts</option>
									<option value="Michigan">Michigan</option>
									<option value="Minnesota">Minnesota</option>
									<option value="Mississippi">Mississippi</option>
									<option value="Missouri">Missouri</option>
									<option value="Montana">Montana</option>
									<option value="Nebraska">Nebraska</option>
									<option value="Nevada">Nevada</option>
									<option value="New Hampshire">New Hampshire</option>
									<option value="New Jersey">New Jersey</option>
									<option value="New Mexico">New Mexico</option>
									<option value="New York">New York</option>
									<option value="North Carolina">North Carolina</option>
									<option value="North Dakota">North Dakota</option>
									<option value="Ohio">Ohio</option>
									<option value="Oklahoma">Oklahoma</option>
									<option value="Oregon">Oregon</option>
									<option value="Pennsylvania">Pennsylvania</option>
									<option value="Rhode Island">Rhode Island</option>
									<option value="South Carolina">South Carolina</option>
									<option value="South Dakota">South Dakota</option>
									<option value="Tennessee">Tennessee</option>
									<option value="Texas">Texas</option>
									<option value="Utah">Utah</option>
									<option value="Vermont">Vermont</option>
									<option value="Virginia">Virginia</option>
									<option value="Washington">Washington</option>
									<option value="West Virginia">West Virginia</option>
									<option value="Wisconsin">Wisconsin</option>
									<option value="Wyoming">Wyoming</option>
								</select>
							</td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorState; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> Zip Code:</td>
							<td><input type="text" name="zip" value="<?php echo $zip; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorZip; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> Phone Number:</td>
							<td><input type="text" name="phone" value="<?php echo $phone; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorPhone; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"> Passport Number:</td>
							<td><input type="text" name="passport" value="<?php echo $passport; ?>" /></td>
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
							<td class="register" style="border:0px"><span class="required">*</span> Email:</td>
							<td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorEmail; ?></td></tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> Password:</td>
							<td><input type="password" name="password" value="<?php echo $password; ?>" /></td>
						</tr>
						<tr>
							<td class="register" style="border:0px"><span class="required">*</span> Re-Enter Password:</td>
							<td><input type="password" name="repassword" value="<?php echo $repassword; ?>" /></td>
						</tr>
						<tr><td class="important" style="font-style:normal" colspan="100"><?php echo $errorPassword; ?></td></tr>
						<tr>
							<td class="searchlimit" colspan="100">
								<input type="submit" title="Create And Login To Your New Account" value="Create Account" />
								<input type="hidden" name="dflight" value="<?php echo $in_dflight; ?>" />
								<input type="hidden" name="rflight" value="<?php echo $in_rflight; ?>" />
								<input type="hidden" name="quantity" value="<?php echo $in_quantity; ?>" />
							</td>
						</tr>
					</table>
				</li>
			</ul>
		
		</form>
		<!-- END Register form -->
		
	</div>
	<!-- END Register container -->
	
	<!-- Spacer -->
	<div id="spacer"><br></div>
	<!-- END Spacer -->
	
	</div>
	<!-- END page body -->	