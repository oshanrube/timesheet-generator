<?php

include 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$projects = $api->getProjects();
$i = 0;
?>
<table>
	<thead>
		<tr>
			<th>Project Id<th>
			<th>Project Name<th>
			<th>Project Description</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Total Hours</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($projects as $project):?>
		<tr>
			<td><?php echo $i++?></td>
			<td><?php echo $table->name;?></td>
			<td><?php echo $table->description;?></td>
			<td><?php echo $table->start_date;?></td>
			<td><?php echo $table->end_date;?></td>
			<td><?php echo $table->total_hours;?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
