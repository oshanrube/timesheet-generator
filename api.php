<?php 
session_start();
require_once 'lib/mysql.php';
require_once 'lib/excel.php';

class timesheetApi{
	
	private $connection,$error;
	private $clock_in_threadshold = 40;//40 seconds

	public function __construct(){
		//establish the db connection
		$this->connection = new Mysql();
	}
	public function clockIn($time) {
		//if its an interval
		if($this->getInterval())
			return false;
		//get latest task
		$query = 'SELECT *  FROM `task` WHERE `end_time` IS NULL ORDER BY `start_time` DESC LIMIT 0,1';
		if($task = $this->connection->getone($query)){
			//get the latest worklog for this
			$query = 'SELECT *  
				FROM `work_log` 
				WHERE
					`task_id` = '.$task->id.' AND
					`project_id` = '.$task->project_id.' AND 
					`end_time` <= FROM_UNIXTIME('.$time.') AND
					`end_time` >= FROM_UNIXTIME('.($time - $this->clock_in_threadshold).') 
				ORDER BY `end_time` DESC LIMIT 0,1';
			//if there is a previous work
			if($work = $this->connection->getone($query)){
				//update the endtime
				$query = "UPDATE `work_log` SET 
					`end_time` = `end_time`+ INTERVAL ".($time - strtotime($work->end_time))." SECOND,
					`total_hours` = SEC_TO_TIME(TIME_TO_SEC(`total_hours`) + ".($time - strtotime($work->end_time)).") 
					WHERE `id` = ".$work->id.";";
				$this->connection->query($query);
			} else {
				//create work log
				$query = 'INSERT INTO `work_log`
					(`project_id`, `task_id`, `start_time`, `end_time`, `total_hours`) 
				VALUES
					('.$task->project_id.','.$task->id.',"'.date('Y-m-d H:i:s',$time).'","'.date('Y-m-d H:i:s',$time).'",0)';
				return $this->connection->query($query);
			}
		} else 
			//no active tasks
			return false;
		
	}
	public function addNewProject($post){
		//validate 
		if(empty($post['name']))
			return false;
		//create query
		$query = 'INSERT INTO `project` 
				(`name`, `description`, `start_date`) 
			  VALUES 
				("'.mysql_escape_string($post['name']).'", "'.mysql_escape_string($post['description']).'", NOW())';
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
		//delete all the worklogs
		$query = 'DELETE FROM `work_log`	WHERE `project_id` = "'.mysql_escape_string($post['id']).'" ';
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		}
		$query = 'DELETE FROM `task`	WHERE `project_id` = "'.mysql_escape_string($post['id']).'" ';
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		}
		//delete the project
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
	public function getTasks(){
		//query the projects in the database
		$query = 'SELECT * FROM `task`';
		if(!$tasks = $this->connection->fetch($query)){
			$this->error = $this->connection->getError();
			return false;
		} else {
			return $tasks;
		}
	}
	public function getDefaultTask() {
		//get the latest task
		$query = 'SELECT *  FROM `task` WHERE `end_time` IS NULL ORDER BY `start_time` DESC LIMIT 0,1';
		if($task = $this->connection->getone($query)){
			return (array)$task;
		}
		//
		$data = array();
		$data['start_time'] = date('Y-m-d H:i:s');
		$data['end_time'] = '';
		$data['comment'] = '';
		return $data;
	}
	public function startTask($post){
		//validate 
		if(empty($post['project_id']) || !preg_match("/project\-[0-9]+/",$post['project_id']) || empty($post['comment']) || empty($post['start_time']))
			return false;
		$post['project_id'] = str_replace('project-','',$post['project_id']);
		//create query
		$query = 'INSERT INTO `task` 
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
	public function stopTask($post){
		//validate 
		if(empty($post['project_id']) || !preg_match("/project\-[0-9]+/",$post['project_id']) || empty($post['id']) || !preg_match("/task\-[0-9]+/",$post['id']) )
			return false;
		$post['id'] = str_replace('task-','',$post['id']);
		//create query
		$query = 'UPDATE `task` SET `end_time` = NOW() WHERE id = "'.mysql_escape_string($post['id']).'" ';
		//execute
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
	}
	public function deleteWorksheet($post){
		//validate 
		if(empty($post['id']) && preg_match("/worksheet-[0-9]+/",$post['id']))
			return false;
		$post['id'] = str_replace('worksheet-','',$post['id']);
		//create query
		$query = 'DELETE FROM `work_log`	WHERE `id` = "'.mysql_escape_string($post['id']).'" ';
		//execute
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
	}
	public function getWorksheets(){
		//query the projects in the database
		$query = 'SELECT p.name as projectname, t.comment as taskname, w.* 
			FROM `work_log` as w,`project` as p,`task` as t 
			WHERE w.`project_id` = p.`id` AND w.`task_id` = t.`id` 
			ORDER BY w.end_time DESC';
		if(!$worksheets = $this->connection->fetch($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return $worksheets;
	}
	public function exportWorksheet(){
		//get worklog
		$query = 'SELECT p.name as projectname, t.comment as taskname, w.* 
			FROM `work_log` as w,`project` as p,`task` as t 
			WHERE w.`project_id` = p.`id` AND w.`task_id` = t.`id`
			ORDER BY  `w`.`end_time`';
		if(!$worksheets = $this->connection->fetch($query)){
			$this->error = $this->connection->getError();
			return false;
		}
		//get total task hours
		//get total project Hours
		//export to excel
		$excel = new Excel();
		$excel->createExcel($worksheets);
		
	}
	public function getInterval(){
		if(isset($_SESSION['interval']) && $_SESSION['interval'] != ''){
			return $_SESSION['interval'];
		} else {
			return false;
		}
	}
	public function toggleInterval($data){
		if(isset($_SESSION['interval']) && $_SESSION['interval'] != ''){
			unset($_SESSION['interval']);
		} else {
			if($data['reason'] == '')
				$data['reason'] = 'No special reason';
			$_SESSION['interval'] = $data['reason'];
		}
	}
	public function getError(){
		return $this->error;
	}
}
