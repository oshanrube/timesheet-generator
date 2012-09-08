<?php 
require 'lib/mysql.php';


class timesheetApi{
	
	private $connection;

	public function __construct(){
		//establish the db connection
		$this->connection = new Mysql();
	}
	public function addNewProject($post){
		//validate 
		if(empty($post['name']) || empty($post['description']))
			return false;
		//create query
		$query = 'INSERT INTO `project` 
				(`name`, `description`) 
			  VALUES 
				("'.mysql_escape_string($post['name']).'", "'.mysql_escape_string($post['description']).'")';
		//execute
		return $this->connection->query($query);
	}
	public function deleteProject($post){
		//validate 
		if(empty($post['id']))
			return false;
		//create query
		$query = 'DELETE FROM `project`
			WHERE
				`id` = "'.mysql_escape_string($post['id']).'" ';
		//execute
		return $this->connection->query($query);
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
