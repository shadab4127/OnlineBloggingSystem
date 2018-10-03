<?php 

	$id = $_GET['id'];
	$con = mysqli_connect("localhost","root","","crud");
	$result = mysqli_query($con,"SELECT * FROM article WHERE id=$id");
	if(mysqli_num_rows($result)==1)
	{
		$row = mysqli_fetch_assoc($result);
	}
	else
	{
		echo "<p class='alert alert-danger'>Data not Found</p>";
	}
 ?>
 <?php 
 			if(isset($_POST['update']))
 			{
 				$id = $_GET['id'];
 				$title = $_POST['title'];
 				$desc = $_POST['desc'];
 				$filename = $_FILES['file']['name'];
				$filetype = $_FILES['file']['type'];
				$filetmp = $_FILES['file']['tmp_name'];

				$file = substr(time().$filename,6);

				if($filetype =="image/png" || $filetype =="image/jpeg" || $filetype =="image/jpg" || $filetype =="image/gif")
				{
					
					if(move_uploaded_file($filetmp, "pictures/".$file))
					{

		 				$con = mysqli_connect("localhost","root","","crud");
		 				mysqli_query($con,"UPDATE article SET title='$title', body='$desc', image_path='$file' WHERE id=$id");
		 				if(mysqli_affected_rows($con)>0)
		 				{
		 					setcookie('update',"<div class='alert alert-success'>Data Updated Successfully.</div>",time()+3);
		 					header('location:insert.php');
		 				}
		 				else
		 				{
		 					echo "<p class='alert alert-danger'>Data Not Updated.</p>";
		 				}
		 			}
		 			else
					{
						echo "<p class='alert alert-danger'>File not Uploaded. Please try again...</p>";
					}
		 		}
		 		else
				{
					echo "<p class='alert alert-danger'>File Type is Invalid.</p>";
				}
 			}

 		 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Edit</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
 	<div class="container">
 		<h1 class="alert alert-warning text-center"> Edit Article <a href="insert.php" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-home"></i> Back</a></h1>
 		<div class="row">
 			<div class="col-sm-8">
 		<form method="post" action="" enctype="multipart/form-data">
			<div class="form-group">
				<label>Title:</label>
				<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" value="<?php echo $row['title']; ?>">
			</div>
			<div class="form-group">
				<label>Description:</label>
				<input type="text" name="desc" id="desc" class="form-control" placeholder="Enter Description" value="<?php echo $row['body']; ?>">
			</div>
			<div class="form-group">
				<label>Avatar:</label>
				<input type="file" name="file" id="file" class="form-control">
			</div>
			<input type="submit" name="update" value="Update" class="btn btn-info">
		</form>
	</div>
	<div class="col-sm-4">
		<img src="pictures/<?php echo $row['image_path'] ?>" class='img-thumbnail pull-left' style='width: 100%;height: 300px; margin-top: 25px;'>
	</div>
		</div>
 	</div>
 </body>
 </html>