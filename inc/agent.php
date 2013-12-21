	<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="resultsContainer">
		<table id="report1" class="search" align="center" cellpadding="5">
			<tr style="height:25px;"><td class="searchlimit" colspan="100"><span>Report Form 1</span></td></tr>
			<tr class="selectlimit" style="height:25px;">
				<td>Flight ID</td>
				<td>Flight Number</td>
				<td>Coach Passenger Count</td>
				<td>1st Class Passenger Count</td>
				<td>Total Passenger Count</td>
				<td>Total Bag Weight</td>
				<td>Total Bag Cost</td>
				<td>Grand Total</td>
			</tr>
			
			<?php
				
				// print the available Coach seats
				for ($i=0; $i<count($htmlReportForm1); $i++) {print $htmlReportForm1[$i];}
				
			?>
		</table>
		
		<table id="report2" class="search" align="center" cellpadding="5">
			<tr style="height:25px;"><td class="searchlimit" colspan="100"><span>Report Form 2</span></td></tr>
			<tr class="selectlimit" style="height:25px;">
				<td>First Name</td>
				<td>MI</td>
				<td>Last Name</td>
				<td>Flight ID</td>
				<td colspan="100">Passenger Cost</td>
			</tr>
			
			<?php
				
				// print the available Coach seats
				for ($i=0; $i<count($htmlReportForm2); $i++) {print $htmlReportForm2[$i];}
				
			?>
			
			<tr>
				<td class="selectlimit" colspan="13" style="text-align:right; font-size:12px; height:25px;"><span>Total Customer Count: &nbsp;</span></td>
				<td class="selectlimit" style="text-align:right; font-size:12px; height:25px;"><?php echo $customerCount; ?></td>
			</tr>
			<tr>
				<td class="selectlimit" colspan="13" style="text-align:right; font-size:12px; height:25px;"><span>Customer Grand Total: &nbsp;</span></td>
				<td class="selectlimit" style="text-align:right; font-size:12px; height:25px;">$<?php echo $customerGrandTotal; ?></td>
			</tr>
			
		</table>
		
	</div>
	<!-- END page form -->
	
	<!-- Spacer -->
	<?php echo $spacer; ?>
	<!-- END Spacer -->
	
	</div>
	<!-- END page body -->