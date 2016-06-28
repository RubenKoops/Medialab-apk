<?php
header("Access-Control-Allow-Origin: http://pakhuis.hosts.ma-cloud.nl, http://localhost:8000");
header("Access-Control-Allow-Credentials: true");
session_start();

/*
if($_SESSION['login'] != true){
	echo "logout";
	exit();
	}
*/
			
mysql_connect("localhost","medialab","xsx6u7g82");
mysql_select_db("medialab");
date_default_timezone_set('Europe/Amsterdam');



?>