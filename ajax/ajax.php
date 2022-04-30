<?php
 

if(isset($_POST) & !empty($_POST) && isset($_POST['id'])){
	require_once('../scripts/dbScript.php');
	
	if(is_numeric($_POST['id'])){
		$id = $database->sanitize($_POST['id']);
		$res = $database->read($id);
		echo json_encode(mysqli_fetch_assoc($res));
	}else{
		echo json_encode(array('error'=>"error"));
	}
}else{
	echo json_encode(array('error'=>"error"));
}
exit();

 
?>