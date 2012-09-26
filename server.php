<?php 
if (!isset($_SESSION)) session_start();
require_once 'api.php';

switch($_GET['action']) {
	case "clock":
		$api = new timesheetApi();
		$api->clockIn($_GET['time']);
		break;
	case "getFlash":
		include_once 'controls/flash.php';
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
	case "customTask":
		$api = new timesheetApi();
		if(!$api->customTask($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'Custom Task Added';
		break;
	case "deleteWorksheet":
		$api = new timesheetApi();
		if(!$api->deleteWorksheet($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'Worksheet Deleted';
		break;
	case "export":
		$api = new timesheetApi();
		if(!$api->exportWorksheet($_POST))
			$_SESSION['error'] = $api->getError();
		else 
			$_SESSION['success'] = 'Worksheet Exported';
		break;
	case "interval":
		$api = new timesheetApi();
		$api->toggleInterval($_POST);
		break;
}
