<?php 
require 'lib/mysql.php';


class timesheetApi{
	
	private $connection,$error;

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
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
	}
	public function deleteProject($post){
		//validate 
		if(empty($post['id']))
			return false;
		//create query
		$query = 'DELETE FROM `project`	WHERE `id` = "'.mysql_escape_string($post['id']).'" ';
		//execute
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
	}
	public function getProjects(){
		//query the projects in the database
		$query = 'SELECT * FROM `project`';
		if(!$projects = $this->connection->fetch($query)){
			$this->error = $this->connection->getError();
			return false;
		} else {
			var_dump($projects);
			return $projects;
		}
	}
	public function getWorksheets(){
		//query the projects in the database
		$query = 'SELECT * FROM `work_log` as w,`project` as p WHERE w.`project_id` = p.`id`';
		if(!$projects = $this->connection->fetch($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return $projects;
	}
	public function getError(){
		return $this->error;
	}
}
