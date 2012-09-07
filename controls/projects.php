<form id="project" action="server.php" method="post">
	<input type="text" name="name" placeholder="Project Name" />
	<input type="text" name="description" placeholder="Project Description" />
	<button type="submit" class="btn btn-primary" name="action" value="addNewProject">Add New Project</button>
</form>
<script> 
// wait for the DOM to be loaded 
$(document).ready(function() { 
	// bind 'myForm' and provide a simple callback function 
	$('form#project').ajaxForm(function() { 
		alert("Thank you for your comment!"); 
	}); 
}); 
</script>