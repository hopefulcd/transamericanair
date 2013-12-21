<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="resultsContainer">
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="resultsForm" id="resultsForm">
		
			<ul>
				<li id="results">
					<table class="search" align="center" cellpadding="5">
						<tr style="height:25px;"><td class="searchlimit" colspan="100"><span>Select A Departure Flight:</span></td></tr>
						<tr class="selectlimit" style="height:25px;">
							<td></td>
							<td>Flight Number</td>
							<td>Flight Date</td>
							<td>Departure Time</td>
							<td>Arrival Time</td>
							<td>Seats Available</td>
							<td>Origin</td>
							<td>Destination</td>
							<td>Class</td>
						</tr>
						
						<?php
							
							// print the available Coach seats
							for ($i=0; $i<count($htmlCoachFlightList); $i++) {print $htmlCoachFlightList[$i];}
							
							// print the available First Class seats
							for ($i=0; $i<count($htmlFirstClassFlightList); $i++) {print $htmlFirstClassFlightList[$i];}
							
						?>
						
						<tr style="height:25px;">
							<td class="searchlimit" colspan="100">
								<?php echo $continue; ?>
								<input type="hidden" name="ddate" value="<?php echo $in_ddate; ?>" />
								<input type="hidden" name="rdate" value="<?php echo $in_rdate; ?>" />
								<input type="hidden" name="from" value="<?php echo $in_orig; ?>" />
								<input type="hidden" name="to" value="<?php echo $in_dest; ?>" />
								<input type="hidden" name="origCity" value="<?php echo $origCity; ?>" />
								<input type="hidden" name="origState" value="<?php echo $origState; ?>" />
								<input type="hidden" name="destCity" value="<?php echo $destCity; ?>" />
								<input type="hidden" name="destState" value="<?php echo $destState; ?>" />
								<input type="hidden" id="quantity" name="quantity" value="<?php echo $in_quantity; ?>" />
								<input type="hidden" id="trip" name="trip" value="<?php echo $in_trip; ?>" />
								<input type="hidden" id="selected" name="selected" value="" />
							</td>
						</tr>
					</table>
				</li>
			</ul>
		
		</form>
	</div>
	<!-- END page form -->
	
	<!-- END page body -->			
	</div>