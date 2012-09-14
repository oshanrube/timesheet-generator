<?php
require_once 'api.php';
$api = new timesheetApi();
?>
<form class="form-inline" method="post" id="interval" action="server.php?action=interval">
<?php if($reason = $api->getInterval()){ ?>
<label style="margin: 10px 10px 10px 0;height: 16px;padding: 6px;"  class="control-label"><?php echo $reason?></label>
<button name="action" value="resume" class="btn btn-info pull-right">Resume</button>
<?php } else { ?>
<input style="width: 583px;" type="text" name="reason" placeholder="Reason: I gotta go.... Do something...." />
<button name="action" value="pause" class="btn btn-primary pull-right">Pause</button>
<?php } ?>
</form>
<script>
$(document).ready(function(){
	var options = { 
		clearForm: true,
		success:    function() { loadStatus(); loadPage(); } 
	};
	$('form#interval').ajaxForm(options);
});
</script>