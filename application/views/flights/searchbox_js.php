
var domesticCodes = [];
var intlCodes = [];

function updateTags() {

domesticCodes = [
	<?php
	/*foreach($airports as $a) {
		if($a->is_domestic) echo '"'.$a->code.'",';
	}*/
	?>
  ];

intlCodes = [
	<?php
	/*foreach($airports as $a) {
		echo '"'.$a->code.'",';
	}*/
	?>
 ];
}

updateTags();

// This doesn't actually work yet, it only shows domestic always
function updateAutoComplete(is_domestic) {
if(is_domestic) {
	$( ".autocomplete" ).autocomplete({
		source: domesticCodes
	});
} else {
	$( ".autocomplete" ).autocomplete({
		source: intlCodes
	});
}
//alert('is_domestic: ' + is_domestic);
}

// Do an initial run for updateTags with domestic
updateAutoComplete(true);


$("#is_domestic").change(function() {
updateAutoComplete($("#is_domestic").val());
});

	$( "#datepicker" ).datepicker({
		inline: true
	});

$( "#search_submit" ).button();

$( "#depart_date_start_picker" ).datepicker({
   defaultDate: new Date(),
   altField: '#depart_date_start',
   altFormat: '@',
   changeMonth: true,
   numberOfMonths: 1,
   onClose:function( selectedDate ) {
		$( "#depart_date_end_picker" ).datepicker( "option", "maxDate", selectedDate );
	}
});
$( "#depart_date_end_picker" ).datepicker({
	defaultDate: new Date(),
	altField: '#depart_date_end',
	altFormat: '@',
	changeMonth: true,
	numberOfMonths: 1,
	onClose: function( selectedDate ) {
		$( "#depart_date_start_picker" ).datepicker( "option", "maxDate", selectedDate );
	}
});
$( "#arrival_date_start_picker" ).datepicker({
	defaultDate: new Date(),
	altField: '#arrival_date_start',
	altFormat: '@',
	changeMonth: true,
	numberOfMonths: 1,
	onClose: function( selectedDate ) {
		$( "#arrival_date_end_picker" ).datepicker( "option", "minDate", selectedDate );
	}
});
$( "#arrival_date_end_picker" ).datepicker({
	defaultDate: new Date(),
	altField: '#arrival_date_end',
	altFormat: '@',
	changeMonth: true,
	numberOfMonths: 1,
	onClose: function( selectedDate ) {
		$( "#arrival_date_start_picker" ).datepicker( "option", "maxDate", selectedDate );
	}
});
