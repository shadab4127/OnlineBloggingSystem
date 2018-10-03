<?php 

	$id = $_GET['id1'];
	$con = mysqli_connect("localhost","root","","crud");
	mysqli_query($con,"DELETE FROM article WHERE id=$id");
	if(mysqli_affected_rows($con)==1)
	{
		setcookie('delete',"<div class='alert alert-success'><strong>Data Deleted Successfully.</strong></div>",time()+3);
		header('location:insert.php');
	}
	else
	{
		setcookie('delete',"<div class='alert alert-danger'><strong>Data not Deleted Successfully.</strong></div>",time()+3);
		header('location:insert.php');
	}

 ?>