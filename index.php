<?php
session_start();
require_once('scripts/dbScript.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Eyepax Assignment</title>
	<!-- Latest compiled and minified CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/all.min.css" rel="stylesheet">
 
	<!-- Latest compiled and minified JavaScript -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container" style="margin-top: 25px;">
	<div class="d-flex justify-content-center">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
				<div class="card">
					<?php
					if(isset($_POST) & !empty($_POST)){
						
						 $fname = $database->sanitize($_POST['fname']);
						 $lname = $database->sanitize($_POST['lname']);
						 $email = $database->sanitize($_POST['email']);

						 $cno = $database->sanitize($_POST['cno']);
						 $working_route = $database->sanitize($_POST['working_route']);
						 $comment_of_manager = $database->sanitize($_POST['comment_of_manager']);
						 $joined_date = $_POST['joined_date'];

						if(isset($_POST['id']) && !empty($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id']>0)){
							$id = $database->sanitize($_POST['id']);
							$res = $database->update($id, $fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date);
							 if($res){
								$_SESSION['msg']['alert']= "success";
								$_SESSION['msg']['msg']= "Successfully data has been updated";
							 }else{
								$_SESSION['msg']['alert'] = "danger";
								$_SESSION['msg']['msg'] = "failed to update the data";
							 }
						}else{
							$res = $database->create($fname, $lname, $email, $cno, $working_route, $comment_of_manager, $joined_date);
							 if($res){
								$_SESSION['msg']['alert']= "success";
								$_SESSION['msg']['msg']= "Successfully inserted data";
							 }else{
								$_SESSION['msg']['alert'] = "danger";
								$_SESSION['msg']['msg'] = "failed to insert data";
							 }
						}
						 
						header('Location: '.$_SERVER['PHP_SELF']);
						exit();
					}
					
					if(isset($_SESSION['msg'])){
						echo "<div class='alert alert-".$_SESSION['msg']['alert']."' role='alert'>".$_SESSION['msg']['msg']."</div>";
						unset($_SESSION['msg']);
					}
					?>
					<div class="card-header bg-secondary">
						<b>Sales Team</b>
					</div>
					<div class="card-body">
						<h5 class="card-title text-right">
							<button type="button" class="btn btn-secondary text-dark" style="border-radius: 10px" id="add">Add new</button>
						</h5>

						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col" class="text-center">ID</th>
									<th scope="col" class="text-center">Name</th>
									<th scope="col" class="text-center">Email</th>
									<th scope="col" class="text-center">Telephone</th>
									<th scope="col" class="text-center">Current Route</th>
									<th scope="col" class="text-center"></th>
									<th scope="col" class="text-center"></th>
									<th scope="col" class="text-center"></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$res = $database->read(-1);
								while($r = mysqli_fetch_assoc($res)){
								?>
								<tr>
									<th scope="row"><?=$r['id'];?></th>
									<td class="text-center"><?=$r['fname'].' '. $r['lname'];?></td>
									<td class="text-center"><?=$r['email'];?></td>
									<td class="text-center"><?=$r['cno'];?></td>
									<td class="text-center"><?=$r['working_route'];?></td>
									<td class="text-center"><a href="#" id="<?=$r['id'];?>" class="view">View</a></td>
									<td class="text-center"><a href="#" id="<?=$r['id'];?>" class="update">Edit</a></td>
									<td class="text-center"><a href="delete.php?id=<?=$r['id'];?>">Delete</a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>		
			</div>	
		</div>
	</div>
		
</div>

<!-- Modal -->
<div id="user" class="modal fade" role="dialog">
	<form method="post" class="form-horizontal">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="full_name" class="modal-title">Create User</h4>
				<button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				
				<table>
					
					<tr id="id_">
						<th> <label class="control-label">Id</label> </th>
						<td> : </td>
						<td> <input type="number" name="id" id="id" class="form-control" value="0" readonly /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">First Name</label> </th>
						<td> : </td>
						<td> <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">Last Name</label> </th>
						<td> : </td>
						<td> <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">E-mail</label> </th>
						<td> : </td>
						<td>  <input type="email" name="email" id="email"  class="form-control" placeholder="E-Mail" required /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">Telephone</label> </th>
						<td> : </td>
						<td> <input type="number" name="cno" id="cno"  class="form-control" placeholder="Telephone" min="700000000" required /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">Joined Date</label> </th>
						<td> : </td>
						<td> <input type="date" name="joined_date" id="joined_date"  class="form-control" placeholder="Joined Date" required /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">Working Route</label> </th>
						<td> : </td>
						<td> <input type="text" name="working_route" id="working_route"  class="form-control" placeholder="Working Role" required /> </td>
					</tr>
					
					<tr>
						<th> <label class="control-label">Comment of Manager</label> </th>
						<td> : </td>
						<td> <textarea rows="3" name="comment_of_manager" id="comment_of_manager"  class="form-control"  required></textarea> </td>
					</tr>
					
				</table>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" id="submitBtn" value="Create User" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

	
<script type="text/javascript" defer>
	$( document ).ready( function (){
		$('.update').click(function() {
			var userId = this.id;  
			$.ajax( {
				url: "<?="ajax/ajax.php";?>",
				data: {'id': userId},
				dataType: "json",
				type: "POST",
				success: function (data) {
					if(data.hasOwnProperty('id')){
						$("#id").val(userId);
						$("#id_").show();
						$("#full_name").val(data['fname'] + " " + data['lname']);
						$("#fname").val(data['fname']);
						$("#lname").val(data['lname']);
						$("#email").val(data['email']);
						$("#cno").val(data['cno']);
						$("#joined_date").val(data['joined_date']);
						$("#working_route").val(data['working_route']);
						$("#comment_of_manager").val(data['comment_of_manager']);

						$("#submitBtn").val("Update User");
						$("#submitBtn").show();
						$("#user").modal();
					}
				}
			} );
		});

		$('.view').click(function() {
			var userId = this.id;  
			$.ajax( {
				url: "<?="ajax/ajax.php";?>",
				data: {'id': userId},
				dataType: "json",
				type: "POST",
				success: function (data) {
					if(data.hasOwnProperty('id')){
						$("#id").val(userId);
						$("#id_").show();
						$("#full_name").val(data['fname'] + " " + data['lname']);
						$("#fname").val(data['fname']);
						$("#lname").val(data['lname']);
						$("#email").val(data['email']);
						$("#cno").val(data['cno']);
						$("#joined_date").val(data['joined_date']);
						$("#working_route").val(data['working_route']);
						$("#comment_of_manager").val(data['comment_of_manager']);

						$("#submitBtn").hide();
						$("#user").modal();
					}
				}
			} );
		});	

		$('#add').click(function() {
			$("#id").val(0);
			$("#id_").hide();
			$("#full_name").val("Create User");
			$("#fname").val("");
			$("#lname").val("");
			$("#email").val("");
			$("#cno").val("");
			$("#joined_date").val("");
			$("#working_route").val("");
			$("#comment_of_manager").val("");

			$("#submitBtn").val("Create User");
			$("#submitBtn").show();
			$("#user").modal();
		});
	});
</script>
</body>
</html>