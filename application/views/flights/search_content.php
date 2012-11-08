<?=$this->load->view('flights/searchbox_content', NULL, true)?>

<h2>Search Results</h2>
<?php if(isset($search_results)) var_dump($search_results); ?>
		
<table>
<tbody>

<tr align="center">
<td colspan="6"><u><b><h3>Flight Results:</h3></b></u></td>
</tr>

<tr><td>&nbsp</td></tr>


<tr align="left">
<td>From:</td>
<td>&nbsp</td>
<td>&nbspon</td>
<td>&nbsp</td>
<td>&nbspat</td>
<td>&nbsp</td>
</tr>

<tr align="left">
<td>To:</td>
<td>&nbsp</td>
<td>&nbspon</td>
<td>&nbsp</td>
<td>&nbspat</td>
<td>&nbsp</td>
</tr>

<tr><td>&nbsp</td></tr>


<tr>
<td>(Passenger number)</td>
<td>(one way, round trip)</td>
</tr>

</tbody>
</table>


<table>
<tbody>
<hr>

<tr><td>&nbsp</td></tr>


<tr align="left">
<td>(From)</td>
<td><ul id="icons" class="ui-widget ui-helper-clearfix"><span class="ui-icon ui-icon-arrow-1-e"></span></td>
<td>(to)</td>
<td>(flight number)</td>
<td>$ (cost)</td>
<td>&nbsp</td>
</tr>

<tr align="left">
<td>Departs:</td>
<td>(date)</td>
<td>(time)</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>(one way, round trip)</td>
</tr>

<tr align="left">
<td>Arrives:</td>
<td>(date)</td>
<td>(time)</td>
</tr>

<tr><td>&nbsp</td></tr>


<tr>

<td colspan="6"><center>
<input style="border:3px outset #FFF; FONT-SIZE: 10pt;  COLOR: #000; BACKGROUND-COLOR: #8F8B8B" type="submit" value="Book Now!" name="sbutton">
</td>


<tr><td>&nbsp</td></tr>

</tbody>
</table>
