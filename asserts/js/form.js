$(document).ready(function() {
}); 
function loadStatus(){
	//get status
	var url = 'server.php?action=getFlash';
   $.ajax({
		url: url,
	}).done(function(r){
		$('#flash').html(r);
	});
}

