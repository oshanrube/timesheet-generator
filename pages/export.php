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
		<option value="day">Today</option>
		<option value="yesterday">Yesterday</option>
		<option value="week">This Week</option>
		<option value="month">This Month</option>
		<option value="year">This Year</option>
	</select>
	<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
		<input name="start_datetime" class="datepicker" id="start_datetime" type="text" placeholder="From: (YYYY-MM-DD HH:MM:SS)"/>
	  <span class="add-on"><i class="icon-th"></i></span>
	</div>
	
	<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
		<input name="end_datetime" class="datepicker" id="end_datetime" type="text" placeholder="To: (YYYY-MM-DD HH:MM:SS)"/>
		<span class="add-on"><i class="icon-th"></i></span>
	</div>
	<button class="btn btn-success"> Export </button>
</form>
<script type="text/javascript">
	$(document).ready(function(){
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
			var now = new Date();
		$('.datepicker').scroller({
        		preset: 'datetime',
        		theme: 'default',
		        display: 'modal',
        		mode: 'scroller',
		        dateFormat: 'yy-mm-dd',
		        dateOrder: 'yymmdd',
	        	timeFormat: 'HH:ii:ss'
		}); 
	});
	
</script>
