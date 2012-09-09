<?php
require 'lib/page.php';
$page = new TimesheetPager();

switch($_GET['page']) {
	case "home":
		$page->getPage('home');
		break;
	case "projects":
		$page->getPage('projects');
		break;
	case "worksheets":
		$page->getPage('worksheets');
		break;
	case "export":
		include 'pages/export.php';
		break;
	default:
		echo "Happy Hunting";
		break;
}

echo $page->getJson();