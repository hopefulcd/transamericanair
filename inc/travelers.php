<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="travelersContainer">
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="travelersForm" id="travelersForm">
		
			<ul>
				<li id="travelers">
					<table id="travelersTable" class="search" align="center" cellpadding="5">
						
						<?php for ($i=0; $i<count($htmlTravelersList); $i++) {print $htmlTravelersList[$i];} ?>
						
						<tr style="height:25px;">
							<td class="searchlimit" colspan="100">
								<input type="submit" title="Continue To Billing" value="Continue" />
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
								<input type="hidden" id="selected" name="selected" value="" />
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