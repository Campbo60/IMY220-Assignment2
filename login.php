<?php
	// See all errors and warnings
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "dbUser";
	$mysqli = mysqli_connect($server, $username, $password, $database); //change back

	$email = isset($_POST["loginEmail"]) ? $_POST["loginEmail"] : false;
	$pass = isset($_POST["loginPass"]) ? $_POST["loginPass"] : false;	
	// if email and/or pass POST values are set, set the variables to those values, otherwise make them false
?>

<!DOCTYPE html>
<html>
<head>
	<title>IMY 220 - Assignment 2</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<meta charset="utf-8" />
	<meta name="author" content="Campbell Gardiner">
	<!-- Replace Name Surname with your name and surname -->
</head>
<body>
	<div class="container">
		<?php

			if (isset($_FILES["picToUpload"])) {
				
				if ($_FILES["picToUpload"]['size'] < 1048576) {
					move_uploaded_file($_FILES["picToUpload"]['tmp_name'], "gallery/".$_FILES["picToUpload"]['name']);	
					$query = "SELECT user_id FROM tbusers WHERE email = '$email' AND password = '$pass'";
					$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res)){
					$id = $row["user_id"];
				}
					$name = $_FILES["picToUpload"]["name"];
					$query = "INSERT INTO tbgallery (user_id,filename) VALUES ('$id', '$name');";

					$res = mysqli_query($mysqli, $query) == TRUE;
				}

			}
			if($email && $pass){
				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res)){
					echo 	"<table class='table table-bordered mt-3'>
								<tr>
									<td>Name</td>
									<td>" . $row['name'] . "</td>
								<tr>
								<tr>
									<td>Surname</td>
									<td>" . $row['surname'] . "</td>
								<tr>
								<tr>
									<td>Email Address</td>
									<td>" . $row['email'] . "</td> 
								<tr>
								<tr>
									<td>Birthday</td>
									<td>" . $row['birthday'] . "</td>
								<tr>
							</table>";

				
					echo 	"<form method='POST' enctype='multipart/form-data'>
								<div class='form-group'>
									<input type='hidden' class='form-control' name='loginEmail' id='picToUpload' value='".$email."'/><br/>
									<input type='hidden' class='form-control' name='loginPass' id='picToUpload' value='".$pass."'/><br/>
									<input type='file' class='form-control' name='picToUpload' id='picToUpload' accept='.jpg, .jpeg'/><br/>
									<input type='submit' class='btn btn-standard' value='Upload Image' name='submit' />
								</div>
						  	</form>
						  	<h2>Image Gallery</h2>

						  	<div class='container'>
  							<div class='row imageGallery'>";
  							$id = $row["user_id"];
  							
							$query = "SELECT * FROM tbgallery WHERE $id = '$id'";
								$res = $mysqli->query($query);
								while($row = $res->fetch_row()){
									$imgName =$row[2];
								 	echo	"<div class='col-3' style='background-image: url(gallery/$imgName)'>
											</div>
									  		";
								 }
							
					
				}
				else{
					echo 	'<div class="alert alert-danger mt-3" role="alert">
	  							You are not registered on this site!
	  						</div>';
				}
			} 
			else{
				echo 	'<div class="alert alert-danger mt-3" role="alert">
	  						Could not log you in
	  					</div>';
			}
		?>
	</div>
</body>
</html>