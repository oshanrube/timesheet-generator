<?php

include 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$projects = $api->getProjects();
$i = 0;
?>
<div id="projects-scrollbar" class="scrollbar">
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
			<table class="table">
				<thead>
					<tr>
						<th>Project Id</th>
						<th>Project Name</th>
						<th>Project Description</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Total Hours</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if($projects):?>
					<?php foreach($projects as $project):?>
					<tr>
						<td><?php echo $i++?></td>
						<td><?php echo $project->name;?></td>
						<td><?php echo $project->description;?></td>
						<td><?php echo $project->start_date;?></td>
						<td><?php echo $project->end_date;?></td>
						<td><?php echo $project->total_hours;?></td>
						<td><button type="button" id="project-<?php echo $project->id?>" class="delete" data-dismiss="alert">x</button></td>
					</tr>
					<?php endforeach;?>
					<?php else:?>
					<tr>
						<td colspan="7">No Projects are found</td>
					</tr>
					<?php endif;?>
				</tbody>
			</table>
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