<?php

include 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$projects = $api->getProjects();
$i = 0;
?>
<div id="scrollbar1">
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
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#scrollbar1').tinyscrollbar();	
		$('#projects button.delete').click(){
			deleteProject($(this).attr('id'));
		});
	});
</script>