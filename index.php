<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Timesheets</title>
<link type="text/css" rel="stylesheet" href="asserts/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="asserts/css/style.css" />
<link type="text/css" rel="stylesheet" href="asserts/css/tabber-style.css" media="screen"/>
<link type="text/css" rel="stylesheet" href="asserts/css/validationEngine.jquery.css" type="text/css"/>


<script type="text/javascript" src="asserts/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="asserts/js/clock.js"></script>
<script type="text/javascript" src="asserts/js/jquery.form.js"></script>
<script type="text/javascript" src="asserts/js/sliding.form.js"></script>
<script type="text/javascript" src="asserts/js/jquery.validationEngine.js" charset="utf-8"></script>

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
	<div class="menu-wrapper">
		<ul class="menu" rel="sam1">  
		<li><a href="home">Home</a></li>  
		<li><a href="projects">Projects</a></li>  
		<li><a href="worksheets">Worksheets</a></li>  
		<li><a href="export">Export</a></li>  
		</ul>  
	</div> 
	<div class="tabs-wrapper">
		<div id="contols"></div>
		<button id="refresh-btn"></button>
		<div id="tabs">
			<div id="home" class="tab">
			</div>
			<div id="projects" class="tab">
			</div>
			<div id="worksheets" class="tab">
			</div>
			<div id="export" class="tab">
			</div>
		</div>
	</div>
</div>
</body>
</html>
