<?php 

switch($_GET['action']) {
	case "clock":
		$time = $_GET['time'];
		echo date('Y-m-d H:i:s',$time);
		file_put_contents('log.log',date('Y-m-d H:i:s',$time)."\n",FILE_APPEND);
		break;
	case "addProject":
		
		break;
}