<?php
require_once 'api.php';
$api = new timesheetApi();
?>
<form class="form-inline" method="post" id="customTask" action="server.php?action=customTask">
<select name="project_id" id="project">
	<?php foreach($api->getProjects() as $project):?>
		<option value="project-<?php echo $project->id?>"><?php echo $project->name?></option>
	<?php endforeach;?>
</select>
<input type="text" name="comment" placeholder="Comment: " />
<div class="input-append date datepicker" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
	<input name="start_time" id="start_time" type="text" value="<?php echo $data['start_datetime']?>"  placeholder="From: (YYYY-MM-DD HH:MM:SS)"/>
  <span class="add-on"><i class="icon-th"></i></span>
</div>

<div class="input-append date datepicker" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
	<input name="end_datetime" id="end_datetime" type="text" value="<?php echo $data['end_datetime']?>"  placeholder="To: (YYYY-MM-DD HH:MM:SS)"/>
	<span class="add-on"><i class="icon-th"></i></span>
</div>
<button name="action" value="pause" class="btn btn-primary pull-right">Add</button>
</form>
<script>
$(document).ready(function(){
	var options = { 
		clearForm: true,
		success:    function() { loadStatus(); loadPage(); } 
	};
	$('form#customTask').ajaxForm(options);
	$('.datepicker').datepicker();
});
</script>
