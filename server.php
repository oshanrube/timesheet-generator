<?php 
session_start();
require 'api.php';

switch($_GET['action']) {
	case "clock":
		$api = new timesheetApi();
		$api->clockIn($_GET['time']);
		break;
	case "getFlash":
		include 'controls/flash.php';
		break;
	case "addNewProject":
		$api = new timesheetApi();
		if(!$api->addNewProject($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'New Project Created';
		break;
	case "deleteProject":
		$api = new timesheetApi();
		if(!$api->deleteProject($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'Project Deleted';
		break;
	case "startTask":
		$api = new timesheetApi();
		if(!$api->startTask($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'Task Started';
		break;
	case "stopTask":
		$api = new timesheetApi();
		if(!$api->stopTask($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'Task Stopped';
		break;
}
