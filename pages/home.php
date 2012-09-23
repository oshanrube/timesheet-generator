<?php
require_once 'api.php';
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
			<option value="project-<?php echo $project->id?>" <?php if($data['project_id'] == $project->id)echo "selected"; ?>><?php echo $project->name?></option>
		<?php endforeach;?>
	</select>
	<textarea name="comment" id="comment"  placeholder="I did something cool" required><?php echo $data['comment']?></textarea>
	<?php if($data['id']){?>
	<button type="button" class="btn" id="updatebtn" disabled> Update </button>
	<?php } else {?>
	<select name="task_id" id="task">
		<option value="">New Task</option>
		<?php foreach($api->getTasks() as $task):?>
			<option id="task-project-<?php echo $task->project_id?>" value="task-<?php echo $task->id?>"><?php echo $task->comment?></option>
		<?php endforeach;?>
	</select>
	<?php }?>
	<?php if($data['id'] == NULL):?>
		<button class="btn btn-success" id="toggle_datetime" name="action" value="start" > Start </button>
	<?php else:?>
		<button class="btn btn-danger" id="toggle_datetime" name="action" value="end" > End </button>
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
		$('form#job-details #comment').change(function(){
			$('form#job-details #updatebtn').attr("disabled",false);
		});
		$('#project').change(function(){
			var project_id = $(this).val();
			$('form #task option').show();
			if(project_id != ''){
				$('form #task option').each(function(){
					var id = $(this).attr('id');
					var pattern = 'task-'+project_id;
					if( id && !(pattern.match(id))){						
						$(this).hide();
					}
				})
			}
		});
		$('#task').change(function(){
			if($(this).val() == ''){
				$('form#job-details #comment').text("");
				$('form#job-details #toggle_datetime').text('Start');
			} else {
				$('form#job-details #comment').text($(this).find('option:selected').text()+' - continue');
				$('form#job-details #toggle_datetime').text('Continue');
			}
		});
	});
</script>
