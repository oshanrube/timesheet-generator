<?php

include_once 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$worksheets = $api->getWorksheets();
$i = 0;
?>
<div id="worksheets-scrollbar" class="scrollbar">
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Project Name</th>
						<th>Comment</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Total Hours</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if($worksheets):?>
					<?php foreach($worksheets as $worksheet):?>
					<tr>
						<td><?php echo $i++?></td>
						<td><?php echo $worksheet->projectname;?></td>
						<td><?php echo $worksheet->taskname;?></td>
						<td><?php echo $worksheet->start_time;?></td>
						<td><?php echo $worksheet->end_time;?></td>
						<td><?php echo $worksheet->total_hours;?></td>
						<td><button type="button" id="worksheet-<?php echo $worksheet->id?>" class="delete" data-dismiss="alert">x</button></td>
					</tr>
					<?php endforeach;?>
					<?php else:?>
					<tr>
						<td colspan="7">No Worksheets are found</td>
					</tr>
					<?php endif;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#worksheets-scrollbar').tinyscrollbar();	
		$('#worksheets button.delete').click(function(){
			deleteWorksheet($(this).attr('id'));
		});
	});
</script>