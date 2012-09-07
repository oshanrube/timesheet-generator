<?php

include 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$worksheets = $api->getWorksheets();
$i = 0;
?>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Project Name<th>
			<th>Comment</th>
			<th>Start Time</th>
			<th>End Time</th>
			<th>Total Hours</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($worksheets as $worksheet):?>
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
