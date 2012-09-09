<?php
require 'api.php';
$api = new timesheetApi();
$data = $api->getDefaultTask();
if($data['id'] == NULL)
	$task = "startTask";
else 
	$task = "stopTask";
?>
<form action="server.php?action=<?php echo $task?>" method="POST" id="job-details">
	<select name="project_id" id="project">
		<?php foreach($api->getProjects() as $project):?>
			<option value="project-<?php echo $project->id?>"><?php echo $project->name?></option>
		<?php endforeach;?>
	</select>
	<input name="start_time" id="start_time" type="text" value="<?php echo $data['start_time']?>"  placeholder="From: (YYYY-MM-DD HH:MM:SS)" required/>
	<input name="end_time" id="end_time" type="text" value="<?php echo $data['end_time']?>"  placeholder="To: (YYYY-MM-DD HH:MM:SS)"/>
	<textarea name="comment" id="comment"  placeholder="I did something cool" required><?php echo $data['comment']?></textarea>
	<?php if($data['id'] == NULL):?>
		<button class="btn btn-success" id="toggle_time" name="action" value="start" > Start </button>
	<?php else:?>
		<button class="btn btn-danger" id="toggle_time" name="action" value="end" > End </button>
	<?php endif;?>
	<input type="hidden" name="id" value="task-<?php echo $data['id']?>" />
</form>
<script type="text/javascript">
	$(document).ready(function(){
		var options = { 
			clearForm: true,
			success:    function() { loadStatus(); loadPage(); } 
		};
		$('form#job-details').ajaxForm(options);
	});
</script>
