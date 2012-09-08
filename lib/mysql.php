<?php

include 'dbconfig.php';

class Mysql extends Dbconfig    {

	public $connectionString;	
	protected $databaseName;
	protected $hostName;
    	protected $userName;
    	protected $passCode;

	function Mysql()    {
    		$this -> connectionString = NULL;
		$this -> sqlQuery = NULL;
		$this -> dataSet = NULL;
		$dbPara = new Dbconfig();
            	$this -> databaseName = $dbPara -> dbName;
            	$this -> hostName = $dbPara -> serverName;
            	$this -> userName = $dbPara -> userName;
            	$this -> passCode = $dbPara ->passCode;
            	$dbPara = NULL;
	}

	function dbConnect()    {
    		$this -> connectionString = mysql_connect($this -> serverName,$this -> userName,$this -> passCode);
    		mysql_select_db($this -> databaseName,$this -> connectionString);
    		return $this -> connectionString;
	}
	
	function query($sql) {
		if(!$this->connectionString)
			$this->dbConnect();
        	$result = MYSQL_QUERY ($sql, $this->connectionString) or DIE ("Invalid query: " . MYSQL_ERROR());
          	return $result;
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
          		$value = FALSE;
     		else
          		$value = MYSQL_RESULT($result, 0);
          	return $value;
     	}
}
