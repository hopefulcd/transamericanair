	<tr>
		<td class="searchlimit" colspan="2" style="text-align:center">
			How many sets of tickets would you like to purchase? &nbsp; 
			<input type="text" name="quantity" id="quantity" maxlength="2" onkeypress="return ismax(event, 'stq', 10)" />
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center">
			<table class="search" align="center" style="width:80%; height:150px;" cellpadding="5">
				<tr style="height:25px;"><td class="searchlimit" colspan="100"><span>Your Departure Flight:</span></td></tr>
				<tr class="selectlimit" style="height:25px;">
					<td>Flight Number</td>
					<td>Flight Date</td>
					<td>Flight Time</td>
					<td>Class</td>
					<td>Price</td>
				</tr>
				
				<?php echo $dflight; ?>
				
				<tr style="height:25px;">
					<td class="searchlimit" colspan="100"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center">
			<table class="search" align="center" style="width:80%; height:160px;" cellpadding="5">
				<tr style="height:25px;"><td class="searchlimit" colspan="100"><span>Your Return Flight:</span></td></tr>
				<tr class="selectlimit" style="height:25px;">
					<td>Flight Number</td>
					<td>Flight Date</td>
					<td>Flight Time</td>
					<td>Class</td>
					<td>Price</td>
				</tr>
				
				<?php echo $rflight; ?>
				
				<tr style="height:25px;">
					<td class="searchlimit" colspan="100">
						<input type="submit" title="Continue To The Login Page" value="Continue" />
						<input type="hidden" name="dflight" value="<?php echo $in_dflight; ?>" />
						<input type="hidden" name="rflight" value="<?php echo $in_rflight; ?>" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
