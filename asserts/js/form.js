function loadStatus(){
	//get status
	var url = 'server.php?action=getFlash';
	$.ajax({
		url: url,
	}).done(function(r){
		$('#flash').html(r);
	});
}
function deleteProject(id){
	//get status
	var url = 'server.php?action=deleteProject';
	$.post(url,{id:id},function(result){
		loadStatus();
		loadPage();
	});
}