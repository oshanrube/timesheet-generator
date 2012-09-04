<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>CSS3 Digital Clock with jQuery</title>
<link type="text/css" rel="stylesheet" href="asserts/style.css" />
<script type="text/javascript" src="asserts/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="asserts/clock.js"></script>
</head>
<body>
<div class="container">
<div class="clock">
<div id="Date"></div>
<ul>
	<li id="hours"> </li>
    <li id="point">:</li>
    <li id="min"> </li>
    <li id="point">:</li>
    <li id="sec"> </li>
</ul>
<span id="status"></span>
</div>
<div id="project">
	<select name="project" id="project">
		<option value="DBA">DBA</option>
	</select>
	<input name="from" id="from" type="text" />
	<input name="to" id="to" type="text" />
	<textarea name="comment" id="comment"></textarea>
	<button class="btn" id="toggle_time"> Start </button>
</div>
</div>
</body>
</html>
