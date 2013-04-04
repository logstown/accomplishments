$(document).ready(function() {
	if($('#message').html().trim() !== '') {
		flashMessage();
	}    
});

// Alert drop down when #message is populated
function flashMessage(){
	$('#message').fadeIn(500).delay(2000).fadeOut(500);

}