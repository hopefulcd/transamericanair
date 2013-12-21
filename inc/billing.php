	<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="billingContainer">
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="billingForm" id="billingForm">
		
			<ul>
				<li id="billing">
					<table id="billingTable" class="search" align="center" cellpadding="5">
						<tr><td class="searchlimit" colspan="100">Enter Your Billing Information:</td></tr>
						
						<tr>
							<td>
								<table style="width:340px;">
									
									<tr><td>
										<label for="cardFirstName">First Name: </label>
										<input type="text" id="cardFirstName" name="cardFirstName" placeholder="First Name on Card" />
									</td></tr>
									<tr><td>
										<label for="cardMiddleName">Middle Initial: </label>
										<input type="text" id="cardMiddleName" name="cardMiddleName" placeholder="Middle Initial on Card" />
									</td></tr>
									<tr><td>
										<label for="cardLastName">Last Name: </label>
										<input type="text" id="cardLastName" name="cardLastName" placeholder="Last Name on Card" />
									</td></tr>
									
								</table>
							</td>

							<td>
								<table style="width:300px;">
									
									<tr><td>
										<label for="address">Address: </label>
										<input type="text" id="address" name="address" placeholder="Street Address" />
									</td></tr>
									<tr><td>
										<label for="city">City: </label>
										<input type="text" id="city" name="city" placeholder="City" />
									</td></tr>
									<tr><td>
										<label for="state">State: </label>
										<select class="normalSelect right20" id="state" name="state">
											<?php echo $states; ?>
										</select>
									</td></tr>
									<tr><td>
										<label for="zip">Zip: </label>
										<input type="text" id="zip" name="zip" maxlength="5" placeholder="Zip Code" />
									</td></tr>
									
								</table>
							</td>

							<td>
								<table style="width:430px;">
									
									<tr><td>
										<label for="cardType">Card Type: </label>
										<select class="normalSelect right20" id="cardType" name="cardType" title="Select Your Credit Card Type">
											<?php echo $cardTypes; ?>
										</select>
									</td></tr>
									<tr><td>
										<label for="cardNum">Card Number: </label>
										<input type="text" id="cardNum" name="cardNum" maxlength="16" placeholder="Credit Card Number" title="Enter Your Credit Card Number" />
									</td></tr>
									<tr><td>
										
										<label for="cardMonth">Month: </label>
										<select class="right20" name="cardMonth" id="cardMonth" title="Select Your Credit Card Month">
											<?php for ($i=0; $i<count($htmlCardMonthList); $i++) {print $htmlCardMonthList[$i];} ?>
										</select>
										
										<label for="cardYear">Year: </label>
										<select class="smallSelect right20" name="cardYear" id="cardYear" title="Select Your Credit Card Year">
											<?php for ($i=0; $i<count($htmlCardYearList); $i++) {print $htmlCardYearList[$i];} ?>
										</select>
										
									</td></tr>
									
								</table>
							</td>
						</tr>
						
						<tr style="height:25px;">
							<td class="searchlimit" colspan="100">
								<input type="submit" title="Continue To Submit Your Reservation" value="Submit Reservation" />
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
								<input type="hidden" id="orderNum" name="orderNum" value="<?php echo $orderNum; ?>" />
								<input type="hidden" id="dClass" name="dClass" value="<?php echo $dClass; ?>" />
								<input type="hidden" id="rClass" name="rClass" value="<?php echo $rClass; ?>" />
								<input type="hidden" id="total" name="total" value="<?php echo $total; ?>" />
							</td>
						</tr>
					</table>
				</li>
			</ul>
		
		</form>
	</div>
	<!-- END page form -->
	
	<!-- Spacer -->
	<?php echo $spacer; ?>
	<!-- END Spacer -->
	
	</div>
	<!-- END page body -->