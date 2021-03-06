<?php
require_once 'api.php';
$api = new timesheetApi();
?>
<form class="form-inline" method="post" id="customTask" action="server.php?action=customTask">
<select name="project_id" id="project">
	<?php foreach($api->getProjects() as $project):?>
		<option value="project-<?php echo $project->id?>"><?php echo $project->name?></option>
	<?php endforeach;?>
</select>
<input type="text" name="comment" placeholder="Comment: " />
<div class="input-append date">
	<input name="start_datetime" class="datepicker" id="start_datetime" type="text" value="<?php echo $data['start_datetime']?>"  placeholder="From: (YYYY-MM-DD HH:MM:SS)"/>
  <span class="add-on"><i class="icon-th"></i></span>
</div>

<div class="input-append date">
	<input name="end_datetime" class="datepicker" id="end_datetime" type="text" value="<?php echo $data['end_datetime']?>"  placeholder="To: (YYYY-MM-DD HH:MM:SS)"/>
	<span class="add-on"><i class="icon-th"></i></span>
</div>
<button name="action" value="pause" class="btn btn-primary pull-right">Add</button>
</form>
<script>
$(document).ready(function(){
	var options = { 
		clearForm: true,
		success:    function() { loadStatus(); loadPage(); } 
	};
	$('form#customTask').ajaxForm(options);
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
