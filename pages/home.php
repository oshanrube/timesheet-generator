<form action="server.php" method="POST" id="job-details">
	<select name="project" id="project">
		<option value="DBA">DBA</option>
	</select>
	<input name="from" id="from" type="text" placeholder="From: (YYYY-MM-DD HH:MM:SS)" />
	<input name="to" id="to" type="text" placeholder="To: (YYYY-MM-DD HH:MM:SS)"/>
	<textarea name="comment" id="comment" placeholder="I did something cool"></textarea>
	<button class="btn" id="toggle_time" name="action" value="start" > Start </button>
</form>
