<?php
/*
$id=strtoupper($_POST['id']);
$type=$_POST['type'];
$name=$_POST['name'];
$date= date("Y-m-d H:i:s");
$editdate= $date;
$owner=$_POST['owner'];
$action = $_POST['action'];
*/
//"SELECT * FROM `inventory` ORDER BY date DESC"
//"INSERT INTO inventory (id,type,name,date,editdate,owner) VALUES ('$id','$type','$name','$date','$date','$owner')"
//"UPDATE inventory SET type='$type', name='$name', editdate='$editdate', owner='$owner' WHERE id='$id'"
//"DELETE FROM inventory WHERE id='$id'"
//"SELECT id FROM `inventory`"

include "includes.php";

$id=strtoupper($_POST['id']);
$type=$_POST['type'];
$name=$_POST['name'];
$date= date("Y-m-d H:i:s");
$editdate= $date;
$owner=$_POST['owner'];

//select, insert, update
$action = $_POST['action'];
//cols en values gescheiden met komma
$cols = $_POST['cols'];
$values = $_POST['values'];
//table name
$table = $_POST['table'];
//ordenen coll
$keycol = $_POST['keycol'];
$keyvalue = $_POST['keyvalue'];
//ASC of DESC
$order = $_POST['order'];


if(!$_POST['action']){
	echo "geen data";
	}
//////////////////////////////////////////////////////////
//														//
//						  SELECT						//
//														//
//////////////////////////////////////////////////////////
//"SELECT * FROM `inventory` ORDER BY date DESC"
if($action == 'select'){
	$data=array();
	$q=mysql_query("SELECT $cols FROM $table ORDER BY $keycol $order");
	while ($row=mysql_fetch_object($q)){
		$data[]=$row;
		//$id = $row->id;
		}
	echo json_encode($data);
	}
//////////////////////////////////////////////////////////
//														//
//						  INSERT						//
//														//
//////////////////////////////////////////////////////////
//"INSERT INTO inventory (id,type,name,date,editdate,owner) VALUES ('$id','$type','$name','$date','$date','$owner')"
if($action == 'insert'){
	$values_array = explode(",",$values);
	$values_string = implode("','", $values_array);
	$values_string = "'".$values_string."'";
	
	$q=mysql_query("INSERT INTO $table ($cols) VALUES ($values_string)");
	if($q){
		echo "ok";
		}else{
			echo "Error message = ".mysql_error();
			}
		  
	}
//////////////////////////////////////////////////////////
//														//
//						  UPDATE						//
//														//
//////////////////////////////////////////////////////////
//"UPDATE inventory SET type='$type', name='$name', editdate='$editdate', owner='$owner' WHERE id='$id'"
if($action == 'update'){
	$values_array = explode(",",$values);
	$cols_array = explode(",",$cols);
	$count = count($cols_array);
	while($x <= $count){
		$update_array[] = $cols_array[$x]."='".$values_array[$x]."'";
		$x++;
		}
	$update_string = implode(", ", $update_array);
	
	$q=mysql_query("UPDATE $table SET $update_string WHERE $keycol='$keyvalue'");
	if($q){
		echo "ok";
		}else{
			echo "Error message = ".mysql_error();
			}
		  
	}
//////////////////////////////////////////////////////////
//														//
//						  DELETE						//
//														//
//////////////////////////////////////////////////////////
//"DELETE FROM inventory WHERE id='$id'"
if($action == 'delete'){
	$q=mysql_query("DELETE FROM $table WHERE $keycol='$keyvalue'");
	if($q){
		echo "ok";
		}else{
			echo "Error message = ".mysql_error();
			}
	}
?>