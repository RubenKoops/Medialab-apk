<?php
header("Access-Control-Allow-Origin: http://pakhuis.hosts.ma-cloud.nl, http://localhost:8000");
header("Access-Control-Allow-Credentials: true");
session_start();

if(($_SESSION['username'])&&($_SESSION['role']=="docent" || $_SESSION['role']=="admin")){
	if($_SESSION['klas']!="geen"){
		$klas_map = $_SESSION['klas']."/";
		
		}
	
	include("../users/".$klas_map.$_SESSION['username']."/userdata.php");
	
	if (($_SESSION['username'] == $username) && ($_SESSION['password'] == $password)){
		$login = true;
		if($_POST['login_status'] && $login = true){
			echo "login";
			}else{ 
			echo "logout";
			exit();
			}
		}
	}
			
mysql_connect("localhost","medialab","xsx6u7g82");
mysql_select_db("medialab");
date_default_timezone_set('Europe/Amsterdam');



?>