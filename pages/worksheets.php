<?php

include_once 'api.php';

//list all the projects in the database
$api = new timesheetApi();
$worksheets = $api->getWorksheets();
$i = 0;
?>
<div class="row">
	<div class="id">ID</div>
	<div class="name">Project Name</div>
	<div class="comment">Comment</div>
	<div class="start-time">Start Time</div>
	<div class="end-time">End Time</div>
	<div class="total-hours">Total Hours</div>
	<div class="close"></div>
</div>
<div id="worksheets-scrollbar" class="scrollbar">
	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
	<div class="viewport">
		<div class="overview">
					<?php if($worksheets):?>
					<?php foreach($worksheets as $worksheet):?>
					<div class="row">
						<div class="id"><?php echo $i++?></div>
						<div class="name"><?php echo $worksheet->projectname;?></div>
						<div class="comment"><?php echo $worksheet->taskname;?></div>
						<div class="start-time"><?php echo $worksheet->start_datetime;?></div>
						<div class="end-time"><?php echo $worksheet->end_datetime;?></div>
						<div class="total-hours"><?php echo $worksheet->total_hours;?></div>
						<div class="close"><button type="button" id="worksheet-<?php echo $worksheet->id?>" class="delete" data-dismiss="alert">x</button></div>
					</div>
					<?php endforeach;?>
					<?php else:?>
					<div class="row">
						<div>No Worksheets are found</div>
					</div>
					<?php endif;?>
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