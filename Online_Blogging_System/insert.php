<!DOCTYPE html>
<html>
<head>
	<title>Online Blogging System</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	function validate()
	{
		var cond = confirm('Do you want to Delete?');
		if(cond)
			return true;
		else
			return false;
	}
	$(document).ready(function(){
		$('#show').click(function(){

			if($('#show').html()=="Show Records")
			{
				$(this).html("Hide Records");
				$('#records').show(1000);
				$('#show').css('background-color','green');
			}
			else
			{
				$(this).html("Show Records");
				$('#records').hide(1000);
				$('#show').css('background-color','red');
			}
		});
	});
</script>
<style type="text/css">
	div#records{
		display: none;
	}
</style>
</head>
<body>
	<div class="container"><br><br><br>
		<h1 class="text-center alert alert-success">Online Blogging System</h1>
		<?php 

			if(isset($_POST['submit']))
			{
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

						mysqli_query($con, "INSERT INTO article(title,body,image_path) VALUES('$title','$desc','$file')");
						if(mysqli_affected_rows($con)>0)
						{
							setcookie('insert','<p class="alert alert-success">Data Inserted Successfullly.</p>',time()+3);
							header('location:insert.php');
						}
						else
						{
							setcookie('insert','<p class="alert alert-danger">Data not Inserted Successfullly.</p>',time()+3);
							header('location:insert.php');
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

			if(isset($_COOKIE['insert']))
			{
				echo $_COOKIE['insert'];
			}
			if(isset($_COOKIE['update']))
			{
				echo $_COOKIE['update'];
			}
			if(isset($_COOKIE['delete']))
			{
				echo $_COOKIE['delete'];
			}
		 ?>
		<form method="post" action="" enctype="multipart/form-data">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
				<input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
			</div>
			<br>
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
				<input type="text" name="desc" id="desc" class="form-control" placeholder="Enter Description">
			</div>
			<br>
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
				<input type="file" name="file" id="file" class="form-control">
			</div>
			<br>
			<button type="submit" name="submit" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i> Submit</button>
		</form>
			<button type="button" class="btn btn-info btn-lg pull-right" id="show">Show Records</button>
			<br><br><br>
			<div id="records">
			<h1 class="text-center alert alert-danger">Records</h1>

		<?php 

			$con = mysqli_connect("localhost","root","","crud");
			$result = mysqli_query($con,"SELECT * FROM article");
			if(mysqli_num_rows($result)>0)
			{
				?>
				<table class="table table-striped table-bordered">
					<tr>
						
						<th>Title</th>
						<th>Description</th>
						<th>Avatar</th>
						<th>Action</th>
					</tr>
					<?php 

						while($row = mysqli_fetch_array($result))
						{
							?>
							<tr>
								
								<td><?php echo strtoupper($row['title']); ?></td>
								<td><?php echo ucfirst($row['body']); ?></td>
								<?php 

								if($row['image_path']!='')
								{

									?>
								<td><img src="pictures/<?php echo $row['image_path']; ?>" style="width: 200px;height: 200px;" class='img-thumbnail'></td>
									<?php
								}
								else
								{
									?>
									<td>Image not Found.</td>
									<?php
								}

								 ?>
								<td><a href="edit.php?id=<?php echo  $row['id']; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i> Edit</a>
									<a href="delete.php?id1=<?php echo $row['id']; ?>" class='btn btn-danger pull-right' onclick="return validate()"><i class="glyphicon glyphicon-trash"></i> Delete</a>
									
								</td>
							</tr>
							<?php
						}	
					 ?>
					 <tr class="success">
					 	<th colspan="4"><?php echo "Number of Record(s) : ". mysqli_num_rows($result); ?></th>
					 </tr>
				</table>
				<?php
			}
			else
			{
				echo "<h6 class='alert alert-warning'>Data not Found.</h6>";
			}
		 ?>
		</div>
	</div>
</body>
</html>