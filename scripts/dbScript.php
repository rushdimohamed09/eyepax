<?php
 
class Database{
	
	private $connection;
 
	function __construct()
	{
		$this->connect_db();
	}
 
	public function connect_db(){
		$this->connection = mysqli_connect('localhost', 'root', '', 'eyepax');
		if(mysqli_connect_error()){
			die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_errno());
		}
	}
 
	public function create($fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date){
		$sql = "INSERT INTO `users` (fname, lname, email, cno, working_route, comment_of_manager, joined_date) VALUES ('$fname', '$lname', '$email', '$cno', '$working_route', '$comment_of_manager', '$joined_date')";
		$res = mysqli_query($this->connection, $sql);
		if($res){
	 		return true;
		}else{
			return false;
		}
	}
 
	public function read($id){
		$sql = "SELECT * FROM `users`";
		//-1 means fetch all users
		if($id!=-1){ $sql .= " WHERE id=$id";}
 		$res = mysqli_query($this->connection, $sql);
 		return $res;
	}
 
	public function update($id, $fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date){
		$sql = "UPDATE `users` SET fname='$fname', lname='$lname', email='$email', cno='$cno', working_route='$working_route', comment_of_manager='$comment_of_manager', joined_date='$joined_date' WHERE id=$id";
		$res = mysqli_query($this->connection, $sql);
		if($res){
			return true;
		}else{
			return false;
		}
	}
 
	public function delete($id){
		$sql = "DELETE FROM `users` WHERE id=$id";
 		$res = mysqli_query($this->connection, $sql);
 		if($res){
 			return true;
 		}else{
 			return false;
 		}
	}
 
	public function sanitize($var){
		$return = mysqli_real_escape_string($this->connection, $var);
		return $return;
	}
 
}
 
$database = new Database();
 
?>