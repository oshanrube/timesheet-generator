<?php 
if (!isset($_SESSION)) session_start();
//set default timezone to UTC
date_default_timezone_set("UTC");
require_once 'lib/mysql.php';
require_once 'lib/excel.php';

class timesheetApi{
	
	private $connection,$error;
	private $offset = 0;
	private $clock_in_threadshold = 40;//40 seconds

	public function __construct(){
		//establish the db connection
		$this->connection = new Mysql();		
		//get user timezone
		$this->offset -= $_COOKIE["time_zone_offset"] * 60;
	}
	public function clockIn($time) {
		//if its an interval
		if($this->getInterval())
			return false;
		//get latest task
		$query = 'SELECT *  FROM `task` WHERE `end_datetime` IS NULL ORDER BY `start_datetime` DESC LIMIT 0,1';
		if($task = $this->connection->getone($query)){
			//get the latest worklog for this
			$query = 'SELECT *  
				FROM `work_log` 
				WHERE
					`task_id` = '.$task->id.' AND
					`project_id` = '.$task->project_id.' AND 
					`end_datetime` <= '.$time.' AND
					`end_datetime` >= '.($time - $this->clock_in_threadshold).' 
				ORDER BY `end_datetime` DESC LIMIT 0,1';
			//if there is a previous work
			if($work = $this->connection->getone($query)){
				//update the endtime
				$query = "UPDATE `work_log` SET 
					`end_datetime` = ".$time.",
					`total_hours` = SEC_TO_TIME(TIME_TO_SEC(`total_hours`) + ".($time - $work->end_datetime).") 
					WHERE `id` = ".$work->id.";";
				$this->connection->query($query);
			} else {
				//create work log
				$query = 'INSERT INTO `work_log`
					(`project_id`, `task_id`, `start_datetime`, `end_datetime`, `total_hours`) 
				VALUES
					('.$task->project_id.','.$task->id.',"'.$time.'","'.$time.'",0)';
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
				(`name`, `description`, `start_datetime`) 
			  VALUES 
				("'.mysql_escape_string($post['name']).'", "'.mysql_escape_string($post['description']).'", '.time().')';
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
		}
		return $this->updateDateTime($projects);
	}
	public function getDefaultTask() {
		//get the latest task
		$query = 'SELECT *  FROM `task` WHERE `end_datetime` IS NULL ORDER BY `start_datetime` DESC LIMIT 0,1';
		if($task = $this->connection->getone($query)){
			$task = (array)$task;
			$task['start_datetime'] = date('Y-m-d H:i:s', $task['start_datetime']);
			return $task;
		}
		//
		$data = array();
		$data['start_datetime'] = date('Y-m-d H:i:s');
		$data['end_datetime'] = '';
		$data['comment'] = '';
		return $data;
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
	public function startTask($post){
		//validate 
		if(empty($post['project_id']) || !preg_match("/project\-[0-9]+/",$post['project_id']) || empty($post['comment']))
			return false;
		$post['project_id'] = str_replace('project-','',$post['project_id']);
		//create query
		$query = 'INSERT INTO `task` 
				(`project_id`, `comment`, `start_datetime`) 
			  VALUES 
				("'.mysql_escape_string($post['project_id']).'", "'.mysql_escape_string($post['comment']).'", '.time().')';
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
		$query = 'UPDATE `task` SET `end_datetime` = '.time().' WHERE id = "'.mysql_escape_string($post['id']).'" ';
		//execute
		if(!$this->connection->query($query)){
			$this->error = $this->connection->getError();
			return false;
		} else
			return true;
	}
	public function customTask($post){
		//validate 
		if(
			empty($post['project_id']) || 
			!preg_match("/project\-[0-9]+/",$post['project_id']) || 
			empty($post['comment']) || 
			empty($post['start_datetime']) || 
			empty($post['end_datetime']) 
		)
			return false;
		$post['project_id'] = str_replace('project-','',$post['project_id']);
		//set times to UTC
		$start_datetime 	= ( strtotime($post['start_datetime']) - $this->offset );
		$end_datetime 		= ( strtotime($post['end_datetime']) - $this->offset );
		//create a new task
		$query = "INSERT INTO `task`(
				`project_id`, `comment`, `start_datetime`, `end_datetime`, `total_hours`) 
			VALUES (
				".mysql_escape_string($post['project_id']).", 
				\"".mysql_escape_string($post['comment'])."\", 
				". $start_datetime .",
				". $end_datetime .",
				SEC_TO_TIME(".(strtotime($post['end_datetime']) - strtotime($post['start_datetime'])).") 
				)";
		if(!$this->connection->query($query)){
      	$this->error = $this->connection->getError();
      	return false;
      } 
		//create log entry
		$taskId = $this->connection->getLastId();
		$query = 'INSERT INTO `work_log`
					(`project_id`, `task_id`, `start_datetime`, `end_datetime`, `total_hours`) 
				VALUES
					('.mysql_escape_string($post['project_id']).','.$taskId.','. $start_datetime .','. $start_datetime .',
					SEC_TO_TIME('.(strtotime($post['end_datetime']) - strtotime($post['start_datetime'])).') )';
		if(!$this->connection->query($query)){
      	$this->error = $this->connection->getError();
      	return false;
      }
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
			ORDER BY w.id DESC';
		if(!$worksheets = $this->connection->fetch($query)){
			$this->error = $this->connection->getError();
			return false;
		}
		return $this->updateDateTime($worksheets);
	}
	public function exportWorksheet($post){
		//get worklog
		$query = 'SELECT p.name as projectname, t.comment as taskname, w.* 
			FROM `work_log` as w,`project` as p,`task` as t 
			WHERE w.`project_id` = p.`id` AND w.`task_id` = t.`id` ';
		//if project id
		if($post['project_id'])
			$query .= ' AND p.id = '.str_replace('project-','',$post['project_id']);
		//if task id
		if($post['task_id'])
			$query .= ' AND t.id = '.$post['task_id'];
		//if task id
		if($post['interval'])
			$query .= $this->getIntervalQuery($post['interval']);
		if($post['start_datetime'])
			$query .= ' AND w.start_datetime >= '.strtotime($post['start_datetime']);
		if($post['end_datetime'])
			$query .= ' AND w.end_datetime <= '.strtotime($post['end_datetime']);
		$query .= ' ORDER BY  `w`.`start_datetime`';

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
	public function getIntervalQuery($interval) {
		switch($interval) {
			case 'day':
				$start_datetime 	= strtotime('midnight');
				$end_datetime 		= strtotime('tomorrow midnight');
				break;
			case 'yesterday':
				$start_datetime 	= strtotime('yesterday midnight');
				$end_datetime 		= strtotime('midnight');
				break;
			case 'week':
				$start_datetime 	= strtotime('monday this week');
				$end_datetime 		= strtotime('sunday this week');
				break;
			case 'month':
				$start_datetime 	= strtotime('midnight first day of this month');
				$end_datetime 		= strtotime('midnight last day of this month');
				break;
			case 'year':
				$start_datetime 	= strtotime('first day of january this year');
				$end_datetime 		= strtotime('last day of december this year');
				break;
		}
		return " AND w.start_datetime >= ".$start_datetime." AND w.end_datetime <= ".$end_datetime;
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
	public function updateDateTime($records) {
		//loop though the records
		foreach($records as $key => $record){
			//if time related
			if($record->start_datetime)
				$record->start_datetime = 	date('d-m-Y H:i:s', ($record->start_datetime + $this->offset));
			if($record->end_datetime)
				$record->end_datetime = 	date('d-m-Y H:i:s', ($record->end_datetime + $this->offset)); 
			$records[$key] = $record;
		}
		return $records;
	}
	public function getError(){
		return $this->error;
	}
}
