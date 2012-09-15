<?php

include_once 'dbconfig.php';

class Mysql extends Dbconfig    {

	public $connectionString;	
	protected $dbName;
	protected $serverName;
	protected $userName;
	protected $passCode;
	private $error;

	function Mysql()    {
		$this -> connectionString = NULL;
		$this -> sqlQuery = NULL;
		$this -> dataSet = NULL;
		$dbPara = new Dbconfig();
		$this -> dbName = $dbPara -> dbName;
		$this -> serverName = $dbPara -> serverName;
		$this -> userName = $dbPara -> userName;
		$this -> passCode = $dbPara ->passCode;
		$dbPara = NULL;
	}

	function dbConnect()    {
		$this -> connectionString = mysql_connect($this -> serverName,$this -> userName,$this -> passCode);
		mysql_select_db($this -> dbName,$this -> connectionString);
		return $this -> connectionString;
	}
	
	function query($sql) {
		if(!$this->connectionString)
			$this->dbConnect();
		if($result = MYSQL_QUERY ($sql, $this->connectionString))
			return $result;
		$this->error = MYSQL_ERROR();
		return false;
	}
	function getLastId() {
		return  mysql_insert_id();
	}
     
	function fetch($sql) {
		$data = ARRAY();
		$result = $this->query($sql);
 
		while($row = MYSQL_FETCH_OBJECT($result)) {
			$data[] = $row;
		}
		return $data;
	}
     
	function getone($sql) {
		$result = $this->query($sql); 
		if(MYSQL_NUM_ROWS($result) == 0)
			return FALSE;
		else
			return MYSQL_FETCH_OBJECT($result);
	}

	function getError(){
		return $this->error;
	}
}
