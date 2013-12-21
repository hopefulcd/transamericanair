<!-- page body -->			
	<div id="body">
	
	<!-- page form -->
	<div id="form">
		<form action="<?php echo $action; ?>" method="POST" onsubmit="<?php echo $onsubmit; ?>" name="mainform" id="mainform" autocomplete="off">
		
			<ul>
				<li id="tripDate">
					<div id="tripType">
						<input type="radio" id="trip1" name="trip" value="1">
						<label for="trip1">One Way</label>
						<input type="radio" id="trip2" name="trip" value="2" checked="checked">
						<label for="trip2">Round Trip</label>
					</div>
					
					<br>
					<span>Departure Date: &nbsp;</span>
					<div id="ddatePicker"></div>
					<input type="text" id="ddate" name="ddate" maxlength="0" autocomplete="off" placeholder="Departure Date" />
					
					<br>
					<span>Return Date: &nbsp;</span>
					<div id="rdatePicker"></div>
					<input type="text" id="rdate" name="rdate" maxlength="0" autocomplete="off" placeholder="Return Date" />
					
					<!-- Load the Jquery code for the datepicker -->
					<script>
						
						// the Jquery code for the datepicker
						
						var ddate,rdate;
						
						$("#ddatePicker").datepicker(
						{
							onSelect: function()
							{
								ddate = $("#ddatePicker").datepicker({ dateFormat: 'yy-m-d' }).val();
								$('#ddate').val(ddate);
								$(this).hide();
							}
						});
						
						$("#rdatePicker").datepicker(
						{
							onSelect: function()
							{
								rdate = $("#rdatePicker").datepicker({ dateFormat: 'yy-m-d' }).val();
								$('#rdate').val(rdate);
								$(this).hide();
							}
						});
						
						$( "#ddate" ).click(function() {
							$("#ddatePicker").show();
						});
						
						$( "#rdate" ).click(function() {
							$("#rdatePicker").show();
						});
						
						// hide the datepickers at startup
						$("#ddatePicker, #rdatePicker").hide();
						
					</script>
					</script>
				</li>
				<li id="airport">
					<h2>Airport</h2>
					<div>
						
						<span>From: &nbsp;</span>
						<select name="from" id="from" title="Select Your Departure City">
							<?php for ($i=0; $i<count($htmlCityList); $i++) {print $htmlCityList[$i];} ?>
						</select>
						
						<br>
						
						<span>To: &nbsp;</span>
						<select name="to" id="to" title="Select Your Arrival City">
							<?php for ($i=0; $i<count($htmlCityList); $i++) {print $htmlCityList[$i];} ?>
						</select>
						
					</div>
				</li>
				<li id="travelers">
					<h2>Travelers</h2>
					
					<span>How many Travelers? &nbsp;</span>
					<select name="quantity" id="quantity" title="Select The Number of Travelers">
						<?php for ($i=0; $i<count($htmlTravelersList); $i++) {print $htmlTravelersList[$i];} ?>
					</select>
					<br>
					<input id="search" name="search" type="submit" value="Search" />
				</li>
			</ul>
		
		</form>
	</div>
	<!-- END page form -->
	
	<!-- END page body -->			
	</div>