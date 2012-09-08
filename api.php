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
		if(empty($post['id']) || !preg_match("/project\-[0-9]+/",$post['id']))
			return false;
		$post['id'] = str_replace('project-','',$post['id']);
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
			return $projects;
		}
	}
	public function getDefaultTask() {
		//get the latest task
		$query = 'SELECT *  FROM `work_log` WHERE `end_time` IS NULL ORDER BY `start_time` DESC LIMIT 0,1';
		if($task = $this->connection->getone($query)){
			return (array)$task;
		}
		//
		$data = array();
		$data['from'] = date('Y-m-d H:i:s');
		$data['to'] = '';
		$data['comment'] = '';
		return $data;
	}
	public function startTask($post){
		//validate 
		if(empty($post['project_id']) || !preg_match("/project\-[0-9]+/",$post['project_id']) || empty($post['comment']) || empty($post['start_time']))
			return false;
		//create query
		$query = 'INSERT INTO `work_log` 
				(`project_id`, `comment`, `start_time`) 
			  VALUES 
				("'.mysql_escape_string($post['project_id']).'", "'.mysql_escape_string($post['comment']).'", "'.mysql_escape_string($post['start_time']).'")';
		//execute
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
	}
	public function deleteWorksheet($post){
		//validate 
		if(empty($post['id']) && preg_match("/project-[0-9]+/",$post['id']))
			return false;
		$post['id'] = str_replace('project-','',$post['id']);
		//create query
		$query = 'DELETE FROM `project`	WHERE `id` = "'.mysql_escape_string($post['id']).'" ';
		//execute
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
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
