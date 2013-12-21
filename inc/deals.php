	<tr>
		<td colspan="2" style="text-align:center">
			<table class="search" align="center" style="width:100%" cellpadding="5">
				<tr><td class="searchlimit" colspan="100"><span>Here's some recommended Great Deals for you...</span></td></tr>
				<tr class="selectlimit">
					<td></td>
					<td>Flight ID</td>
					<td>Flight Number</td>
					<td>Departing Flight Date</td>
					<td>Returning Flight Date</td>
					<td>Flight Time</td>
					<td>Origin</td>
					<td>Destination</td>
					<td>Class</td>
					<td>Price</td>
				</tr>
				
				<TMPL_LOOP NAME="SELECTDEAL_LIST">
					<TMPL_VAR NAME="FLIGHTS">
				</TMPL_LOOP>
				
				<tr>
					<td class="searchlimit" colspan="100">
						<TMPL_VAR NAME="CONTINUE">
						<input type="hidden" name="rdate" value="<TMPL_VAR NAME="RDATE">" />
						<input type="hidden" id="selected" name="selected" value="" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
