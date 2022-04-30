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
		$sql = "INSERT INTO `users` (fname, lname, email, cno, working_route, comment_of_manager, joined_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$res = mysqli_prepare($this->connection, $sql);
		if($res){
			mysqli_stmt_bind_param($res, "sssssss", $fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date);
			if(mysqli_stmt_execute($res)){
				$res = true;
			}else{
				$res = false;
			}
			mysqli_stmt_close($res);
			return $res;
		}else{
			return false;
		}
	}
 
	public function read($id){
		$sql="SELECT id, fname, lname, email, cno, working_route, joined_date, comment_of_manager FROM `users`";
		//-1 means fetch all users
		if($id!=-1){ $sql .= " WHERE id=?";}
		$data=array();
		$stmt = mysqli_prepare($this->connection,$sql);
		if ($stmt) {
			if($id!=-1){ mysqli_stmt_bind_param($stmt, 's', $id);}
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $id, $fname, $lname, $email, $cno, $working_route, $joined_date, $comment_of_manager);
			
			mysqli_stmt_store_result($stmt);
			if (mysqli_stmt_num_rows($stmt)>0) {
				while ($r = mysqli_stmt_fetch($stmt)) {
					$data[]=array('id'=>$id, 'fname'=>$fname, 'lname'=>$lname, 'email'=>$email, 'cno'=>$cno, 'working_route'=>$working_route, 'joined_date'=>$joined_date, 'comment_of_manager'=>$comment_of_manager);
				}
			}
		}
		
		mysqli_stmt_close($stmt);
		return (json_encode($data));
		exit();
	}
 
	public function update($id, $fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date){
		$sql = "UPDATE `users` SET fname=?, lname=?, email=?, cno=?, working_route=?, comment_of_manager=?, joined_date=? WHERE id=?";
		$res = mysqli_prepare($this->connection, $sql);
		if($res){
			mysqli_stmt_bind_param($res, "ssssssss",$fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date, $id);
			if(mysqli_stmt_execute($res)){
				$res = true;
			}else{
				$res = false;
			}
			mysqli_stmt_close($res);
			return $res;
		}else{
			return false;
		}
	}
 
	public function delete($id){
		$sql = "DELETE FROM `users` WHERE id=(?)";
		$res = mysqli_prepare($this->connection, $sql);
		if($res){
			mysqli_stmt_bind_param($res, "s",$id);
			if(mysqli_stmt_execute($res)){
				$res = true;
			}else{
				$res = false;
			}
			mysqli_stmt_close($res);
			return $res;
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