<table>
<tbody>



<tr>
<td>Flight ID:</td>
<td><input type="text" size="20" name="flight_id" id="flight_id" value=""></td>
</tr>

<tr><td>&nbsp</td></tr>
<tr><td>&nbsp</td></tr>

<tr>
<td>&nbsp;<b>From:</b></td>
<td>&nbsp;<b>To:</b></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;<b>Price</b></td>
</tr>

<tr>
<td>
<input type="text" size="20" name="from" id="from" value="">
</td>
<td>
<input type="text" size="20" name="to" id="to" value="">
</td>
<td>
<center><select name="type" id="type">
<option value="1">One-way</option>
<option value="2">Round Trip</option>
</select></center>
</td>
<td>
<center><select name="flight_class" id="flight_class">
<option value="1">Economic</option>
<option value="2">Business</option>
</select></center>
</td>
<td>
$&nbsp<input type="text" size="8" name=price" id="price" value="">
</td>
</tr>


<tr><td>&nbsp;</td></tr>

</table>

<table>
<tbody>
<tr>
<td>&nbsp;<b>Departure:</b></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;<b>Arrival:</b></td>
</tr>

<tr>
<td>
<input type="text" size="20" name="depart_date" id="depart_date" value="">
</td>
<td>
	<ul id="icons" class="ui-widget ui-helper-clearfix"><li class="ui-state-default ui-corner-all" title=".ui-icon-calendar"><span class="ui-icon ui-icon-calendar"></span></li></ul>
</td>
<td>
<select id="depart_time" name="depart_time">
                        <option value="a">Anytime</option>
                                <option value="r">Early (4a-8a)</option>
                                <option value="m">Morning (8a-12p)</option>
                                <option value="n">Afternoon (12p-5p)</option>
                                <option value="e">Evening (5p-9p)</option>
                                <option value="l">Night (9p-12a)</option>
                                <option value="1">1:00 am</option>
                                <option value="2">2:00 am</option>
                                <option value="3">3:00 am</option>
                                <option value="4">4:00 am</option>
                                <option value="5">5:00 am</option>
                                <option value="6">6:00 am</option>
                                <option value="7">7:00 am</option>
                                <option value="8">8:00 am</option>
                                <option value="9">9:00 am</option>
                                <option value="10">10:00 am</option>
                                <option value="11">11:00 am</option>
                                <option value="12">Noon</option>
                                <option value="13">1:00 pm</option>
                                <option value="14">2:00 pm</option>
                                <option value="15">3:00 pm</option>
                                <option value="16">4:00 pm</option>
                                <option value="17">5:00 pm</option>
                                <option value="18">6:00 pm</option>
                                <option value="19">7:00 pm</option>
                                <option value="20">8:00 pm</option>
                                <option value="21">9:00 pm</option>
                                <option value="22">10:00 pm</option>
                                <option value="23">11:00 pm</option>
                </select>
				</td>
				
<td>
<input type="text" size="20" name="arrival_date" id="arrival_date" value="">
</td>
<td>
	<ul id="icons" class="ui-widget ui-helper-clearfix"><li class="ui-state-default ui-corner-all" title=".ui-icon-calendar"><span class="ui-icon ui-icon-calendar"></span></li></ul>
</td>
<td>
<select id="depart_time" name="arrival_time">
                        <option value="a">Anytime</option>
                                <option value="r">Early (4a-8a)</option>
                                <option value="m">Morning (8a-12p)</option>
                                <option value="n">Afternoon (12p-5p)</option>
                                <option value="e">Evening (5p-9p)</option>
                                <option value="l">Night (9p-12a)</option>
                                <option value="1">1:00 am</option>
                                <option value="2">2:00 am</option>
                                <option value="3">3:00 am</option>
                                <option value="4">4:00 am</option>
                                <option value="5">5:00 am</option>
                                <option value="6">6:00 am</option>
                                <option value="7">7:00 am</option>
                                <option value="8">8:00 am</option>
                                <option value="9">9:00 am</option>
                                <option value="10">10:00 am</option>
                                <option value="11">11:00 am</option>
                                <option value="12">Noon</option>
                                <option value="13">1:00 pm</option>
                                <option value="14">2:00 pm</option>
                                <option value="15">3:00 pm</option>
                                <option value="16">4:00 pm</option>
                                <option value="17">5:00 pm</option>
                                <option value="18">6:00 pm</option>
                                <option value="19">7:00 pm</option>
                                <option value="20">8:00 pm</option>
                                <option value="21">9:00 pm</option>
                                <option value="22">10:00 pm</option>
                                <option value="23">11:00 pm</option>
                </select>
				</td>
				<td>&nbsp;</td>
</tr>

				<tr><td>&nbsp;</td></tr>
				
</table>

<table>
<tbody>


<tr>
<form>
<td><input type="radio" name="flight_type" value="add_flight">Add flight</td>
<td><input type="radio" name="flight_type" value="delete_flight">Delete flight</td>
<td><input type="radio" name="flight_type" value="update_flight">Update flight</td>
</form> 
</tr>
				
				
				<tr><td>&nbsp;</td></tr>

				</table>
	<table width="900" outline="1" border="0" bgcolor="#FFFFFF" cellspacing="1" cellpadding="2" style="padding:0; margin:0; ">
<tbody>			
				<tr>
<td width="10%" style="margin: 0" height="100%" colspan="6">
<center>
<input style="border:3px outset #FFF; FONT-SIZE: 18pt;  COLOR: #000; BACKGROUND-COLOR: #8F8B8B" type="submit" value="Submit" name="sbutton"></p>
</center></td>
</tr>
</table>