<?php 


$time = $_GET['time'];

echo date('Y-m-d H:i:s',$time);
file_put_contents('log.log',date('Y-m-d H:i:s',$time)."\n",FILE_APPEND);