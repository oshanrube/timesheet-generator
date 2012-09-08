<?php 
session_start();
require 'api.php';

switch($_GET['action']) {
	case "clock":
		$time = $_GET['time'];
		echo date('Y-m-d H:i:s',$time);
		file_put_contents('log.log',date('Y-m-d H:i:s',$time)."\n",FILE_APPEND);
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
}
