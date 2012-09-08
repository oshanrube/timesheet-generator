<form id="project" action="server.php?action=addNewProject" method="post">
	<input type="text" data-errormessage-value-missing="Project Name is required!" name="name" placeholder="Project Name" required/>
	<input type="text" data-errormessage-value-missing="Project Name is required!" name="description" placeholder="Project Description" required/>
	<button type="submit" class="btn btn-primary" >Add New Project</button>
</form>
<script> 
// wait for the DOM to be loaded 
$(document).ready(function() { 
	// bind 'myForm' and provide a simple callback function 
	var options = { 
		clearForm: true,
		success:    function() { loadStatus(); loadPage(); } 
	}; 
	$('form#project').ajaxForm(options);
}); 
</script>
