	<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="billingContainer">
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="billingForm" id="billingForm">
		
			<ul>
				<li id="billing">
					<table id="billingTable" class="search" align="center" cellpadding="5">
						<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Your Departure Flight:</span></td></tr>
						<tr class="selectlimit" colspan="100" style="height:25px;">
							<td colspan="3">Flight Number</td>
							<td colspan="3">Flight Date</td>
							<td colspan="3">Departure Time</td>
							<td colspan="3">Arrival Time</td>
							<td colspan="2">Class</td>
						</tr>
						
						<?php echo $dflight; ?>
						
						<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Your Return Flight:</span></td></tr>
						<tr class="selectlimit" colspan="100" style="height:25px;">
							<td colspan="3">Flight Number</td>
							<td colspan="3">Flight Date</td>
							<td colspan="3">Departure Time</td>
							<td colspan="3">Arrival Time</td>
							<td colspan="2">Class</td>
						</tr>
						
						<?php echo $rflight; ?>
						
						<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Traveler Summary:</span></td></tr>
						<tr class="selectlimit" style="height:25px;">
							<td>First Name</td>
							<td>MI</td>
							<td>Last Name</td>
							<td>Email</td>
							<td>Address</td>
							<td>City</td>
							<td>State</td>
							<td>Zip</td>
							<td>Phone</td>
							<td>Passport</td>
							<td>Date of Birth</td>
							<td>Type</td>
							<td>Additional Bags</td>
							<td>Total</td>
						</tr>
						
						<?php echo $travelerSummary; ?>
						
						<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Order Summary:</span></td></tr>
						<tr>
							<td class="selectlimit" colspan="13" style="text-align:right; font-size:12px; height:25px;"><span>Within 7 days Fee: &nbsp;</span></td>
							<td class="selectlimit" style="text-align:right; font-size:12px; height:25px;">$<?php echo $within7DaysPrice; ?></td>
						</tr>
						<tr>
							<td class="selectlimit" colspan="13" style="text-align:right; font-size:12px; height:25px;"><span>Taxes: &nbsp;</span></td>
							<td class="selectlimit" style="text-align:right; font-size:12px; height:25px;"><?php echo $taxes; ?>%</td>
						</tr>
						<tr>
							<td class="selectlimit" colspan="13" style="text-align:right; font-size:12px; height:25px;"><span>ORDER TOTAL: &nbsp;</span></td>
							<td class="selectlimit" style="text-align:right; font-size:12px; height:25px;">$<?php echo $total; ?></td>
						</tr>
						
						<tr style="height:25px;">
							<td class="searchlimit" colspan="100">
								<input type="submit" title="Reserve and Pay for your Order" value="Reserve and Pay" />
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
								<input type="hidden" name="cardNum" value="<?php echo $in_cardnum; ?>" />
								<input type="hidden" name="cardMonth" value="<?php echo $in_cardmonth; ?>" />
								<input type="hidden" name="cardYear" value="<?php echo $in_cardyear; ?>" />
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
