<?php 
require 'lib/mysql.php';


class timesheetApi{
	
	private $connection;

	public function __construct(){
		//establish the db connection
		$this->connection = new Mysql();
	}
	
	public function getProjects(){
		//query the projects in the database
		$query = 'SELECT * FROM `project`';
		return $this->connection->fetch($query);
	}
	public function getWorksheets(){
		//query the projects in the database
		$query = 'SELECT * FROM `work_log` as w,`project` as p WHERE w.`project_id` = p.`id`';
		return $this->connection->fetch($query);
	}
}
