<?php
require_once 'api.php';
$api = new timesheetApi();
?>
<form action="server.php?action=export" method="POST">
	<select name="project_id" id="project">
		<option value="">All Projects</option>
		<?php foreach($api->getProjects() as $project):?>
			<option value="project-<?php echo $project->id?>"><?php echo $project->name?></option>
		<?php endforeach;?>
	</select>
	<select name="task_id" id="task">
		<option value="">All Tasks</option>
		<?php foreach($api->getTasks() as $task):?>
			<option id="task-project-<?php echo $task->project_id?>" value="task-<?php echo $task->id?>"><?php echo $task->comment?></option>
		<?php endforeach;?>
	</select>
	<select name="interval" id="interval">
		<option value="">Custom / All</option>
		<option value="day">Day</option>
		<option value="week">Week</option>
		<option value="month">Month</option>
		<option value="year">Year</option>
	</select>
	<div class="input-append date datepicker" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
		<input name="start_datetime" id="start_datetime" type="text" placeholder="From: (YYYY-MM-DD HH:MM:SS)"/>
	  <span class="add-on"><i class="icon-th"></i></span>
	</div>
	
	<div class="input-append date datepicker" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
		<input name="end_datetime" id="end_datetime" type="text" placeholder="To: (YYYY-MM-DD HH:MM:SS)"/>
		<span class="add-on"><i class="icon-th"></i></span>
	</div>
	<button class="btn btn-success"> Export </button>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('#project form').change(function(){
			var project_id = $(this).val();
			$('form #task option').show();
			if(project_id != ''){
				$('form #task option').each(function(){
					var id = $(this).attr('id');
					var pattern = '/task-'+project_id+'/';
					pattern.replace('-','\-');
					if( id && !(pattern.match(id))){						
						$(this).hide();
					}
				})
			}
		});
		$('.datepicker').datepicker();
		$('#interval').change(function(){
			var interval = $(this).val();
			if(interval != ''){
				$('form #start_time').attr("disabled", "disabled");
				$('form #end_time').attr("disabled", "disabled");
			} else {
				$('form #start_time').removeAttr("disabled");
				$('form #end_time').removeAttr("disabled");
			}
		});
	});
	
</script>
