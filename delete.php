<?php
session_start();
require_once('scripts/dbScript.php');
$id = $_GET['id'];

$res = $database->delete($id);
if($res){
	$_SESSION['msg']['alert']= "success";
	$_SESSION['msg']['msg']= "Successfully the date has been deleted";
}else{
	$_SESSION['msg']['alert']= "danger";
	$_SESSION['msg']['msg']= "Failed to Delete Record";
}
header('location: index.php');
exit();
?>