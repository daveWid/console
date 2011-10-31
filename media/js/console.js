/**
 * Log viewer Javascript
 */
$(document).ready( function(){
	// Hide the directory tree
	$('#directory .year').hide();
	$('#directory .files').hide();

	// Open up the active year/month
	var active = $('#directory .files li.active');

	if( active ) {
		$(active).parent('ul').show();
		$(active).parents('.year').show();
	}

} );

$(function(){

	// Slide in years
	$('#directory h2').click( function(){
		// Show/hide the year
		var year = $(this).next('.year');

		( $(year).is(':visible') ) ?
			$(year).slideUp('normal') :
			$(year).slideDown('normal') ;
			$
	} );

	// Fade in files
	$('#directory h3').click( function(){
		// Get the list
		var ul = $(this).siblings('ul');

		// Slide up or down
		if( $(ul).is(':visible') ){
			$(ul).slideUp('normal');
		}
		else {
			$(ul).slideDown('normal');
		}
	} );

	// Hover click
	$('.entry').click( function(){
		// Entry
		$(this).toggleClass('call-out');
	} );

});