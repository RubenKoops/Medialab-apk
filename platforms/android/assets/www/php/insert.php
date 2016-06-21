<?php
 include "includes.php";
 if(isset($_POST['id']))
 {
 $id=strtoupper($_POST['id']);
 $type=$_POST['type'];
 $name=$_POST['name'];
 $date= date("Y-m-d H:i:s");
 $editdate= date("Y-m-d H:i:s");
 $owner=$_POST['owner'];
 $action = $_POST['action'];
 
 if($action == "insert"){
	 $unique = true;
 
	$q=mysql_query("SELECT id FROM `Medialab_inventory`");
	while ($row=mysql_fetch_object($q)){
		$id_db = $row->id;
		if($id_db == $id){
			echo "Deze id bestaat al";
			$unique = false;
			}
		}
	 if($unique == true){
		  $q=mysql_query("INSERT INTO Medialab_inventory (id,type,name,date,owner) VALUES ('$id','$type','$name','$date','$owner')");
		 if($q)
		  echo "ok";
		 else
		  echo "Error message = ".mysql_error();
		  
		  if($_POST['note']){
			  $note_id = uniqid();
			  $note=$_POST['note'];
			  
			  $q=mysql_query("INSERT INTO Medialab_notes (id,date,note,owner) VALUES ('$note_id','$date','$note','$owner')");
			  $q=mysql_query("UPDATE Medialab_inventory SET notes = CONCAT( notes, '$note_id|') WHERE id='$id'");
			  
			  }
		  
		 } 
 	}
	
	if($action == "update"){
		$q=mysql_query("UPDATE Medialab_inventory SET type='$type', name='$name', editdate='$editdate', owner='$owner' WHERE id='$id'");
		 if($q)
		  echo "ok";
		 else
		  echo "Error message = ".mysql_error();
 	}
	
	if($action == "delete"){
		$q=mysql_query("DELETE FROM Medialab_inventory WHERE id='$id'");
		 if($q)
		  echo "ok";
		 else
		  echo "Error message = ".mysql_error();
 	}
	 }

 ?>