<?php

//function index
/*
checkLogin('users',"$email","$password");
	controleer of login klopt, geeft terug "true/false|voornaam achternaam"

getDataFromDb('users', "$colnames","$colname","$colvalues");
	Haalt data uit database en stopt deze in een array, je kunt ook een colname en colvalue meegeven waar de date aan moet voldoen. Meerder colvalues scheiden met een komma.

writeDataToDb('users','voornaam,achternaam',"$voornaam,$achternaam",'insert/update');
	Schrijft date in de database, kijkt bij insert of in dit geval de voornaam uniek is, bij update worden bestaande gegevens aangepast

deleteFromDb('users','id',"$id");
	Delete row uit database als deze aan id voldoet 
	
makeMsg();
	Maakt popup message voor alle meldingen
*/

$servername = "rubenkoops.nl.mysql";
$username = "rubenkoops_nl";
$dbpassword = "QL4q8wdk";
$dbname = "rubenkoops_nl";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////             checkLogin           /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function checkLogin($tablename,$email, $password){
	global $servername, $username, $dbpassword, $dbname, $conn;
	
	//passworn encrypt
	$password_enc = hash("sha512", $password);
	$password_enc = substr($password_enc, 0, 10);
	
    // Create connection
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//////////////////
	
	$sql = "SELECT email, password, firstname, lastname, role FROM $tablename";
	//echo "SELECT email, password, firstname, lastname FROM $tablename";
	$result = $conn->query($sql);
	
	$return = 'Wrong e-mail or password';
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			
			if(strtolower($email) == $row["email"]){
				if($password_enc == $row["password"]){
					$return = 'true|'.$row['firstname'].' '.$row['lastname'].'|'.$row['role'].'|'.$row['email'];
					}
				}
		}
	}
	return $return;
}

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               einde              /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------------------------------------------------//
	
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////           GetDataFromDb          /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function getDataFromDb($tablename, $colnames, $colname, $colvalues){
	global $servername, $username, $dbpassword, $dbname, $conn;
	
	
	// Check connection
	if ($conn->connect_error) {
		echo "Connection failed: " . $conn->connect_error;
	}else{
		//echo "Connected successfully <br>";
		}
	
		if($colname){
			$colvalues_array = explode(",",$colvalues);
			foreach($colvalues_array as $colvalue){
				$colvalues_format = $colvalues_format.",'".$colvalue."'";}
			$colvalues_format = substr($colvalues_format,1);
				
			$sql = "SELECT $colnames FROM $tablename WHERE $colname IN ($colvalues_format)";
			//echo "SELECT $colnames FROM $tablename WHERE $colname IN ($colvalues_format)";
			}else{
				$sql = "SELECT $colnames FROM $tablename";
				//echo "SELECT $colnames FROM $tablename";
				}
		
		$colnames = explode(',',$colnames);
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				
				
				$string='';
				foreach ($colnames as $colname){
					//echo $row[$colname].'<br>';
					$string = $string.'|'.$row[$colname];
						
					}
					$return_array[]=substr($string,1);
			}
			
		} 
	return $return_array;
}
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               einde              /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------------------------------------------------//

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////           writeDataToDb          /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function writeDataToDb($tablename,$colnames,$colvalues,$action){
	
	global $servername, $username, $dbpassword, $dbname, $conn;
	
	$colvalues = str_replace("'","\'",strip_tags(str_replace("|"," ",$colvalues)));
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//////////////////
	$id_unique = true;
	$pieces = explode(",",$colvalues);
	$colvalue = strtolower($pieces[0]);
	
	$pieces = explode(",",$colnames);
	$colname = strtolower($pieces[0]);
	
	//controleert of de eerste value uniek is als de action 'insert' is
	if($action == 'insert'){
		$pieces = explode(",",$colnames);
		
		$sql = "SELECT $pieces[0] FROM $tablename";
		//echo "SELECT $pieces[0] FROM $tablename";
		$result = $conn->query($sql);
		
		
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				if($row[$colname] == $colvalue){$id_unique = false; $return = "<b>$colvalue</b> bestaat al in de database";}
				
			}
		}
	
	}
	///////////////////////////////////////////////////////////////
	
	//zet alle colvalues achter elkaar op een manier zodat de Mysql goed werkt
	$colvalues_array = explode(',',$colvalues);
	foreach($colvalues_array as $colvalue_unformat){
		$colvalues_format = $colvalues_format.",'".$colvalue_unformat."'";
		}
	$colvalues_format = substr($colvalues_format,1);
	//////////////////////////////////////////////////////////////////////////
	
	//Slaat de nieuwe logingegevens op in de database als de action 'insert' is
	if($id_unique == true && $action == 'insert'){
			
		$sql = "INSERT INTO $tablename ($colnames) VALUES ($colvalues_format)";
		//echo "INSERT INTO $tablename ($colnames) VALUES ($colvalues_format)";
		
		if ($conn->query($sql) === TRUE) {
			$return = "Gegevens opgeslagen";
		} else {
			$return = "Error: " . $sql . "<br>" . $conn->error;
		}
		
	}
	///////////////////////////////////////////////////////////////////////////
	
	//past bestaande gegevens aan als de action 'update' is
	if($action == 'update'){
		$colvalue ="'".$colvalue."'";
		
		
		$colnames_array = explode(",",$colnames);
		$teller = 0;
		foreach($colnames_array as $colname_unformat){
			$set =$set.",". $colname_unformat."='".$colvalues_array[$teller]."'"; 
			$teller++;
			}
		$set = substr($set,1);
		
		
		$sql = "UPDATE $tablename SET $set WHERE $colname=$colvalue";
		//echo 'UPDATE '.$tablename.' '.$set.' WHERE '.$colname.'='.$colvalue."<br>";

		if ($conn->query($sql) === TRUE) {
			$return = "Gegevens opgeslagen";
		} else {
			$return = "Error updating record: " . $conn->error;
		}
	}
	////////////////////////////////////////////////////////

	
   return $return;
}
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               einde              /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------------------------------------------------//

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////            deleteFromDb          /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function deleteFromDb($tablename,$colname,$id){
	global $servername, $username, $dbpassword, $dbname, $conn;
	
	$id = "'".$id."'";
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	// sql to delete a record
	$sql = "DELETE FROM $tablename WHERE $colname=$id";
	
	if ($conn->query($sql) === TRUE) {
		$return = "Record deleted successfully";
	} else {
		$return = "Error deleting record: " . $conn->error;
	}
	return $return;
	
}
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               einde              /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------------------------------------------------//

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               makeMsg            /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function makeMsg(){
	global $msg;
	if($msg){
		echo "<msg>";
		foreach ($msg as $msg_line){
			echo $msg_line."<br>";
			}
		echo "</msg>";
		}
	
	$conn->close();	
	}

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               einde              /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------------------------------------------------//

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////              buildNav            /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function buildNav(){
	
	$page_info_array = getDataFromDb('pages','id,pagename,pagesub,pagetype'); 	
	$page_info = implode('',$page_info);
	foreach(glob("*_*.php") as $page){	$pieces = explode("_",$page); $cur_id = $pieces[0];		
		foreach($page_info_array as $page_info){
			$msg[] =  $page_info.' - '.$cur_id;
			if(strpos(' '.$page_info,$cur_id)){
				$pieces = explode("|",$page_info);
				$id = $pieces[0]; $pagename = $pieces[1]; $pagesub = $pieces[2]; $pagetype = $pieces[3];
				}
			}
		?>
		<li><a href="<?php echo $page;?>" <?php if($cur_page == $page)echo 'class="active"';?>><?php echo $pagename;?></a></li>
		<?php 
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////               einde              /////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
?>

