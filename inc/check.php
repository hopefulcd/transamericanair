	<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="checkContainer">
		<table id="checkTable" class="search" align="center" cellpadding="5">
			<tr><td class="searchlimit" colspan="100" style="height:25px;"><span>Your Order Number:</span> &nbsp; <?php echo $orderNum; ?></td></tr>
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
				
		</table>
		
	</div>
	<!-- END page form -->
	
	<!-- Spacer -->
	<?php echo $spacer; ?>
	<!-- END Spacer -->
	
	</div>
	<!-- END page body -->
