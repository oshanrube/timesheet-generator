<?php

include_once 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$projects = $api->getProjects();
$i = 0;
?>
<div class="row">
	<div class="id">ID</div>
	<div class="name">Project Name</div>
	<div class="description">Project Description</div>
	<div class="start-date">Start Datetime</div>
	<div class="end-date">End Datetime</div>
	<div class="total-hours">Total Hours</div>
	<div class="close"></div>
</div>
<div id="projects-scrollbar" class="scrollbar">
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
					<?php if($projects):?>
					<?php foreach($projects as $project):?>
					<div class="row">
						<div class="id"><?php echo $i++?></div>
						<div class="name"><?php echo $project->name;?></div>
						<div class="description"><?php echo $project->description;?></div>
						<div class="start-date"><?php echo $project->start_datetime;?></div>
						<div class="end-date"><?php echo $project->end_datetime;?></div>
						<div class="total-hours"><?php echo $project->total_hours;?></div>
						<div class="close"><button type="button" id="project-<?php echo $project->id?>" class="delete" data-dismiss="alert">x</button></div>
					</div>
					<?php endforeach;?>
					<?php else:?>
					<div class="row">
						<div>No Projects are found</div>
					</div>
					<?php endif;?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#projects-scrollbar').tinyscrollbar();	
		$('#projects button.delete').click(function(){
			deleteProject($(this).attr('id'));
		});
	});
</script>